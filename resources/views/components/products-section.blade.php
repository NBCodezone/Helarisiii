@props(['products'])

<!-- Products Section Start -->
<div class="container-fluid py-5" style="background: linear-gradient(to bottom, #fff 0%, #f0fdf4 100%);">
    <div class="container">
        <!-- Section Header -->
        <div class="text-center mb-5 wow fadeInUp" data-wow-delay="0.1s">
            <div class="d-inline-block border rounded text-primary px-4 mb-3" style="border-color: var(--bs-primary) !important; color: var(--bs-primary) !important;">
                Our Products
            </div>
            <h1 class="display-5 mb-3" style="font-family: 'Playfair Display', serif; color: #2c3e50;">
                Featured <span style="color: var(--bs-primary);">Product</span> Collection
            </h1>
            <p class="text-muted">Discover our exquisite collection of items</p>
        </div>

        @if($products->count() > 0)
            <!-- Products Grid -->
            <div class="row g-4">
                @foreach($products as $product)
                    <div class="col-lg-3 col-md-4 col-sm-6 wow fadeInUp" data-wow-delay="{{ 0.1 * $loop->iteration }}s">
                        <div class="product-item h-100 shadow-sm" style="border-radius: 15px; overflow: hidden; transition: all 0.3s ease; border: 1px solid #f0f0f0;">
                            <!-- Product Image -->
                            <div class="position-relative overflow-hidden" style="height: 250px; background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);">
                                @if($product->image)
                                    <img src="{{ asset($product->image) }}"
                                         alt="{{ $product->product_name }}"
                                         class="img-fluid w-100 h-100"
                                         style="object-fit: cover; transition: transform 0.3s ease;">
                                @else
                                    <div class="w-100 h-100 d-flex align-items-center justify-content-center"
                                         style="background: linear-gradient(135deg, #16a34a 0%, #22c55e 100%);">
                                        <span class="text-white" style="font-size: 5rem; font-weight: bold; font-family: 'Playfair Display', serif;">
                                            {{ substr($product->product_name, 0, 1) }}
                                        </span>
                                    </div>
                                @endif

                                <!-- Badges -->
                                <div class="position-absolute top-0 start-0 m-3">
                                    @if($product->stock > 0)
                                        <span class="badge bg-success px-3 py-2" style="border-radius: 20px; font-size: 0.75rem;">
                                            <i class="fas fa-check me-1"></i> In Stock
                                        </span>
                                    @else
                                        <span class="badge bg-danger px-3 py-2" style="border-radius: 20px; font-size: 0.75rem;">
                                            <i class="fas fa-times me-1"></i> Out of Stock
                                        </span>
                                    @endif
                                </div>

                                <!-- Category Badge -->
                                <div class="position-absolute top-0 end-0 m-3">
                                    <span class="badge px-3 py-2" style="background: rgba(22, 163, 74, 0.9); border-radius: 20px; font-size: 0.75rem;">
                                        {{ $product->category_name }}
                                    </span>
                                </div>

                                <!-- Quick View Overlay -->
                                <div class="position-absolute w-100 h-100 top-0 start-0 d-flex align-items-center justify-content-center product-overlay"
                                     style="background: rgba(0,0,0,0.5); opacity: 0; transition: opacity 0.3s ease;">
                                    <a href="{{ route('product.show', $product->id) }}" class="btn btn-light rounded-circle me-2" style="width: 45px; height: 45px;">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @auth
                                        <button onclick="toggleWishlist({{ $product->id }})"
                                                class="btn btn-light rounded-circle wishlist-btn"
                                                data-product-id="{{ $product->id }}"
                                                style="width: 45px; height: 45px;">
                                            <i class="fas fa-heart" id="wishlist-icon-{{ $product->id }}"></i>
                                        </button>
                                    @else
                                        <a href="{{ route('login') }}" class="btn btn-light rounded-circle" style="width: 45px; height: 45px;">
                                            <i class="fas fa-heart"></i>
                                        </a>
                                    @endauth
                                </div>
                            </div>

                            <!-- Product Info -->
                            <div class="p-4" style="background: white;">
                                <!-- Product Name -->
                                <h5 class="mb-2" style="font-family: 'Rubik', sans-serif; font-size: 1rem; color: #2c3e50; min-height: 48px;">
                                    {{ Str::limit($product->product_name, 45) }}
                                </h5>

                                <!-- Product Meta -->
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div class="text-muted" style="font-size: 0.85rem;">
                                        <i class="fas fa-weight me-1" style="color: #ff6b35;"></i>
                                        <span>{{ $product->net_weight }}kg</span>
                                    </div>
                                    <div class="text-muted" style="font-size: 0.85rem;">
                                        <i class="fas fa-cubes me-1" style="color: var(--bs-primary);"></i>
                                        <span>{{ $product->stock }} left</span>
                                    </div>
                                </div>

                                <!-- Price and Button -->
                                <div class="d-flex justify-content-between align-items-center">
                                    <h4 class="mb-0" style="color: var(--bs-primary); font-family: 'Playfair Display', serif; font-weight: 700;">
                                        ¥{{ number_format($product->price, 0) }}
                                    </h4>
                                    @if($product->stock > 0)
                                        <button onclick="addToCart({{ $product->id }})"
                                                class="btn btn-sm px-3"
                                                style="background: linear-gradient(135deg, #16a34a 0%, #22c55e 100%);
                                                       color: white;
                                                       border: none;
                                                       border-radius: 20px;
                                                       font-weight: 600;
                                                       transition: all 0.3s ease;">
                                            <i class="fas fa-shopping-cart me-1"></i> Add
                                        </button>
                                    @else
                                        <button disabled
                                                class="btn btn-sm px-3"
                                                style="background: #ccc;
                                                       color: #666;
                                                       border: none;
                                                       border-radius: 20px;
                                                       font-weight: 600;
                                                       cursor: not-allowed;">
                                            Out of Stock
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- View All Button -->
            <div class="text-center mt-5 wow fadeInUp" data-wow-delay="0.1s">
                <a href="{{ route('shop') }}"
                   class="btn btn-lg px-5 py-3"
                   style="background: white;
                          color: #16a34a;
                          border: 2px solid #16a34a;
                          border-radius: 30px;
                          font-weight: 700;
                          box-shadow: 0 4px 15px rgba(22, 163, 74, 0.2);
                          transition: all 0.3s ease;"
                   onmouseover="this.style.background='#16a34a'; this.style.color='white';"
                   onmouseout="this.style.background='white'; this.style.color='#16a34a';">
                    <i class="fas fa-th me-2"></i> View All Products
                </a>
            </div>
        @else
            <!-- No Products Message -->
            <div class="text-center py-5">
                <div class="mb-4">
                    <i class="fas fa-gem" style="font-size: 4rem; color: #ddd;"></i>
                </div>
                <h4 class="text-muted mb-3">No Products Available</h4>
                <p class="text-muted">Check back soon for our amazing jewelry collection!</p>
            </div>
        @endif
    </div>
