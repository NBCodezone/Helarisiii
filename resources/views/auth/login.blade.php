<x-guest-layout>
    <!-- Header -->
    <div class="text-center mb-8">
        <h2 class="text-3xl font-bold text-gray-800 mb-2">Welcome Back</h2>
        <p class="text-gray-500">Sign in to your account to continue</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email Address</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                    </svg>
                </div>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                    class="pl-10 block w-full rounded-lg border-gray-300 shadow-sm focus:border-helarisi-teal focus:ring focus:ring-helarisi-teal focus:ring-opacity-50 transition duration-150 py-3">
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">Password</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
                <input id="password" type="password" name="password" required autocomplete="current-password"
                    class="pl-10 block w-full rounded-lg border-gray-300 shadow-sm focus:border-helarisi-teal focus:ring focus:ring-helarisi-teal focus:ring-opacity-50 transition duration-150 py-3">
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center cursor-pointer">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-helarisi-teal shadow-sm focus:ring-helarisi-teal" name="remember">
                <span class="ms-2 text-sm text-gray-600 font-medium">Remember me</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm text-helarisi-teal hover:text-helarisi-teal-dark font-medium transition-colors duration-200" href="{{ route('password.request') }}">
                    Forgot password?
                </a>
            @endif
        </div>

        <!-- Login Button -->
        <button type="submit" class="w-full bg-gradient-to-r from-helarisi-teal to-helarisi-teal-dark text-white font-semibold py-3 px-4 rounded-lg hover:from-helarisi-teal-dark hover:to-helarisi-maroon transition-all duration-300 transform hover:scale-[1.02] shadow-lg hover:shadow-xl">
            Sign In
        </button>
    </form>

    <!-- Divider -->
    <div class="relative my-6">
        <div class="absolute inset-0 flex items-center">
            <div class="w-full border-t border-gray-300"></div>
        </div>
        <div class="relative flex justify-center text-sm">
            <span class="px-4 bg-white text-gray-500 font-medium">Or continue with</span>
        </div>
    </div>

    <!-- Google Login Button -->
    <a href="{{ route('google.login') }}"
       class="w-full flex items-center justify-center gap-3 bg-white border-2 border-gray-200 text-gray-700 font-semibold px-4 py-3 rounded-lg hover:bg-gray-50 hover:border-gray-300 transition-all duration-200 shadow-sm hover:shadow-md">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 48 48">
            <path fill="#EA4335" d="M24 9.5c3.3 0 6.2 1.1 8.5 3.2l6.3-6.3C34.7 2.5 29.8 0 24 0 14.8 0 7.1 5.4 3.4 13.2l7.3 5.7C12.2 13.3 17.5 9.5 24 9.5z"/>
            <path fill="#34A853" d="M46.1 24.5c0-1.6-.1-3.2-.4-4.7H24v9h12.6c-.5 2.7-2.1 5.1-4.4 6.7l7 5.4c4.1-3.8 6.9-9.5 6.9-16.4z"/>
            <path fill="#4A90E2" d="M10.7 28.9C9.8 26.4 9.4 23.7 9.4 21s.4-5.4 1.3-7.9L3.4 7.4C1.2 11.4 0 16 0 21c0 5 1.2 9.6 3.4 13.6l7.3-5.7z"/>
            <path fill="#FBBC05" d="M24 48c6.5 0 12-2.1 16-5.8l-7-5.4c-2 1.4-4.7 2.3-9 2.3-6.5 0-12-4.4-14-10.3l-7.3 5.7C7.1 42.6 14.8 48 24 48z"/>
        </svg>
        Sign in with Google
    </a>

    <!-- Register Link -->
    <div class="text-center mt-6">
        <p class="text-sm text-gray-600">
            Don't have an account?
            <a href="{{ route('register') }}" class="text-helarisi-teal hover:text-helarisi-teal-dark font-semibold transition-colors duration-200">
                Create one now
            </a>
        </p>
    </div>
</x-guest-layout>
