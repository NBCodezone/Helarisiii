<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg flex items-center justify-center shadow-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-800" style="font-family: 'Playfair Display', serif;">Featured Product Rotation</h2>
                    <p class="text-sm text-gray-500">Sliding window rotation - shows {{ $settings->products_per_rotation }} products, moves forward by 1 every rotation</p>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="space-y-6">
        @if(session('success'))
            <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-lg">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span class="text-green-800 font-medium">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        <!-- Current Status -->
        <div class="bg-white rounded-2xl shadow-lg p-6">
            <h3 class="text-xl font-bold text-gray-800 mb-4" style="font-family: 'Playfair Display', serif;">Current Rotation Status</h3>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Status</p>
                            <p class="text-xl font-bold">
                                @if($settings->is_enabled)
                                    <span class="text-green-600">Enabled</span>
                                @else
                                    <span class="text-red-600">Disabled</span>
                                @endif
                            </p>
                        </div>
                        <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center">
                            @if($settings->is_enabled)
                                <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                            @else
                                <svg class="w-5 h-5 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                </svg>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl p-4">
                    <p class="text-sm text-gray-600 mb-1">Current Window Position</p>
                    <p class="text-xl font-bold text-gray-800">
                        Product #{{ $rotationStatus['showing_from'] }} - #{{ $rotationStatus['showing_to'] }}
                    </p>
                    <p class="text-xs text-gray-500 mt-1">of {{ $rotationStatus['total_products'] }} total products</p>
                </div>

                <div class="bg-gradient-to-br from-orange-50 to-orange-100 rounded-xl p-4">
                    <p class="text-sm text-gray-600 mb-1">Next Slide</p>
                    <p class="text-lg font-bold text-gray-800">
                        @if($nextRotation)
                            {{ $nextRotation->diffForHumans() }}
                        @else
                            Not scheduled
                        @endif
                    </p>
                    <p class="text-xs text-gray-500 mt-1">Every {{ $settings->rotation_interval }} {{ $settings->rotation_type }}</p>
                </div>

                <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl p-4">
                    <p class="text-sm text-gray-600 mb-1">Last Rotated</p>
                    <p class="text-lg font-bold text-gray-800">
                        @if($settings->last_rotated_at)
                            {{ $settings->last_rotated_at->diffForHumans() }}
                        @else
                            Never
                        @endif
                    </p>
                </div>
            </div>
        </div>

        <!-- How It Works -->
        <div class="bg-gradient-to-r from-purple-600 to-purple-700 rounded-2xl shadow-lg p-6 text-white">
            <h3 class="text-xl font-bold mb-3">How Sliding Window Rotation Works</h3>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 text-sm">
                <div class="bg-white/10 rounded-lg p-3">
                    <div class="font-bold mb-1">Step 1</div>
                    <p>Shows 8 products starting from position 1 (products 1-8)</p>
                </div>
                <div class="bg-white/10 rounded-lg p-3">
                    <div class="font-bold mb-1">After 6 hours</div>
                    <p>Window slides by 1. Product 1 disappears, now shows products 2-9</p>
                </div>
                <div class="bg-white/10 rounded-lg p-3">
                    <div class="font-bold mb-1">After 12 hours</div>
                    <p>Window slides again. Product 2 disappears, now shows products 3-10</p>
                </div>
                <div class="bg-white/10 rounded-lg p-3">
                    <div class="font-bold mb-1">Continues...</div>
                    <p>Window keeps sliding until it wraps around to the beginning</p>
                </div>
            </div>
        </div>

        <!-- Rotation Settings -->
        <div class="bg-white rounded-2xl shadow-lg p-6">
            <h3 class="text-xl font-bold text-gray-800 mb-4" style="font-family: 'Playfair Display', serif;">Rotation Settings</h3>
            <form action="{{ route('admin.featured-rotation.update-settings') }}" method="POST" class="space-y-4">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Rotation Interval Type</label>
                        <select name="rotation_type" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                            <option value="hours" {{ $settings->rotation_type === 'hours' ? 'selected' : '' }}>Hours</option>
                            <option value="days" {{ $settings->rotation_type === 'days' ? 'selected' : '' }}>Days</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Rotation Interval</label>
                        <input type="number" name="rotation_interval" value="{{ $settings->rotation_interval }}" min="1" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent" required>
                        <p class="text-xs text-gray-500 mt-1">Slide window forward by 1 product every X {{ $settings->rotation_type }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Products to Display</label>
                        <input type="number" name="products_per_rotation" value="{{ $settings->products_per_rotation }}" min="1" max="50" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent" required>
                        <p class="text-xs text-gray-500 mt-1">Number of products shown at a time</p>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Order Products By</label>
                        <select name="product_order_by" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                            <option value="created_at" {{ ($settings->product_order_by ?? 'created_at') === 'created_at' ? 'selected' : '' }}>Date Added</option>
                            <option value="product_name" {{ ($settings->product_order_by ?? '') === 'product_name' ? 'selected' : '' }}>Product Name</option>
                            <option value="price" {{ ($settings->product_order_by ?? '') === 'price' ? 'selected' : '' }}>Price</option>
                            <option value="id" {{ ($settings->product_order_by ?? '') === 'id' ? 'selected' : '' }}>Product ID</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Order Direction</label>
                        <select name="product_order_direction" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                            <option value="asc" {{ ($settings->product_order_direction ?? 'asc') === 'asc' ? 'selected' : '' }}>Ascending (First to Last)</option>
                            <option value="desc" {{ ($settings->product_order_direction ?? '') === 'desc' ? 'selected' : '' }}>Descending (Last to First)</option>
                        </select>
                    </div>

                    <div class="flex items-center pt-6">
                        <label class="flex items-center cursor-pointer">
                            <input type="checkbox" name="is_enabled" value="1" {{ $settings->is_enabled ? 'checked' : '' }} class="w-5 h-5 text-purple-600 border-gray-300 rounded focus:ring-purple-500">
                            <span class="ml-2 text-sm font-semibold text-gray-700">Enable Automatic Rotation</span>
                        </label>
                    </div>
                </div>

                <div class="flex flex-wrap gap-3 pt-4 border-t">
                    <button type="submit" class="inline-flex items-center px-6 py-2 bg-gradient-to-r from-purple-600 to-purple-700 hover:from-purple-700 hover:to-purple-800 text-white font-semibold rounded-lg shadow-lg transition">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                        </svg>
                        Save Settings
                    </button>
            </form>

                    <form action="{{ route('admin.featured-rotation.force') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="inline-flex items-center px-6 py-2 bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white font-semibold rounded-lg shadow-lg transition">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"/>
                            </svg>
                            Slide Forward Now
                        </button>
                    </form>

                    <form action="{{ route('admin.featured-rotation.reset') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="inline-flex items-center px-6 py-2 bg-gradient-to-r from-gray-500 to-gray-600 hover:from-gray-600 hover:to-gray-700 text-white font-semibold rounded-lg shadow-lg transition" onclick="return confirm('Are you sure you want to reset the rotation? This will start from product #1 again.')">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                            </svg>
                            Reset to Start
                        </button>
                    </form>
                </div>
        </div>

        <!-- Currently Featured Products Preview -->
        <div class="bg-white rounded-2xl shadow-lg p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xl font-bold text-gray-800" style="font-family: 'Playfair Display', serif;">Currently Featured Products ({{ $currentProducts->count() }})</h3>
                <span class="px-3 py-1 bg-purple-100 text-purple-700 rounded-full text-sm font-semibold">
                    Position {{ $rotationStatus['current_offset'] + 1 }} - {{ $rotationStatus['current_offset'] + $currentProducts->count() }}
                </span>
            </div>

            @if($currentProducts->count() > 0)
                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-8 gap-3">
                    @foreach($currentProducts as $index => $product)
                        <div class="bg-gray-50 rounded-lg p-2 text-center relative">
                            <span class="absolute top-1 left-1 w-5 h-5 bg-purple-600 text-white text-xs rounded-full flex items-center justify-center font-bold">
                                {{ $rotationStatus['current_offset'] + $index + 1 }}
                            </span>
                            <img src="{{ asset($product->image) }}" alt="{{ $product->product_name }}" class="w-full h-16 object-cover rounded mb-1" onerror="this.src='{{ asset('Electro-Bootstrap-1.0.0/img/product-3.png') }}'">
                            <p class="text-xs font-medium text-gray-700 truncate">{{ Str::limit($product->product_name, 15) }}</p>
                            <p class="text-xs text-purple-600 font-bold">¥{{ number_format($product->price) }}</p>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8 text-gray-500">
                    <p>No products available</p>
                </div>
            @endif
        </div>

        <!-- All Products Queue -->
        <div class="bg-white rounded-2xl shadow-lg p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xl font-bold text-gray-800" style="font-family: 'Playfair Display', serif;">Product Queue ({{ $allProducts->count() }} products)</h3>
                <p class="text-sm text-gray-500">Ordered by: {{ ucfirst(str_replace('_', ' ', $settings->product_order_by ?? 'created_at')) }} ({{ $settings->product_order_direction ?? 'asc' }})</p>
            </div>

            @if($allProducts->count() > 0)
                <div class="overflow-x-auto">
                    <div class="flex space-x-2 pb-2" style="min-width: max-content;">
                        @foreach($allProducts as $index => $product)
                            @php
                                $isCurrentlyFeatured = $index >= $rotationStatus['current_offset'] && $index < $rotationStatus['current_offset'] + $settings->products_per_rotation;
                            @endphp
                            <div class="flex-shrink-0 w-20 {{ $isCurrentlyFeatured ? 'ring-2 ring-purple-500 bg-purple-50' : 'bg-gray-50' }} rounded-lg p-2 text-center relative">
                                <span class="absolute -top-2 -left-2 w-5 h-5 {{ $isCurrentlyFeatured ? 'bg-purple-600' : 'bg-gray-400' }} text-white text-xs rounded-full flex items-center justify-center font-bold">
                                    {{ $index + 1 }}
                                </span>
                                <img src="{{ asset($product->image) }}" alt="{{ $product->product_name }}" class="w-full h-12 object-cover rounded mb-1" onerror="this.src='{{ asset('Electro-Bootstrap-1.0.0/img/product-3.png') }}'">
                                <p class="text-xs font-medium text-gray-700 truncate">{{ Str::limit($product->product_name, 10) }}</p>
                                @if($isCurrentlyFeatured)
                                    <span class="text-xs text-purple-600 font-bold">SHOWING</span>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
                <p class="text-xs text-gray-500 mt-2 text-center">
                    <span class="inline-block w-3 h-3 bg-purple-500 rounded mr-1"></span> Currently showing
                    <span class="inline-block w-3 h-3 bg-gray-400 rounded ml-3 mr-1"></span> In queue
                </p>
            @else
                <div class="text-center py-8 text-gray-500">
                    <p>No products in the system</p>
                </div>
            @endif
        </div>
    </div>
</x-admin-layout>