</div>

<!-- Custom Styles -->
<style>
    .product-item:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.15) !important;
    }

    .product-item:hover img {
        transform: scale(1.1);
    }

    .product-item:hover .product-overlay {
        opacity: 1 !important;
    }

    .product-item .btn:hover {
        transform: scale(1.05);
        box-shadow: 0 5px 15px rgba(255, 107, 53, 0.4);
    }

    .wishlist-btn.in-wishlist i {
        color: #ff6b35 !important;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .product-item h5 {
            font-size: 0.9rem;
            min-height: auto;
        }
    }
</style>

<script>
    // Wishlist functionality - auth only
    @auth
    document.addEventListener('DOMContentLoaded', function() {
        const wishlistButtons = document.querySelectorAll('.wishlist-btn');
        wishlistButtons.forEach(button => {
            const productId = button.dataset.productId;
            checkWishlistStatus(productId);
        });
    });

    function checkWishlistStatus(productId) {
        fetch(`/wishlist/check/${productId}`)
            .then(response => response.json())
            .then(data => {
                const button = document.querySelector(`.wishlist-btn[data-product-id="${productId}"]`);
                const icon = document.getElementById(`wishlist-icon-${productId}`);
                if (data.in_wishlist) {
                    button.classList.add('in-wishlist');
                    icon.style.color = 'var(--bs-primary)';
                } else {
                    button.classList.remove('in-wishlist');
                    icon.style.color = '';
                }
            })
            .catch(error => console.error('Error checking wishlist:', error));
    }

    function toggleWishlist(productId) {
        fetch(`/wishlist/toggle/${productId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const button = document.querySelector(`.wishlist-btn[data-product-id="${productId}"]`);
                const icon = document.getElementById(`wishlist-icon-${productId}`);

                if (data.action === 'added') {
                    button.classList.add('in-wishlist');
                    icon.style.color = 'var(--bs-primary)';
                    showNotification('Added to wishlist!', 'success');
                } else {
                    button.classList.remove('in-wishlist');
                    icon.style.color = '';
                    showNotification('Removed from wishlist', 'info');
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('An error occurred', 'error');
        });
    }
    @endauth

    // Cart functionality - available to EVERYONE (guests + users)
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
                showNotification('Product added to cart successfully!', 'success');

                // Dispatch custom event to update cart summary in navbar
                document.dispatchEvent(new CustomEvent('cartUpdated', {
                    detail: { count: data.cart_count }
                }));
            } else {
                showNotification(data.message || 'Failed to add product to cart', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('An error occurred', 'error');
        });
    }

    function showNotification(message, type) {
        // Create notification element
        const notification = document.createElement('div');
        notification.className = `alert alert-${type === 'success' ? 'success' : type === 'error' ? 'danger' : 'info'} position-fixed`;
        notification.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 250px; animation: slideIn 0.3s ease;';
        notification.innerHTML = `
            <div class="d-flex align-items-center">
                <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : 'info-circle'} me-2"></i>
                <span>${message}</span>
            </div>
        `;

        document.body.appendChild(notification);

        setTimeout(() => {
            notification.style.animation = 'slideOut 0.3s ease';
            setTimeout(() => notification.remove(), 300);
        }, 3000);
    }
</script>

<style>
    @keyframes slideIn {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }

    @keyframes slideOut {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(100%);
            opacity: 0;
        }
    }
</style>

<!-- Products Section End -->
