<x-order-manager-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 bg-gradient-to-br from-orange-500 to-orange-500 rounded-lg flex items-center justify-center shadow-lg">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
            </div>
            <div>
                <h2 class="text-2xl font-bold text-gray-800" style="font-family: 'Playfair Display', serif;">Add Shipping Discount Rule</h2>
                <p class="text-sm text-gray-500">Create a new shipping discount rule for a region</p>
            </div>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
            <div class="p-6 border-b border-gray-100">
                <h3 class="text-xl font-bold text-gray-800" style="font-family: 'Playfair Display', serif;">Rule Configuration</h3>
            </div>
            <form action="{{ route('order-manager.shipping-discounts.store') }}" method="POST" class="p-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="rule_name" class="block text-sm font-medium text-gray-700 mb-2">Rule Name</label>
                        <input type="text"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent @error('rule_name') border-red-500 @enderror"
                               id="rule_name"
                               name="rule_name"
                               value="{{ old('rule_name') }}"
                               placeholder="e.g., Kinki Free Shipping - 1-2 Rice">
                        @error('rule_name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="region_id" class="block text-sm font-medium text-gray-700 mb-2">Region <span class="text-red-500">*</span></label>
                        <select name="region_id"
                                id="region_id"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent @error('region_id') border-red-500 @enderror"
                                required>
                            <option value="">Select Region</option>
                            @foreach($regions as $region)
                                <option value="{{ $region->id }}" {{ old('region_id') == $region->id ? 'selected' : '' }}>
                                    {{ $region->region_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('region_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mb-6">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                    <textarea name="description"
                              id="description"
                              rows="2"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent @error('description') border-red-500 @enderror"
                              placeholder="Brief description of this rule">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="border-t pt-6 mb-6">
                    <h4 class="text-lg font-semibold text-gray-800 mb-4">Order Conditions</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="min_order_amount" class="block text-sm font-medium text-gray-700 mb-2">Minimum Order Amount (¥) <span class="text-red-500">*</span></label>
                            <input type="number"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent @error('min_order_amount') border-red-500 @enderror"
                                   id="min_order_amount"
                                   name="min_order_amount"
                                   value="{{ old('min_order_amount', 18000) }}"
                                   step="0.01"
                                   min="0"
                                   required>
                            @error('min_order_amount')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="min_order_weight" class="block text-sm font-medium text-gray-700 mb-2">Minimum Order Weight (kg) <span class="text-red-500">*</span></label>
                            <input type="number"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent @error('min_order_weight') border-red-500 @enderror"
                                   id="min_order_weight"
                                   name="min_order_weight"
                                   value="{{ old('min_order_weight', 20) }}"
                                   step="0.01"
                                   min="0"
                                   required>
                            @error('min_order_weight')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="border-t pt-6 mb-6">
                    <h4 class="text-lg font-semibold text-gray-800 mb-4">Rice Product Configuration</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                        <div>
                            <label for="rice_product_id" class="block text-sm font-medium text-gray-700 mb-2">Rice Product (Optional)</label>
                            <select name="rice_product_id"
                                    id="rice_product_id"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent @error('rice_product_id') border-red-500 @enderror">
                                <option value="">Any Rice Product</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}" {{ old('rice_product_id') == $product->id ? 'selected' : '' }}>
                                        {{ $product->product_name }} ({{ $product->net_weight }}kg)
                                    </option>
                                @endforeach
                            </select>
                            @error('rice_product_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-sm text-gray-500">Select a specific rice product or leave blank for any rice</p>
                        </div>

                        <div>
                            <label for="rice_weight_per_unit" class="block text-sm font-medium text-gray-700 mb-2">Rice Weight Per Unit (kg) <span class="text-red-500">*</span></label>
                            <input type="number"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent @error('rice_weight_per_unit') border-red-500 @enderror"
                                   id="rice_weight_per_unit"
                                   name="rice_weight_per_unit"
                                   value="{{ old('rice_weight_per_unit', 5.0) }}"
                                   step="0.01"
                                   min="0"
                                   required>
                            @error('rice_weight_per_unit')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="min_rice_count" class="block text-sm font-medium text-gray-700 mb-2">Minimum Rice Count <span class="text-red-500">*</span></label>
                            <input type="number"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent @error('min_rice_count') border-red-500 @enderror"
                                   id="min_rice_count"
                                   name="min_rice_count"
                                   value="{{ old('min_rice_count', 1) }}"
                                   min="0"
                                   required>
                            @error('min_rice_count')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="max_rice_count" class="block text-sm font-medium text-gray-700 mb-2">Maximum Rice Count (Optional)</label>
                            <input type="number"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent @error('max_rice_count') border-red-500 @enderror"
                                   id="max_rice_count"
                                   name="max_rice_count"
                                   value="{{ old('max_rice_count') }}"
                                   min="0"
                                   placeholder="Leave blank for no upper limit">
                            @error('max_rice_count')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-sm text-gray-500">Leave empty for unlimited maximum</p>
                        </div>
                    </div>
                </div>

                <div class="border-t pt-6 mb-6">
                    <h4 class="text-lg font-semibold text-gray-800 mb-4">Discount Settings</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                        <div>
                            <label for="discount_percentage" class="block text-sm font-medium text-gray-700 mb-2">Discount Percentage (%) <span class="text-red-500">*</span></label>
                            <input type="number"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent @error('discount_percentage') border-red-500 @enderror"
                                   id="discount_percentage"
                                   name="discount_percentage"
                                   value="{{ old('discount_percentage', 100) }}"
                                   min="0"
                                   max="100"
                                   required>
                            @error('discount_percentage')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-sm text-gray-500">Enter 100 for free shipping, or any value from 0-100</p>
                        </div>

                        <div>
                            <label for="max_weight_limit" class="block text-sm font-medium text-gray-700 mb-2">Maximum Weight Limit (kg)</label>
                            <input type="number"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent @error('max_weight_limit') border-red-500 @enderror"
                                   id="max_weight_limit"
                                   name="max_weight_limit"
                                   value="{{ old('max_weight_limit', 24) }}"
                                   step="0.01"
                                   min="0"
                                   placeholder="Leave blank for no limit">
                            @error('max_weight_limit')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-sm text-gray-500">Free shipping applies up to this weight. Excess weight will be charged normally. Leave blank for unlimited.</p>
                        </div>
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox"
                               id="is_active"
                               name="is_active"
                               value="1"
                               {{ old('is_active', true) ? 'checked' : '' }}
                               class="w-4 h-4 text-orange-600 border-gray-300 rounded focus:ring-orange-500">
                        <label for="is_active" class="ml-2 block text-sm text-gray-900">
                            Activate this rule immediately
                        </label>
                    </div>
                </div>

                <div class="flex gap-3">
                    <button type="submit" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-orange-600 to-orange-600 hover:from-orange-700 hover:to-orange-700 text-white font-semibold rounded-lg shadow-lg transition">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Create Rule
                    </button>
                    <a href="{{ route('order-manager.shipping-discounts.index') }}" class="inline-flex items-center px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold rounded-lg transition">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-order-manager-layout>
