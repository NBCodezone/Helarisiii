<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $category->category_name }} - {{ config('app.name', 'Laravel') }}</title>

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500;600&family=Rubik:wght@500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="{{ asset('lib/animate/animate.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="{{ asset('Electro-Bootstrap-1.0.0/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="{{ asset('Electro-Bootstrap-1.0.0/css/style.css') }}" rel="stylesheet">

    <!-- Custom Stylesheet -->
    <link href="{{ asset('css/custom.css?v=1.2') }}" rel="stylesheet">
</head>
<body>
    @include('partials.topbar')
    @include('partials.navbar')

    <!-- Page Header -->
    <div class="container-fluid page-header py-5 mb-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container text-center py-5">
            <h1 class="display-3 text-white mb-4 animated slideInDown">{{ $category->category_name }}</h1>
            <nav aria-label="breadcrumb animated slideInDown">
                <ol class="breadcrumb justify-content-center mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('shop') }}">Shop</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $category->category_name }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Category Products -->
    <div class="container-fluid py-5" style="background: linear-gradient(to bottom, #fff 0%, #f0fdf4 100%);">
        <div class="container py-5">
            <div class="row mb-4">
                <div class="col-12 text-center">
                    <h3 class="display-5 mb-3" style="font-family: 'Playfair Display', serif; color: #2c3e50;">
                        {{ $category->category_name }}
                    </h3>
                    <p class="text-muted">{{ $products->total() }} product(s) in this category</p>
                </div>
            </div>

            @if($products->count() > 0)
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
                                             style="object-fit: cover; transition: transform 0.3s ease;"
                                             onerror="this.src='{{ asset('Electro-Bootstrap-1.0.0/img/product-3.png') }}'">
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

                                    <!-- New Badge -->
                                    @if($product->created_at && $product->created_at->diffInDays(now()) < 30)
                                    <div class="position-absolute top-0 end-0 m-3">
                                        <span class="badge bg-warning px-3 py-2" style="border-radius: 20px; font-size: 0.75rem;">
                                            <i class="fas fa-star me-1"></i> New
                                        </span>
                                    </div>
                                    @endif

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

                <!-- Pagination -->
                @if($products->hasPages())
                <div class="row mt-5">
                    <div class="col-12">
                        <div class="pagination d-flex justify-content-center">
                            {{ $products->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
                @endif
            @else
                <div class="row">
                    <div class="col-12">
                        <div class="alert alert-info text-center">
                            <h4>No products in this category</h4>
                            <p>Browse our <a href="{{ route('shop') }}">shop</a> for more products.</p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Other Categories -->
            <div class="row mt-5">
                <div class="col-12">
                    <h4 class="mb-4">Browse Other Categories</h4>
                    <div class="d-flex flex-wrap gap-2">
                        @foreach($categories as $cat)
                            @if($cat->id != $category->id)
                                <a href="{{ route('category', $cat->id) }}" 
                                   class="btn btn-outline-primary rounded-pill">
                                    {{ $cat->category_name }} ({{ $cat->products_count }})
                                </a>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('partials.footer')

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('lib/wow/wow.min.js') }}"></script>
    <script src="{{ asset('lib/easing/easing.min.js') }}"></script>
    <script src="{{ asset('lib/waypoints/waypoints.min.js') }}"></script>
    <script src="{{ asset('lib/owlcarousel/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('lib/counterup/counterup.min.js') }}"></script>

    <!-- Template Javascript -->
    <script src="{{ asset('Electro-Bootstrap-1.0.0/js/main.js') }}"></script>

    <!-- Initialize WOW.js -->
    <script>
        new WOW().init();
    </script>

    <!-- Product Card Styles and Scripts -->
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
            box-shadow: 0 5px 15px rgba(22, 163, 74, 0.4);
        }

        .wishlist-btn.in-wishlist i {
            color: var(--bs-primary) !important;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .product-item h5 {
                font-size: 0.9rem;
                min-height: auto;
            }
        }

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
                    if (button && icon) {
                        if (data.in_wishlist) {
                            button.classList.add('in-wishlist');
                            icon.style.color = 'var(--bs-primary)';
                        } else {
                            button.classList.remove('in-wishlist');
                            icon.style.color = '';
                        }
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
</body>
</html>
