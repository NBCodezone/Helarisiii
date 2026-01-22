<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
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
     * Display the cart page
     */
    public function index()
    {
        $cartItems = $this->getCartItems();
        $subtotal = $cartItems->sum(function ($item) {
            return $item->product->discounted_price * $item->quantity;
        });
        $shipping = 10.00; // Flat rate shipping
        $total = $subtotal + $shipping;

        return view('cart', compact('cartItems', 'subtotal', 'shipping', 'total'));
    }

    /**
     * Add a product to the cart
     */
    public function add(Request $request, $productId)
    {
        $request->validate([
            'quantity' => 'nullable|integer|min:1'
        ]);

        $product = Product::findOrFail($productId);
        $quantity = $request->input('quantity', 1);

        // Check if product is in stock
        if ($product->stock < $quantity) {
            return response()->json([
                'success' => false,
                'message' => 'Not enough stock available'
            ], 400);
        }

        // Check if product already in cart
        if (Auth::check()) {
            $cartItem = Cart::where('user_id', Auth::id())
                           ->where('product_id', $productId)
                           ->first();
        } else {
            $sessionId = session()->getId();
            $cartItem = Cart::where('session_id', $sessionId)
                           ->whereNull('user_id')
                           ->where('product_id', $productId)
                           ->first();
        }

        if ($cartItem) {
            // Update quantity
            $newQuantity = $cartItem->quantity + $quantity;
            if ($product->stock < $newQuantity) {
                return response()->json([
                    'success' => false,
                    'message' => 'Not enough stock available'
                ], 400);
            }
            $cartItem->quantity = $newQuantity;
            $cartItem->save();
        } else {
            // Create new cart item
            if (Auth::check()) {
                Cart::create([
                    'user_id' => Auth::id(),
                    'product_id' => $productId,
                    'quantity' => $quantity
                ]);
            } else {
                Cart::create([
                    'session_id' => session()->getId(),
                    'product_id' => $productId,
                    'quantity' => $quantity
                ]);
            }
        }

        $cartCount = $this->getCartItems()->sum('quantity');

        return response()->json([
            'success' => true,
            'message' => 'Product added to cart successfully',
            'cart_count' => $cartCount
        ]);
    }

    /**
     * Update cart item quantity
     */
    public function update(Request $request, $cartId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        if (Auth::check()) {
            $cartItem = Cart::where('id', $cartId)
                           ->where('user_id', Auth::id())
                           ->firstOrFail();
        } else {
            $sessionId = session()->getId();
            $cartItem = Cart::where('id', $cartId)
                           ->where('session_id', $sessionId)
                           ->whereNull('user_id')
                           ->firstOrFail();
        }

        $quantity = $request->input('quantity');

        // Check stock
        if ($cartItem->product->stock < $quantity) {
            return response()->json([
                'success' => false,
                'message' => 'Not enough stock available'
            ], 400);
        }

        $cartItem->quantity = $quantity;
        $cartItem->save();

        $cartItems = $this->getCartItems();
        $cartItem = $cartItems->first(fn($item) => $item->id == $cartId);
        $subtotal = $cartItem ? $cartItem->product->discounted_price * $cartItem->quantity : 0;
        $cartSubtotal = $cartItems->sum(function ($item) {
            return $item->product->discounted_price * $item->quantity;
        });
        $shipping = 10.00;
        $total = $cartSubtotal + $shipping;

        return response()->json([
            'success' => true,
            'message' => 'Cart updated successfully',
            'subtotal' => number_format($subtotal, 0),
            'cart_subtotal' => number_format($cartSubtotal, 0),
            'total' => number_format($total, 0)
        ]);
    }

    /**
     * Remove item from cart
     */
    public function remove($cartId)
    {
        if (Auth::check()) {
            $deleted = Cart::where('id', $cartId)
                          ->where('user_id', Auth::id())
                          ->delete();
        } else {
            $sessionId = session()->getId();
            $deleted = Cart::where('id', $cartId)
                          ->where('session_id', $sessionId)
                          ->whereNull('user_id')
                          ->delete();
        }

        if ($deleted) {
            $cartItems = $this->getCartItems();
            $subtotal = $cartItems->sum(function ($item) {
                return $item->product->discounted_price * $item->quantity;
            });
            $shipping = 10.00;
            $total = $subtotal + $shipping;

            return response()->json([
                'success' => true,
                'message' => 'Item removed from cart',
                'cart_count' => $cartItems->sum('quantity'),
                'subtotal' => number_format($subtotal, 0),
                'total' => number_format($total, 0)
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Item not found in cart'
        ], 404);
    }

    /**
     * Clear all cart items
     */
    public function clear()
    {
        if (Auth::check()) {
            Cart::where('user_id', Auth::id())->delete();
        } else {
            $sessionId = session()->getId();
            Cart::where('session_id', $sessionId)
                ->whereNull('user_id')
                ->delete();
        }

        return response()->json([
            'success' => true,
            'message' => 'Cart cleared successfully'
        ]);
    }

    /**
     * Get cart count
     */
    public function count()
    {
        $count = $this->getCartItems()->sum('quantity');

        return response()->json([
            'count' => $count
        ]);
    }

    /**
     * Get cart summary (count and total)
     */
    public function getSummary()
    {
        $cartItems = $this->getCartItems();
        $count = $cartItems->sum('quantity');
        $total = $cartItems->sum(function ($item) {
            return $item->product->discounted_price * $item->quantity;
        });

        return response()->json([
            'count' => $count,
            'total' => $total,
            'formatted_total' => '¥' . number_format($total, 0)
        ]);
    }

    /**
     * Merge guest cart with user cart after login
     */
    public function mergeGuestCart($userId, $sessionId)
    {
        $guestCartItems = Cart::where('session_id', $sessionId)
                              ->whereNull('user_id')
                              ->get();

        foreach ($guestCartItems as $guestItem) {
            $userCartItem = Cart::where('user_id', $userId)
                               ->where('product_id', $guestItem->product_id)
                               ->first();

            if ($userCartItem) {
                // Merge quantities
                $userCartItem->quantity += $guestItem->quantity;
                $userCartItem->save();
                $guestItem->delete();
            } else {
                // Transfer to user
                $guestItem->user_id = $userId;
                $guestItem->session_id = null;
                $guestItem->save();
            }
        }
    }
}
