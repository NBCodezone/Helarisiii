<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\StockNotification;
use Illuminate\Support\Facades\DB;

class StockManagerController extends Controller
{
    /**
     * Display the stock manager dashboard
     */
    public function stockDashboard()
    {
        // Get low stock products (stock <= 10) with category name
        $lowStockProducts = Product::select('products.*', 'categories.category_name')
            ->leftJoin('categories', 'products.category_id', '=', 'categories.id')
            ->where('stock', '<=', 10)
            ->where('stock', '>', 0)
            ->orderBy('stock', 'asc')
            ->get();

        // Get out of stock products with category name
        $outOfStockProducts = Product::select('products.*', 'categories.category_name')
            ->leftJoin('categories', 'products.category_id', '=', 'categories.id')
            ->where('stock', 0)
            ->get();

        // Get unread notifications
        $unreadNotifications = StockNotification::with('product')
            ->unread()
            ->orderBy('created_at', 'desc')
            ->get();

        // Get recent notifications (last 7 days)
        $recentNotifications = StockNotification::with('product')
            ->where('created_at', '>=', now()->subDays(7))
            ->orderBy('created_at', 'desc')
            ->limit(50)
            ->get();

        // Stock statistics
        $stats = [
            'total_products' => Product::count(),
            'low_stock_count' => $lowStockProducts->count(),
            'out_of_stock_count' => $outOfStockProducts->count(),
            'unread_notifications_count' => $unreadNotifications->count(),
        ];

        return view('stock-manager-dashboard', compact(
            'lowStockProducts',
            'outOfStockProducts',
            'unreadNotifications',
            'recentNotifications',
            'stats'
        ));
    }

    /**
     * Display the order manager dashboard
     */
    public function dashboard()
    {
        return view('order-manager-dashboard');
    }

    /**
     * Mark notification as read
     */
    public function markNotificationAsRead($id)
    {
        $notification = StockNotification::findOrFail($id);
        $notification->markAsRead();

        return response()->json([
            'success' => true,
            'message' => 'Notification marked as read'
        ]);
    }

    /**
     * Mark all notifications as read
     */
    public function markAllNotificationsAsRead()
    {
        StockNotification::where('is_read', false)->update(['is_read' => true]);

        return redirect()->back()->with('success', 'All notifications marked as read');
    }

    /**
     * Delete a notification
     */
    public function deleteNotification($id)
    {
        $notification = StockNotification::findOrFail($id);
        $notification->delete();

        return response()->json([
            'success' => true,
            'message' => 'Notification deleted'
        ]);
    }

    /**
     * Get real-time stock data (for AJAX requests)
     */
    public function getStockData()
    {
        $lowStockCount = Product::where('stock', '<=', 10)->where('stock', '>', 0)->count();
        $outOfStockCount = Product::where('stock', 0)->count();
        $unreadNotificationsCount = StockNotification::unread()->count();

        return response()->json([
            'low_stock_count' => $lowStockCount,
            'out_of_stock_count' => $outOfStockCount,
            'unread_notifications_count' => $unreadNotificationsCount,
        ]);
    }

    /**
     * Get unread notifications (for AJAX)
     */
    public function getUnreadNotifications()
    {
        $notifications = StockNotification::with('product')
            ->unread()
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($notifications);
    }

    /**
     * Display stock management page
     */
    public function stockIndex(Request $request)
    {
        $query = Product::select('products.*', 'categories.category_name')
            ->leftJoin('categories', 'products.category_id', '=', 'categories.id');

        // Filter by stock status
        if ($request->has('filter')) {
            switch ($request->filter) {
                case 'low':
                    $query->where('stock', '<=', 10)->where('stock', '>', 0);
                    break;
                case 'out':
                    $query->where('stock', 0);
                    break;
                case 'in_stock':
                    $query->where('stock', '>', 10);
                    break;
            }
        }

        // Search by product name
        if ($request->has('search') && $request->search) {
            $query->where('products.product_name', 'like', '%' . $request->search . '%');
        }

        $products = $query->orderBy('stock', 'asc')->paginate(20);

        // Get stats
        $stats = [
            'total_products' => Product::count(),
            'low_stock_count' => Product::where('stock', '<=', 10)->where('stock', '>', 0)->count(),
            'out_of_stock_count' => Product::where('stock', 0)->count(),
            'in_stock_count' => Product::where('stock', '>', 10)->count(),
        ];

        return view('stock-manager.stocks', compact('products', 'stats'));
    }

    /**
     * Update product stock quantity
     */
    public function updateStock(Request $request, $id)
    {
        $request->validate([
            'stock' => 'required|integer|min:0',
        ]);

        $product = Product::findOrFail($id);
        $oldStock = $product->stock;
        $newStock = $request->stock;

        $product->stock = $newStock;
        $product->save();

        // Create notification if stock is low or out
        if ($newStock == 0 && $oldStock > 0) {
            StockNotification::create([
                'product_id' => $product->id,
                'type' => 'out_of_stock',
                'message' => "Product '{$product->product_name}' is now out of stock.",
                'is_read' => false,
            ]);
        } elseif ($newStock <= 10 && $newStock > 0 && $oldStock > 10) {
            StockNotification::create([
                'product_id' => $product->id,
                'type' => 'low_stock',
                'message' => "Product '{$product->product_name}' has low stock ({$newStock} items remaining).",
                'is_read' => false,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Stock updated successfully',
            'old_stock' => $oldStock,
            'new_stock' => $newStock,
            'product_name' => $product->product_name,
        ]);
    }

    /**
     * Bulk update stock quantities
     */
    public function bulkUpdateStock(Request $request)
    {
        $request->validate([
            'stocks' => 'required|array',
            'stocks.*.id' => 'required|exists:products,id',
            'stocks.*.quantity' => 'required|integer|min:0',
        ]);

        $updated = 0;
        foreach ($request->stocks as $item) {
            $product = Product::find($item['id']);
            if ($product) {
                $oldStock = $product->stock;
                $newStock = $item['quantity'];

                $product->stock = $newStock;
                $product->save();

                // Create notification if stock is low or out
                if ($newStock == 0 && $oldStock > 0) {
                    StockNotification::create([
                        'product_id' => $product->id,
                        'type' => 'out_of_stock',
                        'message' => "Product '{$product->product_name}' is now out of stock.",
                        'is_read' => false,
                    ]);
                } elseif ($newStock <= 10 && $newStock > 0 && $oldStock > 10) {
                    StockNotification::create([
                        'product_id' => $product->id,
                        'type' => 'low_stock',
                        'message' => "Product '{$product->product_name}' has low stock ({$newStock} items remaining).",
                        'is_read' => false,
                    ]);
                }

                $updated++;
            }
        }

        return response()->json([
            'success' => true,
            'message' => "{$updated} products updated successfully",
        ]);
    }
}
