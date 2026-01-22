<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class GoogleController extends Controller
{
    // Step 1: Redirect to Google
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    // Step 2: Handle callback
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();

            // Check if user exists by email
            $user = User::where('email', $googleUser->getEmail())->first();

            if ($user) {
                // User exists - check if they're allowed to use Google login
                if ($user->role !== 'user') {
                    return redirect()->route('login')->withErrors([
                        'email' => 'Google login is only available for regular users. Please use standard login.'
                    ]);
                }

                // Update google_id if not set
                if (!$user->google_id) {
                    $user->update(['google_id' => $googleUser->getId()]);
                }
            } else {
                // Create new user with 'user' role only
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'password' => null, // No password for Google login users
                    'role' => 'user', // Only 'user' role for Google login
                    'email_verified_at' => now(), // Auto-verify email for Google users
                ]);
            }

            // Log the user in
            Auth::login($user, true);

            // Redirect to user dashboard
            return redirect()->route('user.dashboard');

        } catch (\Exception $e) {
            \Log::error('Google Login Error: ' . $e->getMessage());
            return redirect()->route('login')->withErrors([
                'email' => 'Unable to login with Google. Please try again or use standard login.'
            ]);
        }
    }
}
