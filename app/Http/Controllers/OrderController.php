<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use App\Models\Region;
use App\Models\DeliveryCharge;
use App\Models\Product;
use App\Models\StockNotification;
use App\Models\UserNotification;
use App\Models\ShippingDiscountRule;
use App\Models\ProductOffer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Services\WhatsAppService;

class OrderController extends Controller
{
    private const ORDER_TAX_RATE = 0.08;
    private const COD_MINIMUM_AMOUNT = 5000; // Minimum order amount for Cash on Delivery (in yen)

    /**
     * Get cart items for current user (logged in or guest)
     */
    private function getCartItems()
    {
        if (Auth::check()) {
            return Cart::where('user_id', Auth::id())->with(['product.offer'])->get();
        } else {
            $sessionId = session()->getId();
            return Cart::where('session_id', $sessionId)
                      ->whereNull('user_id')
                      ->with(['product.offer'])
                      ->get();
        }
    }

    /**
     * Calculate the total net weight of the items currently in the cart
     */
    private function calculateCartWeight($cartItems): float
    {
        if (!$cartItems) {
            return 0;
        }

        return $cartItems->sum(function ($item) {
            $productWeight = optional($item->product)->net_weight ?? 0;
            return (float) $productWeight * $item->quantity;
        });
    }

    /**
     * Calculate tax amount based on subtotal using configured rate
     */
    private function calculateTaxAmount(float $subtotal): float
    {
        if ($subtotal <= 0) {
            return 0;
        }

        return round($subtotal * self::ORDER_TAX_RATE, 2);
    }

    /**
     * Determine the delivery charge based on weight ranges
     * - 0-10kg: Use one 0-10kg box
     * - 10-24kg: Use one 10-24kg box
     * - >24kg: Use multiple 10-24kg boxes only (for user convenience)
     */
    private function calculateDeliveryChargeAmount(?DeliveryCharge $deliveryCharge, float $totalWeight): float
    {
        if (!$deliveryCharge || $totalWeight <= 0) {
            return 0;
        }

        $priceTenKg = (float) $deliveryCharge->price_0_10kg;
        $priceTwentyFourKg = (float) $deliveryCharge->price_10_24kg;

        if ($priceTenKg <= 0 && $priceTwentyFourKg <= 0) {
            return 0;
        }

        // If weight is 10kg or less, use 0-10kg box
        if ($totalWeight <= 10) {
            return $priceTenKg > 0 ? $priceTenKg : 0;
        }

        // If weight is more than 10kg but 24kg or less, use one 10-24kg box
        if ($totalWeight <= 24) {
            return $priceTwentyFourKg > 0 ? $priceTwentyFourKg : 0;
        }

        // If weight is more than 24kg, use multiple 10-24kg boxes only
        // This is better for the user (e.g., 40kg = 2 boxes of 10-24kg)
        if ($priceTwentyFourKg > 0) {
            $boxCount = (int) ceil($totalWeight / 24);
            return $boxCount * $priceTwentyFourKg;
        }

        return 0;
    }

    /**
     * Calculate frozen item charge based on box configuration
     * Only applies if order contains frozen items
     * - If shipping uses a small box (0-10kg): ¥670
     * - If shipping uses only large boxes (10-24kg): ¥870
     * Note: Frozen charge is NOT multiplied by number of frozen items or boxes
     */
    private function calculateFrozenCharge($cartItems, float $totalWeight): float
    {
        if (!$cartItems) {
            return 0;
        }

        // Check if order contains any frozen items
        $hasFrozenItems = $cartItems->contains(function ($item) {
            return $item->product && $item->product->is_frozen;
        });

        // If no frozen items, no frozen charge
        if (!$hasFrozenItems) {
            return 0;
        }

        // Determine box configuration based on total weight
        // If weight <= 10kg: use 1 small box → frozen cost = ¥670
        if ($totalWeight <= 10) {
            return 670;
        }

        // If weight 10-24kg: use 1 large box → frozen cost = ¥870
        if ($totalWeight <= 24) {
            return 870;
        }

        // If weight > 24kg: calculate box configuration
        $largeBoxes = (int) floor($totalWeight / 24);
        $remainingWeight = $totalWeight - ($largeBoxes * 24);

        // If remaining weight fits in small box (0-10kg) → frozen cost = ¥670
        if ($remainingWeight > 0 && $remainingWeight <= 10) {
            return 670;
        }

        // Otherwise, using only large boxes → frozen cost = ¥870
        return 870;
    }

