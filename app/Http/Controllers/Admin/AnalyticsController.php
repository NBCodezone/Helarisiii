<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AnalyticsController extends Controller
{
    public function index(Request $request)
    {
        $period = $request->get('period', '30'); // Default 30 days
        $startDate = Carbon::now()->subDays((int)$period);

        // Overview Stats
        $totalRevenue = Order::where('status', '!=', 'cancelled')
            ->where('created_at', '>=', $startDate)
            ->sum('total_amount');

        $totalOrders = Order::where('created_at', '>=', $startDate)->count();

        $approvedOrders = Order::where('status', 'approved')
            ->orWhere('status', 'delivered')
            ->orWhere('status', 'shipped')
            ->where('created_at', '>=', $startDate)
            ->count();

        $pendingOrders = Order::where('status', 'pending')
            ->where('created_at', '>=', $startDate)
            ->count();

        $cancelledOrders = Order::where('status', 'cancelled')
            ->where('created_at', '>=', $startDate)
            ->count();

        $totalCustomers = User::whereIn('role', ['user', 'customer', null])
            ->where('created_at', '>=', $startDate)
            ->count();

        // Order Status Distribution
        $ordersByStatus = Order::select('status', DB::raw('count(*) as count'))
            ->where('created_at', '>=', $startDate)
            ->groupBy('status')
            ->get();

        // Revenue by Day (for chart)
        $revenueByDay = Order::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(total_amount) as revenue'),
                DB::raw('COUNT(*) as orders')
            )
            ->where('status', '!=', 'cancelled')
            ->where('created_at', '>=', $startDate)
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Top 5 Customers
        $topCustomers = Order::select('user_id', DB::raw('SUM(total_amount) as total_spent'), DB::raw('COUNT(*) as order_count'))
            ->where('status', '!=', 'cancelled')
            ->where('created_at', '>=', $startDate)
            ->whereNotNull('user_id')
            ->groupBy('user_id')
            ->orderBy('total_spent', 'desc')
            ->limit(5)
            ->with('user')
            ->get();

        return view('admin.analytics.index', compact(
            'totalRevenue',
            'totalOrders',
            'approvedOrders',
            'pendingOrders',
            'cancelledOrders',
            'totalCustomers',
            'ordersByStatus',
            'revenueByDay',
            'topCustomers',
            'period'
        ));
    }

    public function products(Request $request)
    {
        $period = $request->get('period', '30');
        $startDate = Carbon::now()->subDays((int)$period);

        // Most Selling Products
        $mostSellingProducts = OrderItem::select(
                'product_id',
                DB::raw('SUM(quantity) as total_quantity'),
                DB::raw('SUM(subtotal) as total_revenue'),
                DB::raw('COUNT(DISTINCT order_id) as order_count')
            )
            ->whereHas('order', function($query) use ($startDate) {
                $query->where('status', '!=', 'cancelled')
                      ->where('created_at', '>=', $startDate);
            })
            ->groupBy('product_id')
            ->orderBy('total_quantity', 'desc')
            ->limit(10)
            ->with('product.category')
            ->get();

        // Least Selling Products (from products that have been sold at least once)
        $leastSellingProducts = OrderItem::select(
                'product_id',
                DB::raw('SUM(quantity) as total_quantity'),
                DB::raw('SUM(subtotal) as total_revenue'),
                DB::raw('COUNT(DISTINCT order_id) as order_count')
            )
            ->whereHas('order', function($query) use ($startDate) {
                $query->where('status', '!=', 'cancelled')
                      ->where('created_at', '>=', $startDate);
            })
            ->groupBy('product_id')
            ->orderBy('total_quantity', 'asc')
            ->limit(10)
            ->with('product.category')
            ->get();

        // Never Sold Products
        $soldProductIds = OrderItem::whereHas('order', function($query) use ($startDate) {
                $query->where('status', '!=', 'cancelled')
                      ->where('created_at', '>=', $startDate);
            })
            ->pluck('product_id')
            ->unique();

        $neverSoldProducts = Product::whereNotIn('id', $soldProductIds)
            ->with('category')
            ->limit(10)
            ->get();

        // Category Performance
        $categoryPerformance = OrderItem::select(
                'products.category_id',
                DB::raw('SUM(order_items.quantity) as total_quantity'),
                DB::raw('SUM(order_items.subtotal) as total_revenue'),
                DB::raw('COUNT(DISTINCT order_items.order_id) as order_count')
            )
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->whereHas('order', function($query) use ($startDate) {
                $query->where('status', '!=', 'cancelled')
                      ->where('created_at', '>=', $startDate);
            })
            ->groupBy('products.category_id')
            ->orderBy('total_revenue', 'desc')
            ->get();

        // Add category names
        foreach ($categoryPerformance as $item) {
            $item->category = \App\Models\Category::find($item->category_id);
        }

        return view('admin.analytics.products', compact(
            'mostSellingProducts',
            'leastSellingProducts',
            'neverSoldProducts',
            'categoryPerformance',
            'period'
        ));
    }
}
