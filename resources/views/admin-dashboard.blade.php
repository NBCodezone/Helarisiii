<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 bg-gradient-to-br from-orange-500 to-orange-500 rounded-lg flex items-center justify-center shadow-lg">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
            </div>
            <div>
                <h2 class="text-2xl font-bold text-gray-800" style="font-family: 'Playfair Display', serif;">Dashboard</h2>
                <p class="text-sm text-gray-500">Welcome back, {{ Auth::user()->name }}</p>
            </div>
        </div>
    </x-slot>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Revenue Card -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden card-hover border-t-4 border-orange-500">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl flex items-center justify-center shadow-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    @php
                        $totalRevenue = \App\Models\Order::where('status', 'approved')->sum('total_amount');
                        $previousRevenue = \App\Models\Order::where('status', 'approved')
                            ->where('created_at', '<', now()->subDays(30))
                            ->sum('total_amount');
                        $percentageChange = $previousRevenue > 0 ? (($totalRevenue - $previousRevenue) / $previousRevenue) * 100 : 0;
                    @endphp
                    @if($percentageChange > 0)
                        <span class="text-xs font-semibold text-green-600 bg-green-100 px-2 py-1 rounded-full">+{{ number_format($percentageChange, 1) }}%</span>
                    @elseif($percentageChange < 0)
                        <span class="text-xs font-semibold text-red-600 bg-red-100 px-2 py-1 rounded-full">{{ number_format($percentageChange, 1) }}%</span>
                    @else
                        <span class="text-xs font-semibold text-gray-600 bg-gray-100 px-2 py-1 rounded-full">0%</span>
                    @endif
                </div>
                <h3 class="text-gray-500 text-sm font-medium mb-1">Total Revenue</h3>
                <p class="text-3xl font-bold text-gray-900" style="font-family: 'Playfair Display', serif;">¥ {{ number_format($totalRevenue, 2) }}</p>
                <p class="text-xs text-gray-400 mt-2">From approved orders</p>
            </div>
        </div>

        <!-- Total Products Card -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden card-hover border-t-4 border-blue-500">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                        </svg>
                    </div>
                    <span class="text-xs font-semibold text-blue-600 bg-blue-100 px-2 py-1 rounded-full">Active</span>
                </div>
                <h3 class="text-gray-500 text-sm font-medium mb-1">Total Products</h3>
                <p class="text-3xl font-bold text-gray-900" style="font-family: 'Playfair Display', serif;">{{ \App\Models\Product::count() }}</p>
                <p class="text-xs text-gray-400 mt-2">In inventory</p>
            </div>
        </div>

        <!-- Total Orders Card -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden card-hover border-t-4 border-amber-500">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-amber-500 to-amber-600 rounded-xl flex items-center justify-center shadow-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                    </div>
                    @php
                        $totalOrders = \App\Models\Order::count();
                        $approvedOrders = \App\Models\Order::where('status', 'approved')->count();
                        $pendingOrders = \App\Models\Order::where('status', 'pending')->count();
                    @endphp
                    <span class="text-xs font-semibold text-amber-600 bg-amber-100 px-2 py-1 rounded-full">{{ $approvedOrders }} approved</span>
                </div>
                <h3 class="text-gray-500 text-sm font-medium mb-1">Total Orders</h3>
                <p class="text-3xl font-bold text-gray-900" style="font-family: 'Playfair Display', serif;">{{ number_format($totalOrders) }}</p>
                <p class="text-xs text-gray-400 mt-2">{{ $pendingOrders }} pending approval</p>
            </div>
        </div>

        <!-- Total Customers Card -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden card-hover border-t-4 border-orange-500">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl flex items-center justify-center shadow-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </div>
                    <span class="text-xs font-semibold text-orange-600 bg-orange-100 px-2 py-1 rounded-full">+15.3%</span>
                </div>
                <h3 class="text-gray-500 text-sm font-medium mb-1">Total Customers</h3>
                <p class="text-3xl font-bold text-gray-900" style="font-family: 'Playfair Display', serif;">{{ \App\Models\User::where('role', 'user')->count() }}</p>
                <p class="text-xs text-gray-400 mt-2">Registered users</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <!-- Recent Products -->
        <div class="lg:col-span-2 bg-white rounded-2xl shadow-lg overflow-hidden">
            <div class="p-6 border-b border-gray-100">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-gradient-to-br from-orange-100 to-orange-100 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900" style="font-family: 'Playfair Display', serif;">Recent Products</h3>
                    </div>
                    <a href="{{ route('admin.products.index') }}" class="text-sm text-orange-600 hover:text-orange-700 font-medium">View All →</a>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-100">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Product</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Category</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Price</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Stock</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @forelse(\App\Models\Product::latest()->take(5)->get() as $product)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-gradient-to-br from-orange-400 to-orange-400 rounded-lg flex items-center justify-center text-white font-bold">
                                        {{ substr($product->name, 0, 1) }}
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900">{{ Str::limit($product->name, 30) }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs font-medium text-orange-600 bg-orange-100 rounded-full">
                                    {{ $product->category->name ?? 'N/A' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900" style="font-family: 'Playfair Display', serif;">
                                ¥{{ number_format($product->price, 2) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $product->stock }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-700">
                                    Active
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center">
                                <div class="flex flex-col items-center space-y-3">
                                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center">
                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                                        </svg>
                                    </div>
                                    <p class="text-sm text-gray-500">No products found.</p>
                                    <a href="{{ route('admin.products.create') }}" class="text-sm text-orange-600 hover:text-orange-700 font-medium">Create your first product →</a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
            <div class="p-6 border-b border-gray-100">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-100 to-orange-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900" style="font-family: 'Playfair Display', serif;">Quick Actions</h3>
                </div>
            </div>
            <div class="p-6 space-y-3">
                <a href="{{ route('admin.products.create') }}" class="flex items-center space-x-3 p-4 bg-gradient-to-r from-orange-50 to-orange-50 hover:from-orange-100 hover:to-orange-100 rounded-xl transition group">
                    <div class="w-10 h-10 bg-gradient-to-br from-orange-500 to-orange-500 rounded-lg flex items-center justify-center shadow-lg group-hover:scale-110 transition">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-gray-900">Add New Product</p>
                        <p class="text-xs text-gray-500">CreateProduct item</p>
                    </div>
                </a>

                <a href="{{ route('admin.categories.create') }}" class="flex items-center space-x-3 p-4 bg-gradient-to-r from-blue-50 to-cyan-50 hover:from-blue-100 hover:to-cyan-100 rounded-xl transition group">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-lg flex items-center justify-center shadow-lg group-hover:scale-110 transition">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-gray-900">Add Category</p>
                        <p class="text-xs text-gray-500">Organize products</p>
                    </div>
                </a>

                <a href="{{ route('admin.products.index') }}" class="flex items-center space-x-3 p-4 bg-gradient-to-r from-amber-50 to-orange-50 hover:from-amber-100 hover:to-orange-100 rounded-xl transition group">
                    <div class="w-10 h-10 bg-gradient-to-br from-amber-500 to-orange-500 rounded-lg flex items-center justify-center shadow-lg group-hover:scale-110 transition">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-gray-900">Manage Inventory</p>
                        <p class="text-xs text-gray-500">View all products</p>
                    </div>
                </a>

                <a href="{{ route('admin.orders') }}" class="flex items-center space-x-3 p-4 bg-gradient-to-r from-purple-50 to-pink-50 hover:from-purple-100 hover:to-pink-100 rounded-xl transition group">
                    <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-pink-500 rounded-lg flex items-center justify-center shadow-lg group-hover:scale-110 transition">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-gray-900">Manage Orders</p>
                        <p class="text-xs text-gray-500">View all orders</p>
                    </div>
                </a>

                <a href="{{ route('admin.analytics.index') }}" class="flex items-center space-x-3 p-4 bg-gradient-to-r from-green-50 to-emerald-50 hover:from-green-100 hover:to-emerald-100 rounded-xl transition group">
                    <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-emerald-500 rounded-lg flex items-center justify-center shadow-lg group-hover:scale-110 transition">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-gray-900">View Reports</p>
                        <p class="text-xs text-gray-500">Sales analytics</p>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <!-- Categories Overview -->
    <!-- <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        <div class="p-6 border-b border-gray-100">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-amber-100 to-orange-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900" style="font-family: 'Playfair Display', serif;">Product Categories</h3>
                </div>
                <a href="{{ route('admin.categories.index') }}" class="text-sm text-orange-600 hover:text-orange-700 font-medium">Manage →</a>
            </div>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
                @forelse(\App\Models\Category::all() as $category)
                <div class="bg-gradient-to-br from-orange-50 to-orange-50 rounded-xl p-4 text-center hover:shadow-md transition group cursor-pointer">
                    <div class="w-12 h-12 bg-gradient-to-br from-orange-400 to-orange-400 rounded-full mx-auto mb-3 flex items-center justify-center text-white font-bold text-lg group-hover:scale-110 transition">
                        {{ substr($category->name, 0, 1) }}
                    </div>
                    <p class="text-sm font-semibold text-gray-900">{{ $category->name }}</p>
                    <p class="text-xs text-gray-500 mt-1">{{ $category->products->count() }} items</p>
                </div>
                @empty
                <div class="col-span-full text-center py-8">
                    <p class="text-sm text-gray-500">No categories yet.</p>
                    <a href="{{ route('admin.categories.create') }}" class="text-sm text-orange-600 hover:text-orange-700 font-medium mt-2 inline-block">Create first category →</a>
                </div>
                @endforelse
            </div>
        </div>
    </div> -->
</x-admin-layout>
