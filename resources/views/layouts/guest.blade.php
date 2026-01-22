<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen flex">
            <!-- Left Side - Branding Section -->
            <div class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-helarisi-teal via-helarisi-teal-dark to-helarisi-maroon relative overflow-hidden">
                <!-- Animated Background Pattern -->
                <div class="absolute inset-0 opacity-10">
                    <div class="absolute inset-0" style="background-image: repeating-linear-gradient(45deg, transparent, transparent 35px, rgba(255,255,255,.1) 35px, rgba(255,255,255,.1) 70px);"></div>
                </div>

                <!-- Floating Grocery Icons -->
                <div class="absolute inset-0 overflow-hidden">
                    <!-- Vegetable Icons -->
                    <div class="absolute top-20 left-16 text-6xl opacity-20 animate-bounce" style="animation-duration: 3s;">🥕</div>
                    <div class="absolute top-40 right-24 text-5xl opacity-15 animate-bounce" style="animation-duration: 4s; animation-delay: 0.5s;">🥦</div>
                    <div class="absolute bottom-32 left-20 text-7xl opacity-20 animate-bounce" style="animation-duration: 3.5s; animation-delay: 1s;">🍅</div>

                    <!-- Fruit Icons -->
                    <div class="absolute top-1/3 right-16 text-6xl opacity-20 animate-bounce" style="animation-duration: 4s; animation-delay: 1.5s;">🍎</div>
                    <div class="absolute bottom-48 right-32 text-5xl opacity-15 animate-bounce" style="animation-duration: 3s; animation-delay: 2s;">🍊</div>
                    <div class="absolute top-1/2 left-24 text-6xl opacity-20 animate-bounce" style="animation-duration: 3.8s; animation-delay: 0.8s;">🍇</div>

                    <!-- Shopping & Grocery Items -->
                    <div class="absolute bottom-20 right-16 text-7xl opacity-25 animate-bounce" style="animation-duration: 4.2s;">🛒</div>
                    <div class="absolute top-1/4 left-32 text-5xl opacity-15 animate-bounce" style="animation-duration: 3.3s; animation-delay: 1.2s;">🥖</div>
                    <div class="absolute bottom-1/3 left-12 text-6xl opacity-20 animate-bounce" style="animation-duration: 3.7s; animation-delay: 0.3s;">🥬</div>
                    <div class="absolute top-2/3 right-20 text-5xl opacity-15 animate-bounce" style="animation-duration: 4.5s; animation-delay: 1.8s;">🌽</div>
                </div>

                <!-- Decorative Circles -->
                <div class="absolute top-10 left-10 w-32 h-32 bg-white opacity-5 rounded-full blur-xl"></div>
                <div class="absolute bottom-20 right-20 w-48 h-48 bg-white opacity-5 rounded-full blur-2xl"></div>
                <div class="absolute top-1/3 right-10 w-24 h-24 bg-helarisi-orange opacity-20 rounded-full blur-lg"></div>
                <div class="absolute bottom-1/4 left-16 w-40 h-40 bg-helarisi-maroon opacity-10 rounded-full blur-xl"></div>

                <!-- Main Content -->
                <div class="relative z-10 flex flex-col justify-center items-center p-12 text-white w-full h-full">
                    <div class="flex flex-col items-center justify-center max-w-xl mx-auto">
                        <!-- Logo with Background -->
                        <div class="mb-10 relative flex justify-center">
                            <div class="absolute inset-0 bg-white rounded-full blur-2xl opacity-20 scale-110"></div>
                            <div class="relative bg-white bg-opacity-10 backdrop-blur-sm rounded-2xl p-8 border border-white border-opacity-20 flex items-center justify-center">
                                <img src="{{ asset('images/logo-header.png') }}" alt="Helarisi Logo" class="h-32 w-auto drop-shadow-2xl mx-auto">
                            </div>
                        </div>

                        <!-- Welcome Text -->
                        <h1 class="text-5xl font-bold mb-6 text-center drop-shadow-lg">Welcome to Helarisi</h1>
                        <p class="text-xl text-center text-gray-100 max-w-md drop-shadow mb-10 px-4">Your trusted partner for fresh groceries and quality products</p>

                        <!-- Feature Icons -->
                        <div class="grid grid-cols-3 gap-10 mt-8 w-full max-w-lg">
                            <div class="text-center flex flex-col items-center">
                                <div class="text-4xl mb-3">🌱</div>
                                <p class="text-sm font-medium">Fresh Products</p>
                            </div>
                            <div class="text-center flex flex-col items-center">
                                <div class="text-4xl mb-3">🚚</div>
                                <p class="text-sm font-medium">Fast Delivery</p>
                            </div>
                            <div class="text-center flex flex-col items-center">
                                <div class="text-4xl mb-3">💯</div>
                                <p class="text-sm font-medium">Best Quality</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Side - Form Section -->
            <div class="w-full lg:w-1/2 flex flex-col justify-center items-center p-6 sm:p-12 bg-gray-50">
                <!-- Mobile Logo -->
                <div class="lg:hidden mb-8">
                    <a href="/">
                        <img src="{{ asset('images/logo-header.png') }}" alt="Helarisi Logo" class="h-24 w-auto">
                    </a>
                </div>

                <!-- Form Container -->
                <div class="w-full max-w-md">
                    <div class="bg-white shadow-2xl rounded-2xl p-8 sm:p-10 border border-gray-100">
                        {{ $slot }}
                    </div>
                </div>

                <!-- Back to Home Link -->
                <div class="mt-6">
                    <a href="{{ url('/') }}" class="text-sm text-helarisi-teal hover:text-helarisi-teal-dark transition-colors duration-200 font-medium">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline-block mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Back to Home
                    </a>
                </div>
            </div>
        </div>
    </body>
</html>
