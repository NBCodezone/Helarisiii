<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-lg flex items-center justify-center shadow-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-800" style="font-family: 'Playfair Display', serif;">Product Sales Analytics</h2>
                    <p class="text-sm text-gray-500">Most and least selling products performance</p>
                </div>
            </div>
            <div class="flex items-center space-x-3 mx-5">
                <form method="GET" action="{{ route('admin.analytics.products') }}" class="flex items-center space-x-2">
                    <select name="period" onchange="this.form.submit()" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                        <option value="7" {{ $period == 7 ? 'selected' : '' }}>Last 7 Days</option>
                        <option value="30" {{ $period == 30 ? 'selected' : '' }}>Last 30 Days</option>
                        <option value="90" {{ $period == 90 ? 'selected' : '' }}>Last 90 Days</option>
                        <option value="365" {{ $period == 365 ? 'selected' : '' }}>Last Year</option>
                    </select>
                </form>
                <a href="{{ route('admin.analytics.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-semibold rounded-lg shadow-lg transition">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Back to Dashboard
                </a>
            </div>
        </div>
    </x-slot>

    <div class="space-y-6">
        <!-- Most Selling Products -->
        <div class="bg-white rounded-2xl shadow-lg p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xl font-bold text-gray-800" style="font-family: 'Playfair Display', serif;">
                    <svg class="w-6 h-6 inline mr-2 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M3.293 9.707a1 1 0 010-1.414l6-6a1 1 0 011.414 0l6 6a1 1 0 01-1.414 1.414L11 5.414V17a1 1 0 11-2 0V5.414L4.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                    </svg>
                    Top 10 Most Selling Products
                </h3>
                <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-sm font-semibold">Best Performers</span>
            </div>

            @if($mostSellingProducts->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Rank</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Product</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Category</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Units Sold</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Total Revenue</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Orders</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($mostSellingProducts as $index => $item)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center justify-center w-10 h-10 rounded-full font-bold text-white
                                            @if($index === 0) bg-gradient-to-br from-yellow-400 to-yellow-500
                                            @elseif($index === 1) bg-gradient-to-br from-gray-400 to-gray-500
                                            @elseif($index === 2) bg-gradient-to-br from-orange-400 to-orange-500
                                            @else bg-gradient-to-br from-blue-400 to-blue-500
                                            @endif">
                                            {{ $index + 1 }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            @if($item->product->image)
                                                <img src="{{ asset($item->product->image) }}" alt="{{ $item->product->product_name }}" class="w-12 h-12 rounded-lg object-cover mr-3">
                                            @else
                                                <div class="w-12 h-12 bg-gradient-to-br from-indigo-100 to-indigo-200 rounded-lg flex items-center justify-center mr-3">
                                                    <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                                    </svg>
                                                </div>
                                            @endif
                                            <div>
                                                <p class="font-semibold text-gray-800">{{ $item->product->product_name }}</p>
                                                <p class="text-sm text-gray-500">¥{{ number_format($item->product->price, 0) }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-3 py-1 bg-purple-100 text-purple-700 text-xs font-semibold rounded-full">
                                            {{ $item->product->category->category_name ?? 'N/A' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-lg font-bold text-green-600">
                                        {{ number_format($item->total_quantity) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-lg font-bold text-gray-800">
                                        ¥{{ number_format($item->total_revenue, 0) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        {{ $item->order_count }} orders
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-12 text-gray-500">
                    <svg class="w-16 h-16 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                    <p class="text-lg font-semibold">No sales data available</p>
                    <p class="text-sm">No products have been sold in the selected period</p>
                </div>
            @endif
        </div>

        <!-- Least Selling Products -->
        <div class="bg-white rounded-2xl shadow-lg p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xl font-bold text-gray-800" style="font-family: 'Playfair Display', serif;">
                    <svg class="w-6 h-6 inline mr-2 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 10.293a1 1 0 010 1.414l-6 6a1 1 0 01-1.414 0l-6-6a1 1 0 111.414-1.414L9 14.586V3a1 1 0 012 0v11.586l4.293-4.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                    </svg>
                    Top 10 Least Selling Products
                </h3>
                <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-sm font-semibold">Needs Attention</span>
            </div>

            @if($leastSellingProducts->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Product</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Category</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Units Sold</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Total Revenue</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Orders</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($leastSellingProducts as $item)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            @if($item->product->image)
                                                <img src="{{ asset($item->product->image) }}" alt="{{ $item->product->product_name }}" class="w-12 h-12 rounded-lg object-cover mr-3">
                                            @else
                                                <div class="w-12 h-12 bg-gradient-to-br from-gray-100 to-gray-200 rounded-lg flex items-center justify-center mr-3">
                                                    <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                                    </svg>
                                                </div>
                                            @endif
                                            <div>
                                                <p class="font-semibold text-gray-800">{{ $item->product->product_name }}</p>
                                                <p class="text-sm text-gray-500">¥{{ number_format($item->product->price, 0) }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-3 py-1 bg-purple-100 text-purple-700 text-xs font-semibold rounded-full">
                                            {{ $item->product->category->category_name ?? 'N/A' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-lg font-bold text-red-600">
                                        {{ number_format($item->total_quantity) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-lg font-bold text-gray-800">
                                        ¥{{ number_format($item->total_revenue, 0) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        {{ $item->order_count }} orders
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-12 text-gray-500">
                    <p>No data available</p>
                </div>
            @endif
        </div>

        <!-- Never Sold Products -->
        @if($neverSoldProducts->count() > 0)
        <div class="bg-white rounded-2xl shadow-lg p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xl font-bold text-gray-800" style="font-family: 'Playfair Display', serif;">
                    <svg class="w-6 h-6 inline mr-2 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                    Products Never Sold (Last {{ $period }} Days)
                </h3>
                <span class="px-3 py-1 bg-orange-100 text-orange-700 rounded-full text-sm font-semibold">{{ $neverSoldProducts->count() }} Products</span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                @foreach($neverSoldProducts as $product)
                    <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition">
                        @if($product->image)
                            <img src="{{ asset($product->image) }}" alt="{{ $product->product_name }}" class="w-full h-32 object-cover rounded-lg mb-3">
                        @else
                            <div class="w-full h-32 bg-gradient-to-br from-gray-100 to-gray-200 rounded-lg flex items-center justify-center mb-3">
                                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                </svg>
                            </div>
                        @endif
                        <p class="font-semibold text-gray-800 text-sm mb-1">{{ Str::limit($product->product_name, 30) }}</p>
                        <p class="text-xs text-gray-500 mb-2">{{ $product->category->category_name ?? 'N/A' }}</p>
                        <p class="text-sm font-bold text-gray-800">¥{{ number_format($product->price, 0) }}</p>
                    </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Category Performance -->
        <div class="bg-white rounded-2xl shadow-lg p-6">
            <h3 class="text-xl font-bold text-gray-800 mb-4" style="font-family: 'Playfair Display', serif;">Category Performance</h3>

            @if($categoryPerformance->count() > 0)
                <div class="space-y-4">
                    @foreach($categoryPerformance as $index => $cat)
                        <div class="border-l-4 {{ $index === 0 ? 'border-green-500' : 'border-gray-300' }} pl-4">
                            <div class="flex items-center justify-between mb-2">
                                <div>
                                    <p class="font-semibold text-gray-800">{{ $cat->category->category_name ?? 'Unknown' }}</p>
                                    <p class="text-sm text-gray-500">{{ $cat->order_count }} orders</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-lg font-bold text-gray-800">¥{{ number_format($cat->total_revenue, 0) }}</p>
                                    <p class="text-sm text-gray-500">{{ number_format($cat->total_quantity) }} units</p>
                                </div>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                @php
                                    $maxRevenue = $categoryPerformance->max('total_revenue');
                                    $percentage = $maxRevenue > 0 ? ($cat->total_revenue / $maxRevenue) * 100 : 0;
                                @endphp
                                <div class="bg-gradient-to-r from-green-500 to-green-600 h-2 rounded-full" style="width: {{ $percentage }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8 text-gray-500">
                    <p>No category data available</p>
                </div>
            @endif
        </div>
    </div>
</x-admin-layout>
