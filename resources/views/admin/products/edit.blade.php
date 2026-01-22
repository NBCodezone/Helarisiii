<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-emerald-500 rounded-lg flex items-center justify-center shadow-lg">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
            </div>
            <div>
                <h2 class="text-2xl font-bold text-gray-800" style="font-family: 'Playfair Display', serif;">Edit Product</h2>
                <p class="text-sm text-gray-500">Update product details to your inventory</p>
            </div>
        </div>
    </x-slot>

    <div class="max-w-5xl">
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
            <div class="p-8">
                <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Category -->
                    <div class="mb-6">
                        <label for="category_id" class="block text-sm font-semibold text-gray-700 mb-2">
                            Category <span class="text-red-500">*</span>
                        </label>
                        <select id="category_id" name="category_id" required
                            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-orange-500 focus:ring focus:ring-orange-200 @error('category_id') border-red-500 @enderror">
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->category_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Product Name -->
                    <div class="mb-6">
                        <label for="product_name" class="block text-sm font-semibold text-gray-700 mb-2">
                            Product Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="product_name" name="product_name" value="{{ old('product_name', $product->product_name) }}" required
                            placeholder="e.g., Diamond Engagement Ring"
                            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-orange-500 focus:ring focus:ring-orange-200 @error('product_name') border-red-500 @enderror">
                        @error('product_name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Price, Stock and Net Weight Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                        <!-- Price -->
                        <div>
                            <label for="price" class="block text-sm font-semibold text-gray-700 mb-2">
                                Price (¥) <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500 font-medium">¥</span>
                                <input type="number" id="price" name="price" value="{{ old('price', $product->price) }}" required step="0.01" min="0"
                                    placeholder="0.00"
                                    class="mt-1 block w-full pl-8 rounded-lg border-gray-300 shadow-sm focus:border-orange-500 focus:ring focus:ring-orange-200 @error('price') border-red-500 @enderror">
                            </div>
                            @error('price')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Stock -->
                        <div>
                            <label for="stock" class="block text-sm font-semibold text-gray-700 mb-2">
                                Stock Quantity <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="number" id="stock" name="stock" value="{{ old('stock', $product->stock) }}" required min="0"
                                    placeholder="0"
                                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-orange-500 focus:ring focus:ring-orange-200 @error('stock') border-red-500 @enderror">
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                    </svg>
                                </div>
                            </div>
                            @error('stock')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Net Weight -->
                        <div>
                            <label for="net_weight" class="block text-sm font-semibold text-gray-700 mb-2">
                                Net Weight (kg) <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="number" id="net_weight" name="net_weight" value="{{ old('net_weight', $product->net_weight) }}" required step="0.01" min="0"
                                    placeholder="0.00"
                                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-orange-500 focus:ring focus:ring-orange-200 @error('net_weight') border-red-500 @enderror">
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                    <span class="text-gray-400 text-sm font-medium">kg</span>
                                </div>
                            </div>
                            @error('net_weight')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Main Product Image -->
                    <div class="mb-6">
                        <label for="image" class="block text-sm font-semibold text-gray-700 mb-2">
                            Main Product Image
                        </label>
                        @if($product->image)
                            <div class="mb-4 p-4 bg-gray-50 rounded-lg">
                                <p class="text-sm text-gray-600 mb-2">Current Image:</p>
                                <img src="{{ asset($product->image) }}" class="h-48 w-auto rounded-lg shadow-md" alt="{{ $product->product_name }}">
                            </div>
                        @endif
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-orange-400 transition">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-gray-600">
                                    <label for="image" class="relative cursor-pointer bg-white rounded-md font-medium text-orange-600 hover:text-orange-500 focus-within:outline-none">
                                        <span>{{ $product->image ? 'Replace main image' : 'Upload main image' }}</span>
                                        <input id="image" name="image" type="file" class="sr-only" accept="image/*" onchange="previewMainImage(event)">
                                    </label>
                                    <p class="pl-1">or drag and drop</p>
                                </div>
                                <p class="text-xs text-gray-500">PNG, JPG, GIF up to 2MB</p>
                            </div>
                        </div>
                        <div id="mainImagePreview" class="mt-4 hidden">
                            <p class="text-sm text-gray-600 mb-2">New Image Preview:</p>
                            <img id="mainPreview" class="h-48 w-auto mx-auto rounded-lg shadow-md" src="" alt="Preview">
                        </div>
                        @error('image')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Existing Gallery Images -->
                    @if($product->images->count() > 0)
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Current Gallery Images
                        </label>
                        <div class="grid grid-cols-4 gap-4 p-4 bg-gray-50 rounded-lg">
                            @foreach($product->images as $galleryImage)
                            <div class="relative group">
                                <img src="{{ asset($galleryImage->image_path) }}" class="h-24 w-full object-cover rounded-lg shadow-md" alt="Gallery Image">
                                <div class="absolute inset-0 bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 transition-opacity rounded-lg flex items-center justify-center">
                                    <label class="cursor-pointer">
                                        <input type="checkbox" name="delete_gallery_images[]" value="{{ $galleryImage->id }}" class="sr-only peer">
                                        <span class="inline-flex items-center px-2 py-1 bg-red-500 text-white text-xs rounded peer-checked:bg-red-700">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                            Delete
                                        </span>
                                    </label>
                                </div>
                                <span class="absolute top-1 left-1 bg-orange-500 text-white text-xs px-2 py-1 rounded">{{ $loop->iteration }}</span>
                            </div>
                            @endforeach
                        </div>
                        <p class="mt-2 text-sm text-gray-500">Hover over images and click "Delete" to mark them for removal</p>
                    </div>
                    @endif

                    <!-- Add More Gallery Images -->
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Add Gallery Images <span class="text-gray-400 font-normal">(Optional - up to {{ 4 - $product->images->count() }} more images)</span>
                        </label>
                        @if($product->images->count() >= 4)
                            <div class="p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                                <p class="text-sm text-yellow-700">Maximum 4 gallery images reached. Delete existing images to add new ones.</p>
                            </div>
                        @else
                            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-orange-400 transition">
                                <div class="space-y-1 text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="flex text-sm text-gray-600">
                                        <label for="gallery_images" class="relative cursor-pointer bg-white rounded-md font-medium text-orange-600 hover:text-orange-500 focus-within:outline-none">
                                            <span>Upload gallery images</span>
                                            <input id="gallery_images" name="gallery_images[]" type="file" class="sr-only" accept="image/*" multiple onchange="previewGalleryImages(event, {{ 4 - $product->images->count() }})">
                                        </label>
                                        <p class="pl-1">or drag and drop</p>
                                    </div>
                                    <p class="text-xs text-gray-500">PNG, JPG, GIF up to 2MB each</p>
                                </div>
                            </div>
                            <div id="galleryPreview" class="mt-4 hidden">
                                <p class="text-sm text-gray-600 mb-2">New Gallery Images Preview:</p>
                                <div class="grid grid-cols-4 gap-4" id="galleryPreviewGrid"></div>
                            </div>
                        @endif
                        @error('gallery_images.*')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="mb-6">
                        <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">
                            Description
                        </label>
                        <textarea id="description" name="description" rows="5"
                            placeholder="Describe the product details, materials, craftsmanship, etc."
                            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-orange-500 focus:ring focus:ring-orange-200 @error('description') border-red-500 @enderror">{{ old('description', $product->description) }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Is Frozen -->
                    <div class="mb-8">
                        <label for="is_frozen" class="block text-sm font-semibold text-gray-700 mb-2">
                            Is Product Frozen? <span class="text-red-500">*</span>
                        </label>
                        <select id="is_frozen" name="is_frozen" required
                            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-orange-500 focus:ring focus:ring-orange-200 @error('is_frozen') border-red-500 @enderror">
                            <option value="0" {{ old('is_frozen', $product->is_frozen) == 0 ? 'selected' : '' }}>No</option>
                            <option value="1" {{ old('is_frozen', $product->is_frozen) == 1 ? 'selected' : '' }}>Yes</option>
                        </select>
                        <p class="mt-2 text-sm text-gray-500">
                            <svg class="w-4 h-4 inline mr-1 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Frozen products incur additional shipping charges: ¥670 (0-10kg) or ¥870 (10-25kg)
                        </p>
                        @error('is_frozen')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-center space-x-4 pt-6 border-t border-gray-100">
                        <button type="submit" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white font-semibold rounded-lg shadow-lg transition">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                            </svg>
                            Update Product
                        </button>
                        <a href="{{ route('admin.products.index') }}" class="inline-flex items-center px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-lg transition">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function previewMainImage(event) {
            const preview = document.getElementById('mainPreview');
            const previewContainer = document.getElementById('mainImagePreview');
            const file = event.target.files[0];

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    previewContainer.classList.remove('hidden');
                }
                reader.readAsDataURL(file);
            }
        }

        function previewGalleryImages(event, maxAllowed) {
            const previewContainer = document.getElementById('galleryPreview');
            const previewGrid = document.getElementById('galleryPreviewGrid');
            const files = event.target.files;

            // Clear previous previews
            previewGrid.innerHTML = '';

            if (files.length > 0) {
                previewContainer.classList.remove('hidden');

                // Limit to max allowed
                const maxFiles = Math.min(files.length, maxAllowed);

                for (let i = 0; i < maxFiles; i++) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const imgContainer = document.createElement('div');
                        imgContainer.className = 'relative';
                        imgContainer.innerHTML = `
                            <img src="${e.target.result}" class="h-24 w-full object-cover rounded-lg shadow-md" alt="Gallery Preview ${i + 1}">
                            <span class="absolute top-1 left-1 bg-green-500 text-white text-xs px-2 py-1 rounded">New</span>
                        `;
                        previewGrid.appendChild(imgContainer);
                    }
                    reader.readAsDataURL(files[i]);
                }

                if (files.length > maxAllowed) {
                    const notice = document.createElement('div');
                    notice.className = 'col-span-4 text-center text-sm text-orange-600 mt-2';
                    notice.textContent = `Only first ${maxAllowed} images will be uploaded (${files.length} selected)`;
                    previewGrid.appendChild(notice);
                }
            } else {
                previewContainer.classList.add('hidden');
            }
        }
    </script>
</x-admin-layout>
