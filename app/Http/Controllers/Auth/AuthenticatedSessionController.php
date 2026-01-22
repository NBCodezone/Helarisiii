<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\CartController;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        // Get session ID before regeneration to merge guest cart
        $oldSessionId = $request->session()->getId();

        $request->session()->regenerate();

        // Merge guest cart with user cart after login
        $cartController = app(CartController::class);
        $cartController->mergeGuestCart($request->user()->id, $oldSessionId);

        // Redirect based on user role
        $role = $request->user()->role;
        $dashboardRoute = match($role) {
            'user' => 'user.dashboard',
            'developer' => 'developer.dashboard',
            'admin' => 'admin.dashboard',
            'stock_manager' => 'stock-manager.dashboard',
            'order_manager' => 'order-manager.dashboard',
            default => 'user.dashboard',
        };

        return redirect()->intended(route($dashboardRoute, absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