    /**
     * Count rice products in cart
     * If a specific rice product is defined in the rule, count only that product
     * Otherwise, count all products that might be rice (determined by weight)
     */
    private function countRiceProducts($cartItems, $riceProductId = null, $riceWeightPerUnit = 5.0): int
    {
        if (!$cartItems) {
            return 0;
        }

        return $cartItems->sum(function ($item) use ($riceProductId, $riceWeightPerUnit) {
            if (!$item->product) {
                return 0;
            }

            // If specific rice product is defined, count only that product
            if ($riceProductId && $item->product_id == $riceProductId) {
                return $item->quantity;
            }

            // Otherwise, count products with matching weight (assumed to be rice)
            if (!$riceProductId && abs($item->product->net_weight - $riceWeightPerUnit) < 0.01) {
                return $item->quantity;
            }

            return 0;
        });
    }

    /**
     * Find applicable shipping discount rule for the current order
     */
    private function findApplicableDiscountRule($cartItems, $regionId, $subtotal, $totalWeight)
    {
        // Get all active rules for this region
        $rules = ShippingDiscountRule::where('region_id', $regionId)
            ->where('is_active', true)
            ->orderBy('discount_percentage', 'desc') // Prioritize higher discounts
            ->get();

        foreach ($rules as $rule) {
            // Check if order meets minimum amount and weight requirements
            if ($subtotal < $rule->min_order_amount || $totalWeight < $rule->min_order_weight) {
                continue;
            }

            // Count rice products in cart
            $riceCount = $this->countRiceProducts($cartItems, $rule->rice_product_id, $rule->rice_weight_per_unit);

            // Check if rice count is within the rule's range
            if ($riceCount < $rule->min_rice_count) {
                continue;
            }

            if ($rule->max_rice_count !== null && $riceCount > $rule->max_rice_count) {
                continue;
            }

            // All conditions met, return this rule
            return $rule;
        }

        return null;
    }

    /**
     * Calculate discounted delivery charge with weight limit support
     * 
     * If a weight limit is set (e.g., 24kg), free shipping only applies up to that weight.
     * For weight exceeding the limit, we calculate shipping for the excess weight only.
     * 
     * Example: Order is 30kg, limit is 24kg, region has 10-24kg price of ¥1500
     * - Free shipping for first 24kg
     * - Excess weight: 30 - 24 = 6kg (needs small box)
     * - Charge for 6kg using 0-10kg pricing
     * 
     * @param float $deliveryChargeAmount Original full delivery charge
     * @param ShippingDiscountRule|null $discountRule The applicable discount rule
     * @param float $totalWeight Total order weight
     * @param DeliveryCharge|null $deliveryCharge Delivery charge record for price lookup
     * @return array ['final_charge' => float, 'excess_weight' => float, 'excess_charge' => float, 'is_partial' => bool]
     */
    private function applyShippingDiscountWithWeightLimit(
        float $deliveryChargeAmount, 
        ?ShippingDiscountRule $discountRule, 
        float $totalWeight,
        ?DeliveryCharge $deliveryCharge = null
    ): array {
        $result = [
            'final_charge' => $deliveryChargeAmount,
            'excess_weight' => 0,
            'excess_charge' => 0,
            'is_partial' => false,
            'free_shipping_weight' => 0,
        ];

        if (!$discountRule || $deliveryChargeAmount <= 0) {
            return $result;
        }

        $discountPercentage = $discountRule->discount_percentage;
        $maxWeightLimit = $discountRule->max_weight_limit ? (float) $discountRule->max_weight_limit : null;

        // If no weight limit or weight is within limit, apply full discount
        if ($maxWeightLimit === null || $totalWeight <= $maxWeightLimit) {
            $discountAmount = $deliveryChargeAmount * ($discountPercentage / 100);
            $result['final_charge'] = max(0, $deliveryChargeAmount - $discountAmount);
            $result['free_shipping_weight'] = $totalWeight;
            return $result;
        }

        // Weight exceeds limit - apply partial free shipping
        $result['is_partial'] = true;
        $result['excess_weight'] = $totalWeight - $maxWeightLimit;
        $result['free_shipping_weight'] = $maxWeightLimit;

        // Calculate shipping charge for excess weight only
        if ($deliveryCharge) {
            $result['excess_charge'] = $this->calculateDeliveryChargeAmount($deliveryCharge, $result['excess_weight']);
        }

        // For 100% discount (free shipping), only charge for excess
        // For partial discount (e.g., 50%), calculate proportionally
        if ($discountPercentage >= 100) {
            $result['final_charge'] = $result['excess_charge'];
        } else {
            // Calculate what the charge would be for the limited weight
            $chargeForLimitedWeight = $deliveryCharge 
                ? $this->calculateDeliveryChargeAmount($deliveryCharge, $maxWeightLimit) 
                : 0;
            
            // Apply discount to the limited weight portion
            $discountedLimitedCharge = $chargeForLimitedWeight * (1 - $discountPercentage / 100);
            
            // Total = discounted charge for limited weight + full charge for excess
            $result['final_charge'] = $discountedLimitedCharge + $result['excess_charge'];
        }

        return $result;
    }

