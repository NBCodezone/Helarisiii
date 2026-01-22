<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Category') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Category Name -->
                        <div class="mb-6">
                            <label for="category_name" class="block text-sm font-medium text-gray-700 mb-2">
                                Category Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="category_name" name="category_name" value="{{ old('category_name', $category->category_name) }}" required
                                placeholder="Enter category name"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 @error('category_name') border-red-500 @enderror">
                            @error('category_name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-sm text-gray-500">Enter a unique category name (e.g., Electronics, Clothing, Food)</p>
                        </div>

                        <!-- Category Image -->
                        <div class="mb-6">
                            <label for="image" class="block text-sm font-medium text-gray-700 mb-2">
                                Category Image
                            </label>

                            @if($category->image)
                                <div class="mb-3">
                                    <p class="text-sm text-gray-600 mb-2">Current Image (Background removed):</p>
                                    <img src="{{ asset($category->image) }}" alt="{{ $category->category_name }}" class="w-32 h-32 object-cover rounded-lg border border-gray-200 bg-gray-100">
                                </div>
                            @endif

                            <input type="file" id="image" name="image" accept="image/*"
                                class="mt-1 block w-full text-sm text-gray-500
                                    file:mr-4 file:py-2 file:px-4
                                    file:rounded-md file:border-0
                                    file:text-sm file:font-semibold
                                    file:bg-orange-50 file:text-orange-700
                                    hover:file:bg-orange-100
                                    @error('image') border-red-500 @enderror">
                            @error('image')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-sm text-gray-500">Upload a new image to replace the current one (JPG, PNG, GIF, WEBP - Max 2MB)</p>
                        </div>

                        <!-- Category Info -->
                        <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                            <h3 class="text-sm font-medium text-gray-700 mb-2">Category Information</h3>
                            <div class="text-sm text-gray-600">
                                <p><strong>Total Products:</strong> {{ $category->products()->count() }}</p>
                                <p><strong>Created:</strong> {{ $category->created_at->format('M d, Y H:i') }}</p>
                                <p><strong>Last Updated:</strong> {{ $category->updated_at->format('M d, Y H:i') }}</p>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex items-center space-x-4 pt-4">
                            <button type="submit" class="inline-flex items-center px-6 py-3 bg-orange-600 hover:bg-orange-700 text-gray-700 font-medium rounded-md shadow-sm transition">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
                                </svg>
                                Update Category
                            </button>
                            <a href="{{ route('admin.categories.index') }}" class="inline-flex items-center px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-md shadow-sm transition">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                </svg>
                                Back to List
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
