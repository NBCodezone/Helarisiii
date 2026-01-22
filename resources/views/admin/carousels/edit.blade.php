@extends('layouts.admin')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Edit Carousel Slide</h1>
        <a href="{{ route('admin.carousels.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2.5 rounded-lg shadow-md transition duration-200">Back to List</a>
    </div>

    <div class="bg-white rounded-xl shadow-md p-8">
        <form action="{{ route('admin.carousels.update', $carousel) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-6">
                <label for="title" class="block text-sm font-semibold text-gray-700 mb-2">Title <span class="text-red-500">*</span></label>
                <input type="text" class="w-full px-4 py-3 border @error('title') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent transition" id="title" name="title" value="{{ old('title', $carousel->title) }}" required>
                @error('title')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">Description <span class="text-red-500">*</span></label>
                <textarea class="w-full px-4 py-3 border @error('description') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent transition" id="description" name="description" rows="3" required>{{ old('description', $carousel->description) }}</textarea>
                @error('description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="subtitle" class="block text-sm font-semibold text-gray-700 mb-2">Subtitle</label>
                <input type="text" class="w-full px-4 py-3 border @error('subtitle') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent transition" id="subtitle" name="subtitle" value="{{ old('subtitle', $carousel->subtitle) }}" placeholder="e.g., Terms and Condition Apply">
                @error('subtitle')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="image" class="block text-sm font-semibold text-gray-700 mb-2">Image</label>
                @if($carousel->image)
                    <div class="mb-3">
                        <img src="{{ asset($carousel->image) }}" alt="{{ $carousel->title }}" class="max-w-sm rounded-lg shadow-md">
                    </div>
                @endif
                <input type="file" class="w-full px-4 py-3 border @error('image') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent transition" id="image" name="image" accept="image/*">
                <p class="text-gray-500 text-sm mt-1">Leave empty to keep current image. Recommended size: 1920x600px, Max: 2MB</p>
                @error('image')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="button_text" class="block text-sm font-semibold text-gray-700 mb-2">Button Text</label>
                    <input type="text" class="w-full px-4 py-3 border @error('button_text') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent transition" id="button_text" name="button_text" value="{{ old('button_text', $carousel->button_text) }}">
                    @error('button_text')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="button_link" class="block text-sm font-semibold text-gray-700 mb-2">Button Link</label>
                    <input type="text" class="w-full px-4 py-3 border @error('button_link') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent transition" id="button_link" name="button_link" value="{{ old('button_link', $carousel->button_link) }}">
                    @error('button_link')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mb-6">
                <label for="order" class="block text-sm font-semibold text-gray-700 mb-2">Display Order</label>
                <input type="number" class="w-full px-4 py-3 border @error('order') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent transition" id="order" name="order" value="{{ old('order', $carousel->order) }}" min="0">
                <p class="text-gray-500 text-sm mt-1">Lower numbers appear first</p>
                @error('order')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end space-x-4">
                <a href="{{ route('admin.carousels.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-lg transition duration-200">Cancel</a>
                <button type="submit" class="bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white px-8 py-3 rounded-lg shadow-md hover:shadow-lg transition duration-200">Update Carousel Slide</button>
            </div>
        </form>
    </div>
</div>
@endsection
