<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        // Filter by role (show only customers, exclude admins, developers, etc.)
        if ($request->has('role') && $request->role !== 'all') {
            $query->where('role', $request->role);
        } else {
            // By default, show all users or filter out admins
            if (!$request->has('show_all')) {
                $query->whereIn('role', ['user', 'customer', null]);
            }
        }

        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%");
            });
        }

        // Get customers with their order counts and total spent
        $customers = $query->withCount('carts as orders_count')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        // Add additional stats for each customer
        foreach ($customers as $customer) {
            $customer->total_orders = Order::where('user_id', $customer->id)->count();
            $customer->total_spent = Order::where('user_id', $customer->id)
                ->where('status', '!=', 'cancelled')
                ->sum('total_amount');
        }

        return view('admin.customers.index', compact('customers'));
    }

    public function show($id)
    {
        $customer = User::with(['wishlists.product', 'carts.product'])->findOrFail($id);

        // Get customer orders
        $orders = Order::where('user_id', $id)
            ->with('items.product')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $stats = [
            'total_orders' => Order::where('user_id', $id)->count(),
            'total_spent' => Order::where('user_id', $id)
                ->where('status', '!=', 'cancelled')
                ->sum('total_amount'),
            'pending_orders' => Order::where('user_id', $id)
                ->where('status', 'pending')
                ->count(),
            'wishlist_count' => $customer->wishlists->count(),
            'cart_count' => $customer->carts->count(),
        ];

        return view('admin.customers.show', compact('customer', 'orders', 'stats'));
    }

    public function destroy($id)
    {
        $customer = User::findOrFail($id);

        // Prevent deleting admin or developer accounts
        if (in_array($customer->role, ['admin', 'developer', 'order_manager', 'stock_manager'])) {
            return redirect()->route('admin.customers.index')
                ->with('error', 'Cannot delete admin or staff accounts!');
        }

        $customer->delete();

        return redirect()->route('admin.customers.index')
            ->with('success', 'Customer deleted successfully!');
    }
}
