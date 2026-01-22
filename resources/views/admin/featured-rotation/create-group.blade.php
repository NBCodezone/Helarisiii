<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-green-600 rounded-lg flex items-center justify-center shadow-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-800" style="font-family: 'Playfair Display', serif;">Create Product Group</h2>
                    <p class="text-sm text-gray-500">Add a new featured product group</p>
                </div>
            </div>
            <a href="{{ route('admin.featured-rotation.groups') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-semibold rounded-lg shadow-lg transition mx-5">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Groups
            </a>
        </div>
    </x-slot>

    <div class="bg-white rounded-2xl shadow-lg p-6">
        <form action="{{ route('admin.featured-rotation.groups.store') }}" method="POST">
            @csrf

            <div class="space-y-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Group Name *</label>
                    <input type="text" name="name" value="{{ old('name') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" required>
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Display Order *</label>
                    <input type="number" name="order" value="{{ old('order', 0) }}" min="0" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" required>
                    <p class="text-xs text-gray-500 mt-1">Lower numbers will be shown first in the rotation</p>
                    @error('order')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="flex items-center cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="w-5 h-5 text-green-600 border-gray-300 rounded focus:ring-green-500">
                        <span class="ml-2 text-sm font-semibold text-gray-700">Active (Include in rotation)</span>
                    </label>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-3">Select Products *</label>
                    <div class="border border-gray-300 rounded-lg p-4 max-h-96 overflow-y-auto">
                        <div class="mb-3">
                            <input type="text" id="productSearch" placeholder="Search products..." class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                        </div>
                        <div id="productList" class="space-y-2">
                            @foreach($products as $product)
                                <label class="flex items-center p-3 hover:bg-gray-50 rounded-lg cursor-pointer product-item">
                                    <input type="checkbox" name="product_ids[]" value="{{ $product->id }}" class="w-5 h-5 text-green-600 border-gray-300 rounded focus:ring-green-500">
                                    <div class="ml-3 flex-1">
                                        <p class="font-semibold text-gray-800 product-name">{{ $product->product_name }}</p>
                                        <p class="text-sm text-gray-500">{{ $product->category->category_name ?? 'No Category' }} - ¥{{ number_format($product->price, 0) }}</p>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    </div>
                    @error('product_ids')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-end space-x-3 pt-4 border-t">
                    <a href="{{ route('admin.featured-rotation.groups') }}" class="px-6 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold rounded-lg transition">
                        Cancel
                    </a>
                    <button type="submit" class="inline-flex items-center px-6 py-2 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-semibold rounded-lg shadow-lg transition">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                        </svg>
                        Create Group
                    </button>
                </div>
            </div>
        </form>
    </div>

    <script>
        document.getElementById('productSearch').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            document.querySelectorAll('.product-item').forEach(item => {
                const productName = item.querySelector('.product-name').textContent.toLowerCase();
                item.style.display = productName.includes(searchTerm) ? 'flex' : 'none';
            });
        });
    </script>
</x-admin-layout>
