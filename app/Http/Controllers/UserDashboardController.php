<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use App\Models\Order;
use App\Models\Wishlist;
use App\Models\UserNotification;

class UserDashboardController extends Controller
{
    /**
     * Display the user dashboard
     */
    public function index()
    {
        $user = Auth::user();

        // Get dashboard statistics
        $totalOrders = Order::where('user_id', $user->id)->count();
        $pendingOrders = Order::where('user_id', $user->id)
            ->where('status', 'pending')
            ->count();
        $wishlistCount = Wishlist::where('user_id', $user->id)->count();
        $totalSpent = Order::where('user_id', $user->id)
            ->whereIn('status', ['approved', 'shipped', 'delivered'])
            ->sum('total_amount');

        // Get recent orders (last 5)
        $recentOrders = Order::where('user_id', $user->id)
            ->with(['items.product', 'region'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Get notifications for notifications tab
        $notifications = UserNotification::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('user.dashboard', compact(
            'totalOrders',
            'pendingOrders',
            'wishlistCount',
            'totalSpent',
            'recentOrders',
            'notifications'
        ));
    }

    /**
     * Display the account settings page
     */
    public function settings()
    {
        return view('user.account-settings');
    }

    /**
     * Update user profile information
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
        ]);

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
        ]);

        return redirect()->route('account.settings')
            ->with('success', 'Profile updated successfully!');
    }

    /**
     * Update user password
     */
    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        // Check if user has a password (Google login users might not have one)
        $hasPassword = !empty($user->password);

        if ($hasPassword) {
            // User has a password - require current password
            $request->validate([
                'current_password' => ['required', 'current_password'],
                'new_password' => ['required', 'confirmed', Rules\Password::defaults()],
            ]);
        } else {
            // User doesn't have a password (Google login) - just set new password
            $request->validate([
                'new_password' => ['required', 'confirmed', Rules\Password::defaults()],
            ]);
        }

        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        $message = $hasPassword ? 'Password updated successfully!' : 'Password set successfully! You can now login with your email and password.';

        return redirect()->route('account.settings')
            ->with('success', $message);
    }
}
