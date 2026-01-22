@extends('layouts.admin')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Add New Product Offer</h1>
        <a href="{{ route('admin.offers.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2.5 rounded-lg shadow-md transition duration-200">Back to List</a>
    </div>

    <div class="bg-white rounded-xl shadow-md p-8">
        <form action="{{ route('admin.offers.store') }}" method="POST">
            @csrf

            <div class="mb-6">
                <label for="title" class="block text-sm font-semibold text-gray-700 mb-2">Title <span class="text-red-500">*</span></label>
                <input type="text" class="w-full px-4 py-3 border @error('title') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent transition" id="title" name="title" value="{{ old('title') }}" placeholder="e.g., Find The Best Watches for You!" required>
                @error('title')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="product_name" class="block text-sm font-semibold text-gray-700 mb-2">Product Name <span class="text-red-500">*</span></label>
                <input type="text" class="w-full px-4 py-3 border @error('product_name') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent transition" id="product_name" name="product_name" value="{{ old('product_name') }}" placeholder="e.g., Smart Watch" required>
                @error('product_name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="discount_percentage" class="block text-sm font-semibold text-gray-700 mb-2">Discount Percentage <span class="text-red-500">*</span></label>
                <input type="number" class="w-full px-4 py-3 border @error('discount_percentage') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent transition" id="discount_percentage" name="discount_percentage" value="{{ old('discount_percentage') }}" min="0" max="100" placeholder="e.g., 20" required>
                @error('discount_percentage')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="product_id" class="block text-sm font-semibold text-gray-700 mb-2">Select Product <span class="text-red-500">*</span></label>
                <select class="w-full px-4 py-3 border @error('product_id') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent transition" id="product_id" name="product_id" required>
                    <option value="">-- Select Product --</option>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                            {{ $product->product_name }} @if($product->price) - ${{ $product->price }} @endif
                        </option>
                    @endforeach
                </select>
                <p class="text-gray-500 text-sm mt-1">The product's image and link will be used in the offer</p>
                @error('product_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="order" class="block text-sm font-semibold text-gray-700 mb-2">Display Order</label>
                <input type="number" class="w-full px-4 py-3 border @error('order') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent transition" id="order" name="order" value="{{ old('order', 0) }}" min="0">
                <p class="text-gray-500 text-sm mt-1">Lower numbers appear first</p>
                @error('order')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end space-x-4">
                <a href="{{ route('admin.offers.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-lg transition duration-200">Cancel</a>
                <button type="submit" class="bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white px-8 py-3 rounded-lg shadow-md hover:shadow-lg transition duration-200">Create Product Offer</button>
            </div>
        </form>
    </div>
</div>
@endsection