    /**
     * Legacy method for backward compatibility
     * Calculate discounted delivery charge (simple version without weight limit)
     */
    private function applyShippingDiscount(float $deliveryChargeAmount, ?ShippingDiscountRule $discountRule): float
    {
        if (!$discountRule || $deliveryChargeAmount <= 0) {
            return $deliveryChargeAmount;
        }

        $discountPercentage = $discountRule->discount_percentage;

        // Calculate discount (100% = free shipping)
        $discountAmount = $deliveryChargeAmount * ($discountPercentage / 100);
        $finalAmount = $deliveryChargeAmount - $discountAmount;

        return max(0, $finalAmount); // Ensure non-negative
    }


    public function checkout()
    {
        $cartItems = $this->getCartItems();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart')->with('error', 'Your cart is empty');
        }

        $regions = Region::all();
        $totalWeight = $this->calculateCartWeight($cartItems);
        $taxRate = self::ORDER_TAX_RATE;
        $activeBankAccount = \App\Models\BankAccount::getActive();

        return view('checkout', compact('cartItems', 'regions', 'totalWeight', 'taxRate', 'activeBankAccount'));
    }

    public function process(Request $request)
    {
        // Custom validation for mobile/WhatsApp number - at least one is required
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'mobile_number' => 'nullable|string|max:20',
            'whatsapp_number' => 'nullable|string|max:20',
            'postal_code' => 'required|string|regex:/^\d{3}-\d{4}$/',
            'region_id' => 'required|exists:regions,id',
            'ken_name' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'apartment' => 'required|string',
            'payment_method' => 'required|in:cash_on_delivery,bank_transfer',
            'payment_receipt' => 'required_if:payment_method,bank_transfer|nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'delivery_date' => 'required|date|after:today',
            'delivery_time_slot' => 'required|in:8-12,12-14,14-16,16-18,18-20,19-21',
        ]);

        // Check if at least one contact number is provided
        if (empty($request->mobile_number) && empty($request->whatsapp_number)) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['mobile_number' => 'Please provide at least one contact number (Mobile or WhatsApp).']);
        }

        // Validate COD minimum amount requirement (5000 yen)
        if ($request->payment_method === 'cash_on_delivery') {
            $cartItems = $this->getCartItems();

            if ($cartItems->isEmpty()) {
                return redirect()->route('cart')->with('error', 'Your cart is empty');
            }

            $subtotal = $cartItems->sum(function ($item) {
                return $item->product->price * $item->quantity;
            });

            if ($subtotal < self::COD_MINIMUM_AMOUNT) {
                $remaining = self::COD_MINIMUM_AMOUNT - $subtotal;
                return redirect()->back()
                    ->withInput()
                    ->withErrors([
                        'payment_method' => 'Cash on Delivery requires a minimum order amount of ¥' . number_format(self::COD_MINIMUM_AMOUNT, 0) . '. Your current subtotal is ¥' . number_format($subtotal, 0) . '. Please add ¥' . number_format($remaining, 0) . ' more to your cart or select Bank Transfer as payment method.'
                    ]);
            }
        }

        DB::beginTransaction();

        try {
            $cartItems = $this->getCartItems();

            if ($cartItems->isEmpty()) {
                return redirect()->route('cart')->with('error', 'Your cart is empty');
            }

            // Calculate subtotal with discounts
            $originalSubtotal = 0;
            $totalDiscount = 0;

            foreach ($cartItems as $item) {
                $originalPrice = $item->product->price;
                $discountedPrice = $item->product->discounted_price;
                $quantity = $item->quantity;

                $originalSubtotal += $originalPrice * $quantity;
                $totalDiscount += ($originalPrice - $discountedPrice) * $quantity;
            }

            $subtotal = $originalSubtotal - $totalDiscount;
            $totalWeight = $this->calculateCartWeight($cartItems);

            $deliveryCharge = DeliveryCharge::where('region_id', $request->region_id)
                ->where('ken_name', $request->ken_name)
                ->first();

            $deliveryChargeAmount = $this->calculateDeliveryChargeAmount($deliveryCharge, $totalWeight);

            // Find and apply shipping discount if applicable (with weight limit support)
            $discountRule = $this->findApplicableDiscountRule($cartItems, $request->region_id, $subtotal, $totalWeight);
            $discountResult = $this->applyShippingDiscountWithWeightLimit(
                $deliveryChargeAmount, 
                $discountRule, 
                $totalWeight, 
                $deliveryCharge
            );
            $deliveryChargeAmount = $discountResult['final_charge'];

            // Calculate frozen charge (flat per-order fee based on total order weight)
            $frozenCharge = $this->calculateFrozenCharge($cartItems, $totalWeight);

            // Calculate tax on subtotal only (items)
            $taxAmount = $this->calculateTaxAmount($subtotal);

            $paymentReceiptPath = null;
            if ($request->payment_method === 'bank_transfer' && $request->hasFile('payment_receipt')) {
                $file = $request->file('payment_receipt');
                $filename = time() . '_' . $file->getClientOriginalName();
                $paymentReceiptPath = $file->storeAs('payment_receipts', $filename, 'public');
            }

            // Auto-approve COD orders, bank transfer orders remain pending for admin approval
            $orderStatus = $request->payment_method === 'cash_on_delivery' ? 'approved' : 'pending';

            $order = Order::create([
                'user_id' => Auth::check() ? Auth::id() : null,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'mobile_number' => $request->mobile_number,
                'whatsapp_number' => $request->whatsapp_number,
                'postal_code' => $request->postal_code,
                'region_id' => $request->region_id,
                'ken_name' => $request->ken_name,
                'city' => $request->city,
                'apartment' => $request->apartment,
                'payment_method' => $request->payment_method,
                'payment_receipt' => $paymentReceiptPath,
                'delivery_date' => $request->delivery_date,
                'delivery_time_slot' => $request->delivery_time_slot,
                'subtotal' => $subtotal,
                'discount_amount' => $totalDiscount,
                'delivery_charge' => $deliveryChargeAmount,
                'frozen_charge' => $frozenCharge,
                'tax_amount' => $taxAmount,
                'total_amount' => $subtotal + $taxAmount + $deliveryChargeAmount + $frozenCharge,
                'status' => $orderStatus,
            ]);

            // Create order items (stock will be decremented when admin approves)
            foreach ($cartItems as $item) {
                $originalPrice = $item->product->price;
                $discountedPrice = $item->product->discounted_price;
                $discountPercentage = $item->product->discount_percentage;
                $itemDiscount = ($originalPrice - $discountedPrice) * $item->quantity;

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $discountedPrice,
                    'original_price' => $originalPrice,
                    'discount_percentage' => $discountPercentage,
                    'discount_amount' => $itemDiscount,
                    'subtotal' => $discountedPrice * $item->quantity,
                ]);
            }

            // Clear cart based on user type
            if (Auth::check()) {
                Cart::where('user_id', Auth::id())->delete();
            } else {
                $sessionId = session()->getId();
                Cart::where('session_id', $sessionId)
                    ->whereNull('user_id')
                    ->delete();
            }

            // Create notification based on payment method
            if ($request->payment_method === 'cash_on_delivery') {
                // COD orders are auto-approved
                $this->createUserNotification(
                    $order->user_id,
                    $order->id,
                    'order_approved',
                    'Order Approved',
                    "Your Cash on Delivery order #{$order->id} has been approved and will be processed soon. Total: ¥" . number_format($order->total_amount, 0)
                );
            } else {
                // Bank transfer orders await approval
                $this->createUserNotification(
                    $order->user_id,
                    $order->id,
                    'order_placed',
                    'Order Placed Successfully',
                    "Your order #{$order->id} has been placed successfully and is awaiting admin approval. Total: ¥" . number_format($order->total_amount, 0)
                );
            }

            DB::commit();

            // Generate WhatsApp notification link for admin
            try {
                // Reload order with items to ensure they're available
                $orderWithItems = Order::with('items.product')->find($order->id);
                $whatsappMessage = WhatsAppService::formatOrderMessage($orderWithItems);
                $whatsappLink = WhatsAppService::generateAdminLink($whatsappMessage);
                session(['whatsapp_notification_link' => $whatsappLink]);

                \Log::info('WhatsApp notification link generated', [
                    'order_id' => $order->id,
                    'link_length' => strlen($whatsappLink),
                    'message_length' => strlen($whatsappMessage)
                ]);
            } catch (\Exception $e) {
                // Log error but don't fail the order
                \Log::error('Failed to generate WhatsApp notification: ' . $e->getMessage());
            }

            return redirect()->route('order.success', $order->id)
                ->with('success', 'Order placed successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to place order. Please try again.');
        }
    }

    public function success($orderId)
    {
        $order = Order::with(['items.product', 'region'])
            ->where('id', $orderId);

        // For logged-in users, verify ownership
        if (Auth::check()) {
            $order->where('user_id', Auth::id());
        } else {
            // For guests, verify by email from session or allow direct access
            // (you could store order ID in session for better security)
            $order->whereNull('user_id');
        }

        $order = $order->firstOrFail();

        return view('order-success', compact('order'));
    }

    public function adminOrders()
    {
        $orders = Order::with(['user', 'region', 'items'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.orders', compact('orders'));
    }

    public function orderManagerOrders()
    {
        $orders = Order::with(['user', 'region', 'items'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('order-manager.orders', compact('orders'));
    }

    public function approveOrder($orderId)
    {
        DB::beginTransaction();

        try {
            $order = Order::with('items.product')->findOrFail($orderId);

            // Check if order is already approved to prevent double stock deduction
            if ($order->status === 'approved') {
                return redirect()->back()->with('info', 'This order is already approved.');
            }

            // Reduce stock for each product in the order
            foreach ($order->items as $item) {
                $product = $item->product;

                // Check if enough stock is available
                if ($product->stock < $item->quantity) {
                    DB::rollBack();
                    return redirect()->back()->with('error', "Not enough stock for '{$product->product_name}'. Available: {$product->stock}, Required: {$item->quantity}");
                }

                // Reduce stock
                $product->stock -= $item->quantity;
                $product->save();

                // Check if stock is low or out of stock and create notification
                $this->checkAndCreateStockNotification($product);
            }

            // Calculate coins earned (0.05% of subtotal)
            $coinsEarned = round($order->subtotal * 0.0005, 2);

            // Update order status to approved and set coins earned
            $order->update([
                'status' => 'approved',
                'coins_earned' => $coinsEarned,
            ]);

            // Award coins to user if order belongs to registered user
            if ($order->user_id) {
                $user = $order->user;
                $user->coins += $coinsEarned;
                $user->save();
            }

            // Create notification for order approved
            $this->createUserNotification(
                $order->user_id,
                $order->id,
                'order_approved',
                'Order Approved',
                "Great news! Your order #{$order->id} has been approved by the admin and is now being processed. You earned " . number_format($coinsEarned, 2) . " coins!"
            );

            DB::commit();

            return redirect()->back()->with('success', 'Order approved successfully and stock updated! User earned ' . number_format($coinsEarned, 2) . ' coins.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to approve order: ' . $e->getMessage());
        }
    }

    /**
     * Get notification data based on order status
     */
    private function getNotificationDataForStatus($status, $orderId)
    {
        $notifications = [
            'approved' => [
                'type' => 'order_approved',
                'title' => 'Order Approved',
                'message' => "Great news! Your order #{$orderId} has been approved and is now being processed."
            ],
            'shipped' => [
                'type' => 'order_shipped',
                'title' => 'Order Shipped',
                'message' => "Your order #{$orderId} has been shipped and is on its way to you!"
            ],
            'delivered' => [
                'type' => 'order_delivered',
                'title' => 'Order Delivered',
                'message' => "Your order #{$orderId} has been delivered to your address. Please confirm receipt."
            ],
            'completed' => [
                'type' => 'order_completed',
                'title' => 'Order Completed',
                'message' => "Your order #{$orderId} has been completed successfully. Thank you for shopping with us!"
            ],
            'cancelled' => [
                'type' => 'order_cancelled',
                'title' => 'Order Cancelled',
                'message' => "Your order #{$orderId} has been cancelled. If you have any questions, please contact our support team."
            ]
        ];

        return $notifications[$status] ?? null;
    }

    /**
     * Create user notification for order status changes
     */
    private function createUserNotification($userId, $orderId, $type, $title, $message)
    {
        if ($userId) {
            UserNotification::create([
                'user_id' => $userId,
                'order_id' => $orderId,
                'type' => $type,
                'title' => $title,
                'message' => $message,
                'is_read' => false,
            ]);
        }
    }

    /**
     * Check stock level and create notification if low
     */
    private function checkAndCreateStockNotification(Product $product)
    {
        $threshold = 10;

        if ($product->stock == 0) {
            // Out of stock notification
            StockNotification::create([
                'product_id' => $product->id,
                'product_name' => $product->product_name,
                'current_stock' => $product->stock,
                'threshold' => $threshold,
                'message' => "Product '{$product->product_name}' is OUT OF STOCK!",
                'type' => 'out_of_stock',
            ]);
        } elseif ($product->stock <= $threshold) {
            // Low stock notification - check if notification already exists for this stock level
            $existingNotification = StockNotification::where('product_id', $product->id)
                ->where('current_stock', $product->stock)
                ->where('is_read', false)
                ->first();

            if (!$existingNotification) {
                StockNotification::create([
                    'product_id' => $product->id,
                    'product_name' => $product->product_name,
                    'current_stock' => $product->stock,
                    'threshold' => $threshold,
                    'message' => "Low stock alert! Product '{$product->product_name}' has only {$product->stock} items remaining.",
                    'type' => 'low_stock',
                ]);
            }
        }
    }

    public function updateStatus(Request $request, $orderId)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,shipped,delivered,completed,cancelled',
        ]);

        DB::beginTransaction();

        try {
            $order = Order::with('items.product')->findOrFail($orderId);
            $previousStatus = $order->status;
            $newStatus = $request->status;

            // Handle status changes that affect stock and coins
            if ($newStatus === 'approved' && $previousStatus !== 'approved') {
                // Approve order - decrement stock and award coins
                foreach ($order->items as $item) {
                    $product = $item->product;

                    // Check if enough stock is available
                    if ($product->stock < $item->quantity) {
                        DB::rollBack();
                        return redirect()->back()->with('error', "Not enough stock for '{$product->product_name}'. Available: {$product->stock}, Required: {$item->quantity}");
                    }

                    // Reduce stock
                    $product->stock -= $item->quantity;
                    $product->save();

                    // Check if stock is low or out of stock and create notification
                    $this->checkAndCreateStockNotification($product);
                }

                // Calculate and award coins (0.05% of subtotal)
                $coinsEarned = round($order->subtotal * 0.0005, 2);
                $order->coins_earned = $coinsEarned;

                // Award coins to user if order belongs to registered user
                if ($order->user_id) {
                    $user = $order->user;
                    $user->coins += $coinsEarned;
                    $user->save();
                }
            } elseif ($newStatus === 'cancelled' && $previousStatus === 'approved') {
                // Cancelling an approved order - restore stock and deduct coins
                foreach ($order->items as $item) {
                    $product = $item->product;
                    $product->stock += $item->quantity;
                    $product->save();
                }

                // Deduct coins if they were awarded
                if ($order->user_id && $order->coins_earned > 0) {
                    $user = $order->user;
                    $user->coins -= $order->coins_earned;
                    $user->coins = max(0, $user->coins); // Ensure coins don't go negative
                    $user->save();
                }
            }
            // If cancelling a pending order, no stock changes needed as stock was never deducted

            $order->update([
                'status' => $newStatus,
            ]);

            // Create notification based on status change
            $notificationData = $this->getNotificationDataForStatus($newStatus, $order->id);
            if ($notificationData && $previousStatus !== $newStatus) {
                $this->createUserNotification(
                    $order->user_id,
                    $order->id,
                    $notificationData['type'],
                    $notificationData['title'],
                    $notificationData['message']
                );
            }

            DB::commit();

            return redirect()->back()->with('success', 'Order status updated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to update order status: ' . $e->getMessage());
        }
    }

    public function getDeliveryCharges($regionId)
    {
        $deliveryCharges = DeliveryCharge::where('region_id', $regionId)->get();
        return response()->json($deliveryCharges);
    }

    public function getAllDeliveryCharges()
    {
        $deliveryCharges = DeliveryCharge::all();
        return response()->json($deliveryCharges);
    }

    /**
     * Check if a region has free shipping rules available
     * Used for the progress bar in checkout
     */
    public function checkFreeShippingAvailability(Request $request)
    {
        $regionId = $request->input('region_id');

        if (!$regionId) {
            return response()->json([
                'has_free_shipping_rule' => false,
                'rule' => null,
            ]);
        }

        // Find the most generous free shipping rule for this region (100% discount)
        $rule = ShippingDiscountRule::where('region_id', $regionId)
            ->where('is_active', true)
            ->where('discount_percentage', '>=', 100) // Free shipping rules only
            ->orderBy('min_order_amount', 'asc') // Prioritize the easiest to achieve
            ->first();

        if ($rule) {
            return response()->json([
                'has_free_shipping_rule' => true,
                'rule' => [
                    'id' => $rule->id,
                    'rule_name' => $rule->rule_name,
                    'min_order_amount' => $rule->min_order_amount,
                    'min_order_weight' => $rule->min_order_weight,
                    'min_rice_count' => $rule->min_rice_count,
                    'max_weight_limit' => $rule->max_weight_limit,
                    'discount_percentage' => $rule->discount_percentage,
                    'description' => $rule->description,
                ],
            ]);
        }

        return response()->json([
            'has_free_shipping_rule' => false,
            'rule' => null,
        ]);
    }

    public function calculateShippingDiscount(Request $request)
    {
        $regionId = $request->input('region_id');
        $subtotal = (float) $request->input('subtotal', 0);
        $totalWeight = (float) $request->input('total_weight', 0);

        $cartItems = $this->getCartItems();

        // Debug info
        $debug = [
            'received_params' => [
                'region_id' => $regionId,
                'subtotal' => $subtotal,
                'total_weight' => $totalWeight,
            ],
            'cart_items_count' => $cartItems->count(),
            'cart_items' => $cartItems->map(fn($item) => [
                'product_id' => $item->product_id,
                'product_name' => $item->product->product_name ?? 'N/A',
                'quantity' => $item->quantity,
                'weight' => $item->product->net_weight ?? 0,
                'price' => $item->product->price ?? 0,
            ]),
        ];

        if ($cartItems->isEmpty()) {
            return response()->json([
                'has_discount' => false,
                'discount_percentage' => 0,
                'original_charge' => 0,
                'discounted_charge' => 0,
                'rule_name' => null,
                'debug' => array_merge($debug, ['error' => 'Cart is empty']),
            ]);
        }

        // Count rice products
        $riceCount = $this->countRiceProducts($cartItems, null, 5.0);
        $debug['rice_count'] = $riceCount;

        // Get all active rules for this region
        $rules = ShippingDiscountRule::where('region_id', $regionId)
            ->where('is_active', true)
            ->orderBy('discount_percentage', 'desc')
            ->get();

        $debug['rules_found'] = $rules->count();
        $debug['rules_checked'] = [];

        foreach ($rules as $rule) {
            $ruleDebug = [
                'rule_id' => $rule->id,
                'rule_name' => $rule->rule_name,
                'min_amount' => $rule->min_order_amount,
                'min_weight' => $rule->min_order_weight,
                'min_rice' => $rule->min_rice_count,
                'max_rice' => $rule->max_rice_count,
                'discount' => $rule->discount_percentage,
                'checks' => [],
            ];

            if ($subtotal < $rule->min_order_amount) {
                $ruleDebug['checks'][] = "FAIL: Subtotal {$subtotal} < {$rule->min_order_amount}";
            } else {
                $ruleDebug['checks'][] = "PASS: Subtotal {$subtotal} >= {$rule->min_order_amount}";
            }

            if ($totalWeight < $rule->min_order_weight) {
                $ruleDebug['checks'][] = "FAIL: Weight {$totalWeight} < {$rule->min_order_weight}";
            } else {
                $ruleDebug['checks'][] = "PASS: Weight {$totalWeight} >= {$rule->min_order_weight}";
            }

            if ($riceCount < $rule->min_rice_count) {
                $ruleDebug['checks'][] = "FAIL: Rice count {$riceCount} < {$rule->min_rice_count}";
            } else {
                $ruleDebug['checks'][] = "PASS: Rice count {$riceCount} >= {$rule->min_rice_count}";
            }

            if ($rule->max_rice_count !== null && $riceCount > $rule->max_rice_count) {
                $ruleDebug['checks'][] = "FAIL: Rice count {$riceCount} > {$rule->max_rice_count}";
            } else {
                $ruleDebug['checks'][] = "PASS: Rice count within range";
            }

            $debug['rules_checked'][] = $ruleDebug;
        }

        $discountRule = $this->findApplicableDiscountRule($cartItems, $regionId, $subtotal, $totalWeight);

        if (!$discountRule) {
            return response()->json([
                'has_discount' => false,
                'discount_percentage' => 0,
                'original_charge' => 0,
                'discounted_charge' => 0,
                'rule_name' => null,
                'debug' => array_merge($debug, ['result' => 'No matching rule found']),
            ]);
        }

        return response()->json([
            'has_discount' => true,
            'discount_percentage' => $discountRule->discount_percentage,
            'max_weight_limit' => $discountRule->max_weight_limit ? (float) $discountRule->max_weight_limit : null,
            'weight_exceeds_limit' => $discountRule->max_weight_limit && $totalWeight > (float) $discountRule->max_weight_limit,
            'excess_weight' => $discountRule->max_weight_limit && $totalWeight > (float) $discountRule->max_weight_limit 
                ? $totalWeight - (float) $discountRule->max_weight_limit 
                : 0,
            'rule_name' => $discountRule->rule_name,
            'rule_description' => $discountRule->description,
            'debug' => array_merge($debug, [
                'result' => 'Match found',
                'matched_rule_id' => $discountRule->id,
                'max_weight_limit' => $discountRule->max_weight_limit,
            ]),
        ]);
    }

    public function userOrders()
    {
        $orders = Order::with(['region', 'items.product'])
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('user.orders', compact('orders'));
    }

    /**
     * Download invoice PDF for an order
     */
    public function downloadInvoice($orderId)
    {
        try {
            $order = Order::with(['items.product', 'region'])
                ->where('id', $orderId);

            // For logged-in users, verify ownership
            if (Auth::check()) {
                $order->where('user_id', Auth::id());
            } else {
                // For guests, allow access (you could add session validation here)
                $order->whereNull('user_id');
            }

            $order = $order->firstOrFail();

            // Generate PDF with the invoice template
            $pdf = Pdf::loadView('invoices.order-invoice', compact('order'))
                ->setPaper('a4', 'portrait')
                ->setOptions([
                    'isHtml5ParserEnabled' => true,
                    'isRemoteEnabled' => false,
                    'chroot' => public_path(),
                    'defaultFont' => 'helvetica',
                    'debugCss' => false,
                    'debugLayout' => false,
                    'debugLayoutLines' => false,
                    'debugLayoutBlocks' => false,
                    'debugLayoutInline' => false,
                    'debugLayoutPaddingBox' => false,
                ]);

            // Download the PDF with a descriptive filename
            return $pdf->download('invoice-' . $order->id . '-' . date('Y-m-d') . '.pdf');
        } catch (\Exception $e) {
            \Log::error('Invoice PDF Generation Error: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return redirect()->back()->with('error', 'Failed to generate invoice PDF. Please try again or contact support. Error: ' . $e->getMessage());
        }
    }
}
