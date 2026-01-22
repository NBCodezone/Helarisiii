<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }} - Admin</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=playfair-display:400,500,600,700|inter:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .sidebar-link {
            transition: all 0.3s ease;
        }
        .sidebar-link:hover {
            transform: translateX(5px);
        }
        .sidebar-link.active {
            background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
            box-shadow: 0 4px 15px rgba(249, 115, 22, 0.4);
        }
        .jewelry-gradient {
            background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
        }
        .gold-accent {
            color: #D4AF37;
        }
        .card-hover {
            transition: all 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body class="font-sans antialiased bg-gray-50">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside id="sidebar" class="w-64 bg-gradient-to-b from-gray-900 via-gray-800 to-gray-900 text-white flex-shrink-0 hidden md:flex flex-col shadow-2xl">
            <!-- Logo -->
            <div class="p-6 border-b border-gray-700">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 jewelry-gradient rounded-lg flex items-center justify-center shadow-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold" style="font-family: 'Playfair Display', serif;">
                            @if(Auth::user()->isAdmin())
                                Admin Panel
                            @elseif(Auth::user()->isDeveloper())
                                Developer Panel
                            @elseif(Auth::user()->isStockManager())
                                Stock Manager Panel
                            @else
                                User Panel
                            @endif
                        </h1>
                        <p class="text-xs text-gray-400">Management Panel</p>
                    </div>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
                @if(Auth::user()->isAdmin())
                    <!-- Admin Navigation -->
                    <a href="{{ route('admin.dashboard') }}" class="sidebar-link flex items-center space-x-4 px-4 py-3 rounded-lg {{ request()->routeIs('admin.dashboard') ? 'active' : 'text-gray-300 hover:bg-gray-800' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        <span class="font-medium whitespace-nowrap">Dashboard</span>
                    </a>

                    <a href="{{ route('admin.products.index') }}" class="sidebar-link flex items-center space-x-4 px-4 py-3 rounded-lg {{ request()->routeIs('admin.products.*') && !request()->routeIs('admin.products.index') ? 'active' : (request()->routeIs('admin.products.index') ? 'active' : 'text-gray-300 hover:bg-gray-800') }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                        </svg>
                        <span class="font-medium whitespace-nowrap">Products</span>
                    </a>

                    <a href="{{ route('admin.categories.index') }}" class="sidebar-link flex items-center space-x-4 px-4 py-3 rounded-lg {{ request()->routeIs('admin.categories.*') ? 'active' : 'text-gray-300 hover:bg-gray-800' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                        </svg>
                        <span class="font-medium whitespace-nowrap">Categories</span>
                    </a>

                    <a href="{{ route('admin.carousels.index') }}" class="sidebar-link flex items-center space-x-4 px-4 py-3 rounded-lg {{ request()->routeIs('admin.carousels.*') ? 'active' : 'text-gray-300 hover:bg-gray-800' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <span class="font-medium whitespace-nowrap">Carousels</span>
                    </a>

                    <a href="{{ route('admin.offers.index') }}" class="sidebar-link flex items-center space-x-4 px-4 py-3 rounded-lg {{ request()->routeIs('admin.offers.*') ? 'active' : 'text-gray-300 hover:bg-gray-800' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"/>
                        </svg>
                        <span class="font-medium whitespace-nowrap">Product Offers</span>
                    </a>

                    <a href="{{ route('admin.orders') }}" class="sidebar-link flex items-center space-x-4 px-4 py-3 rounded-lg {{ request()->routeIs('admin.orders') ? 'active' : 'text-gray-300 hover:bg-gray-800' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                        <span class="font-medium whitespace-nowrap">Orders</span>
                    </a>

                    <a href="{{ route('admin.stocks.index') }}" class="sidebar-link flex items-center space-x-4 px-4 py-3 rounded-lg {{ request()->routeIs('admin.stocks.*') ? 'active' : 'text-gray-300 hover:bg-gray-800' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                        </svg>
                        <span class="font-medium whitespace-nowrap">Stock Management</span>
                    </a>

                    <a href="{{ route('admin.bank-accounts.index') }}" class="sidebar-link flex items-center space-x-4 px-4 py-3 rounded-lg {{ request()->routeIs('admin.bank-accounts.*') ? 'active' : 'text-gray-300 hover:bg-gray-800' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                        </svg>
                        <span class="font-medium whitespace-nowrap">Bank Accounts</span>
                    </a>

                    <!-- <a href="{{ route('admin.featured-rotation.index') }}" class="sidebar-link flex items-center space-x-4 px-4 py-3 rounded-lg {{ request()->routeIs('admin.featured-rotation.*') ? 'active' : 'text-gray-300 hover:bg-gray-800' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                        <span class="font-medium whitespace-nowrap">Featured Rotation</span>
                    </a> -->

                    <a href="{{ route('admin.customers.index') }}" class="sidebar-link flex items-center space-x-4 px-4 py-3 rounded-lg {{ request()->routeIs('admin.customers.*') ? 'active' : 'text-gray-300 hover:bg-gray-800' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                        <span class="font-medium whitespace-nowrap">Customers</span>
                    </a>

                    <a href="{{ route('admin.analytics.index') }}" class="sidebar-link flex items-center space-x-4 px-4 py-3 rounded-lg {{ request()->routeIs('admin.analytics.*') ? 'active' : 'text-gray-300 hover:bg-gray-800' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                        <span class="font-medium whitespace-nowrap">Analytics</span>
                    </a>

                    <a href="{{ route('admin.contacts.index') }}" class="sidebar-link flex items-center space-x-4 px-4 py-3 rounded-lg {{ request()->routeIs('admin.contacts.*') ? 'active' : 'text-gray-300 hover:bg-gray-800' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        <span class="font-medium whitespace-nowrap">Contact Messages</span>
                        @php
                            $newContactCount = \App\Models\Contact::where('status', 'new')->count();
                        @endphp
                        @if($newContactCount > 0)
                            <span class="ml-auto px-2 py-0.5 text-xs font-bold text-white bg-red-500 rounded-full">{{ $newContactCount }}</span>
                        @endif
                    </a>
                @elseif(Auth::user()->isDeveloper())
                    <!-- Developer Navigation -->
                    <a href="{{ route('developer.dashboard') }}" class="sidebar-link flex items-center space-x-4 px-4 py-3 rounded-lg {{ request()->routeIs('developer.dashboard') ? 'active' : 'text-gray-300 hover:bg-gray-800' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        <span class="font-medium whitespace-nowrap">Dashboard</span>
                    </a>

                    <a href="{{ route('developer.products.index') }}" class="sidebar-link flex items-center space-x-4 px-4 py-3 rounded-lg {{ request()->routeIs('developer.products.*') && !request()->routeIs('developer.products.index') ? 'active' : (request()->routeIs('developer.products.index') ? 'active' : 'text-gray-300 hover:bg-gray-800') }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                        </svg>
                        <span class="font-medium whitespace-nowrap">Products</span>
                    </a>

                    <a href="{{ route('developer.categories.index') }}" class="sidebar-link flex items-center space-x-4 px-4 py-3 rounded-lg {{ request()->routeIs('developer.categories.*') ? 'active' : 'text-gray-300 hover:bg-gray-800' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                        </svg>
                        <span class="font-medium whitespace-nowrap">Categories</span>
                    </a>

                    <a href="{{ route('developer.carousels.index') }}" class="sidebar-link flex items-center space-x-4 px-4 py-3 rounded-lg {{ request()->routeIs('developer.carousels.*') ? 'active' : 'text-gray-300 hover:bg-gray-800' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <span class="font-medium whitespace-nowrap">Carousels</span>
                    </a>

                    <a href="{{ route('developer.offers.index') }}" class="sidebar-link flex items-center space-x-4 px-4 py-3 rounded-lg {{ request()->routeIs('developer.offers.*') ? 'active' : 'text-gray-300 hover:bg-gray-800' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"/>
                        </svg>
                        <span class="font-medium whitespace-nowrap">Product Offers</span>
                    </a>

                    <a href="{{ route('developer.orders') }}" class="sidebar-link flex items-center space-x-4 px-4 py-3 rounded-lg {{ request()->routeIs('developer.orders') ? 'active' : 'text-gray-300 hover:bg-gray-800' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                        <span class="font-medium whitespace-nowrap">Orders</span>
                    </a>

                    <a href="{{ route('developer.site-settings.edit') }}" class="sidebar-link flex items-center space-x-4 px-4 py-3 rounded-lg {{ request()->routeIs('developer.site-settings.*') ? 'active' : 'text-gray-300 hover:bg-gray-800' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 13h2M3 6h18M3 6a1 1 0 011-1h16a1 1 0 011 1M3 13a1 1 0 011-1h3a1 1 0 011 1m0 0h10a1 1 0 001-1h3a1 1 0 011 1m-16 0v7a1 1 0 001 1h10a1 1 0 001-1v-7"/>
                        </svg>
                        <span class="font-medium whitespace-nowrap">Site Maintenance</span>
                    </a>

                    <a href="#" class="sidebar-link flex items-center space-x-4 px-4 py-3 rounded-lg text-gray-300 hover:bg-gray-800">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                        <span class="font-medium whitespace-nowrap">Customers</span>
                    </a>

                    <a href="#" class="sidebar-link flex items-center space-x-4 px-4 py-3 rounded-lg text-gray-300 hover:bg-gray-800">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                        <span class="font-medium whitespace-nowrap">Analytics</span>
                    </a>
                @elseif(Auth::user()->isStockManager())
                    <!-- Stock Manager Navigation -->
                    <a href="{{ route('stock-manager.dashboard') }}" class="sidebar-link flex items-center space-x-4 px-4 py-3 rounded-lg {{ request()->routeIs('stock-manager.dashboard') ? 'active' : 'text-gray-300 hover:bg-gray-800' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        <span class="font-medium whitespace-nowrap">Dashboard</span>
                    </a>

                    <a href="{{ route('stock-manager.stocks.index') }}" class="sidebar-link flex items-center space-x-4 px-4 py-3 rounded-lg {{ request()->routeIs('stock-manager.stocks.*') ? 'active' : 'text-gray-300 hover:bg-gray-800' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                        </svg>
                        <span class="font-medium whitespace-nowrap">Stock Management</span>
                    </a>

                    <a href="{{ route('home') }}" class="sidebar-link flex items-center space-x-4 px-4 py-3 rounded-lg text-gray-300 hover:bg-gray-800">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                        <span class="font-medium whitespace-nowrap">Browse Products</span>
                    </a>
                @else
                    <!-- User Navigation -->
                    <a href="javascript:void(0);" onclick="goToDashboard()" data-tab="overview" class="sidebar-link dashboard-tab-link flex items-center space-x-4 px-4 py-3 rounded-lg {{ request()->routeIs('user.dashboard') ? 'active' : 'text-gray-300 hover:bg-gray-800' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        <span class="font-medium whitespace-nowrap">Dashboard</span>
                    </a>

                    <a href="{{ route('home') }}" class="sidebar-link flex items-center space-x-4 px-4 py-3 rounded-lg text-gray-300 hover:bg-gray-800">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                        <span class="font-medium whitespace-nowrap">Browse Products</span>
                    </a>

                    <a href="{{ route('user.wishlist') }}" class="sidebar-link flex items-center space-x-4 px-4 py-3 rounded-lg {{ request()->routeIs('user.wishlist') ? 'active' : 'text-gray-300 hover:bg-gray-800' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                        <span class="font-medium whitespace-nowrap">My Wishlist</span>
                    </a>

                    <a href="{{ route('user.orders') }}" class="sidebar-link flex items-center space-x-4 px-4 py-3 rounded-lg {{ request()->routeIs('user.orders') ? 'active' : 'text-gray-300 hover:bg-gray-800' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                        <span class="font-medium whitespace-nowrap">My Orders</span>
                    </a>

                    <a href="javascript:void(0);" onclick="switchDashboardTab('notifications')" data-tab="notifications" class="sidebar-link dashboard-tab-link flex items-center space-x-4 px-4 py-3 rounded-lg text-gray-300 hover:bg-gray-800">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                        </svg>
                        <span class="font-medium whitespace-nowrap">Notifications</span>
                        <span id="sidebarNotificationBadge" class="ml-auto px-2 py-0.5 text-xs font-bold text-white bg-red-500 rounded-full hidden">0</span>
                    </a>

                    <a href="{{ route('cart') }}" class="sidebar-link flex items-center space-x-4 px-4 py-3 rounded-lg {{ request()->routeIs('cart') ? 'active' : 'text-gray-300 hover:bg-gray-800' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        <span class="font-medium whitespace-nowrap">Shopping Cart</span>
                    </a>

                    <!-- <a href="#" class="sidebar-link flex items-center space-x-4 px-4 py-3 rounded-lg text-gray-300 hover:bg-gray-800">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                        </svg>
                        <span class="font-medium whitespace-nowrap">Track Order</span>
                    </a> -->
                @endif

                <!-- <div class="pt-4 mt-4 border-t border-gray-700">
                    <a href="{{ route('account.settings') }}" class="sidebar-link flex items-center space-x-4 px-4 py-3 rounded-lg {{ request()->routeIs('account.settings*') ? 'active' : 'text-gray-300 hover:bg-gray-800' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <span class="font-medium whitespace-nowrap">Settings</span>
                    </a>
                </div> -->
            </nav>

            <!-- User Profile -->
            <div class="p-4 border-t border-gray-700">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-purple-500 to-pink-500 flex items-center justify-center">
                        <span class="text-sm font-bold">{{ substr(Auth::user()->name, 0, 1) }}</span>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-medium">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-gray-400">
                            @if(Auth::user()->isAdmin())
                                Administrator
                            @elseif(Auth::user()->isDeveloper())
                                Developer
                            @else
                                {{ ucfirst(Auth::user()->role) }}
                            @endif
                        </p>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-gray-400 hover:text-white">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Navigation -->
            <header class="bg-white shadow-sm z-10">
                <div class="flex items-center justify-between px-6 py-4">
                    <div class="flex items-center space-x-4">
                        <button id="sidebar-toggle" class="md:hidden text-gray-500 hover:text-gray-700">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                            </svg>
                        </button>
                        @isset($header)
                            {{ $header }}
                        @endisset
                    </div>
                    <div class="flex items-center space-x-4">
                        @if(!Auth::user()->isAdmin() && !Auth::user()->isDeveloper())
                        <a href="javascript:void(0);" onclick="goToNotifications()" class="relative text-gray-500 hover:text-gray-700 transition">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                            </svg>
                            <span id="notificationBadge" class="absolute -top-1 -right-1 w-5 h-5 bg-red-500 text-white text-xs rounded-full flex items-center justify-center font-bold hidden">0</span>
                        </a>
                        @endif
                        <a href="{{ route('home') }}" target="_blank" class="text-sm text-gray-600 hover:text-gray-900 flex items-center space-x-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                            </svg>
                            <span>View Store</span>
                        </a>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto bg-gray-50 p-6">
                @isset($slot)
                    {{ $slot }}
                @else
                    @yield('content')
                @endisset
            </main>
        </div>
    </div>

    <!-- Delete Modal Component -->
    <x-delete-modal />

    <script>
        // Sidebar toggle for mobile
        document.getElementById('sidebar-toggle')?.addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('hidden');
        });

        // Fetch and update notification count
        @if(!Auth::user()->isAdmin() && !Auth::user()->isDeveloper())
        function updateNotificationCount() {
            fetch('{{ route("user.notifications.unreadCount") }}')
                .then(response => response.json())
                .then(data => {
                    const badge = document.getElementById('notificationBadge');
                    const sidebarBadge = document.getElementById('sidebarNotificationBadge');
                    const countText = data.count > 99 ? '99+' : data.count;

                    // Update header badge
                    if (badge) {
                        if (data.count > 0) {
                            badge.textContent = countText;
                            badge.classList.remove('hidden');
                        } else {
                            badge.classList.add('hidden');
                        }
                    }

                    // Update sidebar badge
                    if (sidebarBadge) {
                        if (data.count > 0) {
                            sidebarBadge.textContent = countText;
                            sidebarBadge.classList.remove('hidden');
                        } else {
                            sidebarBadge.classList.add('hidden');
                        }
                    }
                })
                .catch(error => console.error('Error fetching notification count:', error));
        }

        // Update notification count on page load
        document.addEventListener('DOMContentLoaded', function() {
            updateNotificationCount();

            // Refresh notification count every 30 seconds
            setInterval(updateNotificationCount, 30000);
        });

        // Tab switching function for dashboard sections
        window.switchDashboardTab = function(tabName) {
            // Only works on user dashboard page
            if (!document.querySelector('.dashboard-tab-content')) {
                return;
            }

            // Hide all tab contents
            document.querySelectorAll('.dashboard-tab-content').forEach(tab => {
                tab.classList.add('hidden');
            });

            // Show selected tab
            const selectedTab = document.getElementById('dashboard-tab-' + tabName);
            if (selectedTab) {
                selectedTab.classList.remove('hidden');
            }

            // Update sidebar active state
            document.querySelectorAll('.dashboard-tab-link').forEach(link => {
                link.classList.remove('active');
                link.classList.add('text-gray-300', 'hover:bg-gray-800');
            });

            const activeLink = document.querySelector(`[data-tab="${tabName}"]`);
            if (activeLink) {
                activeLink.classList.add('active');
                activeLink.classList.remove('text-gray-300', 'hover:bg-gray-800');
            }
        };

        // Function to navigate to dashboard
        window.goToDashboard = function() {
            // Check if we're on the dashboard page
            if (document.querySelector('.dashboard-tab-content')) {
                // Already on dashboard, just switch to overview tab
                switchDashboardTab('overview');
            } else {
                // Redirect to dashboard
                window.location.href = '{{ route("user.dashboard") }}';
            }
        };

        // Function to navigate to notifications
        window.goToNotifications = function() {
            // Check if we're on the dashboard page
            if (document.querySelector('.dashboard-tab-content')) {
                // Already on dashboard, just switch tab
                switchDashboardTab('notifications');
            } else {
                // Redirect to dashboard with notifications tab
                window.location.href = '{{ route("user.dashboard") }}#notifications';
            }
        };

        // On page load, initialize dashboard tabs
        document.addEventListener('DOMContentLoaded', function() {
            // Check if we're on dashboard page
            if (document.querySelector('.dashboard-tab-content')) {
                // Check for hash in URL
                if (window.location.hash === '#notifications') {
                    switchDashboardTab('notifications');
                } else if (window.location.hash === '#overview' || !window.location.hash) {
                    // Default to overview tab
                    switchDashboardTab('overview');
                }
            }
        });
        @endif
    </script>
</body>
</html>
