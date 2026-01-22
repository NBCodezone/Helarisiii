<x-order-manager-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 bg-gradient-to-br from-orange-500 to-orange-500 rounded-lg flex items-center justify-center shadow-lg">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
            </div>
            <div>
                <h2 class="text-2xl font-bold text-gray-800" style="font-family: 'Playfair Display', serif;">Edit Delivery Charge</h2>
                <p class="text-sm text-gray-500">Update delivery pricing</p>
            </div>
        </div>
    </x-slot>

    <div class="max-w-3xl mx-auto">
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
            <div class="p-6 border-b border-gray-100">
                <h3 class="text-xl font-bold text-gray-800" style="font-family: 'Playfair Display', serif;">Delivery Charge Information</h3>
            </div>
            <form action="{{ route('order-manager.delivery-charges.update', $deliveryCharge->id) }}" method="POST" class="p-6">
                @csrf
                @method('PUT')

                <div class="mb-6">
                    <label for="region_id" class="block text-sm font-medium text-gray-700 mb-2">Select Region <span class="text-red-500">*</span></label>
                    <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent @error('region_id') border-red-500 @enderror"
                            id="region_id"
                            name="region_id"
                            required>
                        <option value="">-- Select Region --</option>
                        @foreach($regions as $region)
                            <option value="{{ $region->id }}"
                                    {{ old('region_id', $deliveryCharge->region_id) == $region->id ? 'selected' : '' }}>
                                {{ $region->region_name }}
                            </option>
                        @endforeach
                    </select>
                    @error('region_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-sm text-gray-500">Choose the main region for this ken</p>
                </div>

                <div class="mb-6">
                    <label for="ken_name" class="block text-sm font-medium text-gray-700 mb-2">Ken Name <span class="text-red-500">*</span></label>
                    <input type="text"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent @error('ken_name') border-red-500 @enderror"
                           id="ken_name"
                           name="ken_name"
                           value="{{ old('ken_name', $deliveryCharge->ken_name) }}"
                           placeholder="e.g., Shiga, Kyoto, Nara, Wakayama, Osaka"
                           required>
                    @error('ken_name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-sm text-gray-500">Enter the ken (prefecture) name</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="price_0_10kg" class="block text-sm font-medium text-gray-700 mb-2">Price for 0-10kg Box <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <span class="absolute left-3 top-2 text-gray-500">¥</span>
                            <input type="number"
                                   class="w-full pl-8 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent @error('price_0_10kg') border-red-500 @enderror"
                                   id="price_0_10kg"
                                   name="price_0_10kg"
                                   value="{{ old('price_0_10kg', $deliveryCharge->price_0_10kg) }}"
                                   step="0.01"
                                   min="0"
                                   placeholder="0.00"
                                   required>
                        </div>
                        @error('price_0_10kg')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-sm text-gray-500">Delivery price for packages 0-10kg</p>
                    </div>

                    <div>
                        <label for="price_10_24kg" class="block text-sm font-medium text-gray-700 mb-2">Price for 10-24kg Box <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <span class="absolute left-3 top-2 text-gray-500">¥</span>
                            <input type="number"
                                   class="w-full pl-8 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent @error('price_10_24kg') border-red-500 @enderror"
                                   id="price_10_24kg"
                                   name="price_10_24kg"
                                   value="{{ old('price_10_24kg', $deliveryCharge->price_10_24kg) }}"
                                   step="0.01"
                                   min="0"
                                   placeholder="0.00"
                                   required>
                        </div>
                        @error('price_10_24kg')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-sm text-gray-500">Delivery price for packages 10-24kg</p>
                    </div>
                </div>

                <div class="bg-blue-50 border border-blue-200 text-blue-800 px-4 py-3 rounded-lg mb-6">
                    <p class="text-sm"><strong>Note:</strong> The system will automatically select the appropriate box size based on the total weight of products in the order.</p>
                </div>

                <div class="flex gap-3">
                    <button type="submit" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-orange-600 to-orange-600 hover:from-orange-700 hover:to-orange-700 text-white font-semibold rounded-lg shadow-lg transition">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Update Delivery Charge
                    </button>
                    <a href="{{ route('order-manager.delivery-charges.index') }}" class="inline-flex items-center px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold rounded-lg transition">
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
