<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-gradient-to-br from-pink-500 to-pink-600 rounded-lg flex items-center justify-center shadow-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-800" style="font-family: 'Playfair Display', serif;">My Wishlist</h2>
                    <p class="text-sm text-gray-500">{{ $wishlistCount }} {{ $wishlistCount == 1 ? 'item' : 'items' }} in your wishlist</p>
                </div>
            </div>
        </div>
    </x-slot>

    @if($wishlistItems->isEmpty())
        <!-- Empty Wishlist State -->
        <div class="flex flex-col items-center justify-center py-16">
            <div class="w-32 h-32 bg-gradient-to-br from-pink-100 to-pink-200 rounded-full flex items-center justify-center mb-6">
                <svg class="w-16 h-16 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                </svg>
            </div>
            <h3 class="text-2xl font-bold text-gray-800 mb-2" style="font-family: 'Playfair Display', serif;">Your Wishlist is Empty</h3>
            <p class="text-gray-600 mb-6">Start adding items to your wishlist to save them for later!</p>
            <a href="{{ route('home') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-pink-500 to-pink-600 hover:from-pink-600 hover:to-pink-700 text-white font-semibold rounded-lg shadow-lg transition">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
                Browse Products
            </a>
        </div>
    @else
        <!-- Wishlist Items Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($wishlistItems as $item)
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300 group" data-wishlist-item="{{ $item->product_id }}" id="wishlist-item-{{ $item->product_id }}">
                    <!-- Product Image -->
                    <div class="relative overflow-hidden">
                        <img src="{{ asset($item->product->image) }}"
                             alt="{{ $item->product->product_name }}"
                             onerror="this.src='{{ asset('Electro-Bootstrap-1.0.0/img/product-3.png') }}'"
                             class="w-full h-64 object-cover group-hover:scale-110 transition-transform duration-500">
                        <div class="absolute top-4 right-4">
                            <button type="button"
                                    onclick="confirmRemove({{ $item->product_id }})"
                                    class="w-10 h-10 bg-white rounded-full flex items-center justify-center shadow-lg hover:bg-red-50 transition-colors">
                                <svg class="w-5 h-5 text-red-500" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M6 18L18 6M6 6l12 12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
                                </svg>
                            </button>
                        </div>
                        @if($item->product->stock <= 0)
                            <div class="absolute top-4 left-4">
                                <span class="px-3 py-1 bg-red-500 text-white text-xs font-semibold rounded-full">
                                    Out of Stock
                                </span>
                            </div>
                        @endif
                    </div>

                    <!-- Product Info -->
                    <div class="p-6">
                        <div class="mb-2">
                            <span class="text-xs text-gray-500">{{ $item->product->category->category_name ?? 'Uncategorized' }}</span>
                        </div>
                        <h3 class="text-lg font-bold text-gray-800 mb-2" style="font-family: 'Playfair Display', serif;">
                            {{ $item->product->product_name }}
                        </h3>
                        <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                            {{ $item->product->description }}
                        </p>

                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <span class="text-2xl font-bold text-orange-600" style="font-family: 'Playfair Display', serif;">
                                    ¥{{ number_format($item->product->price, 0) }}
                                </span>
                            </div>
                            <div class="text-sm text-gray-500">
                                <span class="font-semibold">Weight:</span> {{ $item->product->net_weight }}g
                            </div>
                        </div>

                        <div class="flex space-x-2">
                            @if($item->product->stock > 0)
                                <button onclick="addToCart({{ $item->product_id }})"
                                        class="flex-1 px-4 py-2 bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white font-semibold rounded-lg shadow-lg transition">
                                    Add to Cart
                                </button>
                            @else
                                <button disabled
                                        class="flex-1 px-4 py-2 bg-gray-300 text-gray-500 font-semibold rounded-lg cursor-not-allowed">
                                    Out of Stock
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <!-- Toast Notification -->
    <div id="toast" class="fixed bottom-4 right-4 bg-white rounded-lg shadow-lg px-6 py-4 transform translate-y-full transition-transform duration-300 z-50 hidden">
        <div class="flex items-center space-x-3">
            <div class="flex-shrink-0">
                <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            <div>
                <p class="text-sm font-semibold text-gray-800" id="toast-message">Success!</p>
            </div>
        </div>
    </div>

    <script>
        function confirmRemove(productId) {
            if (confirm('Are you sure you want to remove this item from your wishlist?')) {
                removeFromWishlist(productId);
            }
        }

        function showToast(message, type = 'success') {
            const toast = document.getElementById('toast');
            const toastMessage = document.getElementById('toast-message');
            toastMessage.textContent = message;

            toast.classList.remove('hidden');
            setTimeout(() => {
                toast.classList.remove('translate-y-full');
            }, 10);

            setTimeout(() => {
                toast.classList.add('translate-y-full');
                setTimeout(() => {
                    toast.classList.add('hidden');
                }, 300);
            }, 3000);
        }

        function removeFromWishlist(productId) {
            console.log('Removing product ID:', productId);

            fetch(`/wishlist/remove/${productId}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => {
                console.log('Response status:', response.status);
                return response.json();
            })
            .then(data => {
                console.log('Response data:', data);
                if (data.success) {
                    showToast(data.message, 'success');
                    const item = document.querySelector(`[data-wishlist-item="${productId}"]`);
                    console.log('Item to remove:', item);
                    if (item) {
                        // Add transition CSS
                        item.style.transition = 'all 0.3s ease';
                        item.style.opacity = '0';
                        item.style.transform = 'scale(0.8)';

                        setTimeout(() => {
                            item.remove();
                            console.log('Item removed from DOM');

                            // Check remaining items
                            const remainingItems = document.querySelectorAll('[data-wishlist-item]');
                            console.log('Remaining items:', remainingItems.length);

                            // Reload page if no more items
                            if (remainingItems.length === 0) {
                                console.log('No more items, reloading...');
                                location.reload();
                            }
                        }, 300);
                    } else {
                        console.error('Item not found in DOM');
                    }
                } else {
                    console.error('Server returned success=false');
                    showToast(data.message || 'Failed to remove item', 'error');
                }
            })
            .catch(error => {
                console.error('Error removing from wishlist:', error);
                showToast('An error occurred', 'error');
            });
        }

        function addToCart(productId) {
            fetch(`/cart/add/${productId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ quantity: 1 })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showToast('Product added to cart successfully!', 'success');
                    
                    // Dispatch custom event to update cart summary in navbar
                    document.dispatchEvent(new CustomEvent('cartUpdated', { 
                        detail: { count: data.cart_count } 
                    }));
                } else {
                    showToast(data.message || 'Failed to add to cart', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('An error occurred', 'error');
            });
        }
    </script>

    <style>
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
</x-admin-layout>
