<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Search Results - {{ config('app.name', 'Laravel') }}</title>

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500;600&family=Rubik:wght@500;600;700&display=swap" rel="stylesheet">

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
    <link href="{{ asset('css/custom.css?v=1.1') }}" rel="stylesheet">
</head>
<body>
    @include('partials.topbar')
    @include('partials.navbar')

    <!-- Page Header -->
    <div class="container-fluid page-header py-5 mb-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container text-center py-5">
            <h1 class="display-3 text-white mb-4 animated slideInDown">Search Results</h1>
            <nav aria-label="breadcrumb animated slideInDown">
                <ol class="breadcrumb justify-content-center mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Search</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Search Results -->
    <div class="container-fluid py-5">
        <div class="container py-5">
            <div class="row mb-4">
                <div class="col-12">
                    <h3 class="mb-3">
                        @if($query)
                            Search results for "<strong>{{ $query }}</strong>"
                        @elseif($categoryId)
                            @php
                                $selectedCategory = $categories->firstWhere('id', $categoryId);
                            @endphp
                            @if($selectedCategory)
                                Category: <strong>{{ $selectedCategory->category_name }}</strong>
                            @endif
                        @else
                            All Products
                        @endif
                    </h3>
                    <p class="text-muted">Found {{ $products->total() }} product(s)</p>
                </div>
            </div>

            @if($products->count() > 0)
                <div class="row g-4">
                    @foreach($products as $product)
                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <div class="product-item rounded wow fadeInUp h-100" data-wow-delay="0.1s">
                                <div class="product-item-inner border rounded h-100">
                                    <div class="product-item-inner-item">
                                        <img src="{{ asset($product->image) }}"
                                             class="img-fluid w-100 rounded-top"
                                             alt="{{ $product->product_name }}"
                                             onerror="this.src='{{ asset('Electro-Bootstrap-1.0.0/img/product-3.png') }}'">
                                        @if($product->created_at && $product->created_at->diffInDays(now()) < 30)
                                        <div class="product-new">New</div>
                                        @endif
                                        <div class="product-details">
                                            <a href="{{ route('product.show', $product->id) }}">
                                                <i class="fa fa-eye fa-1x"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="text-center rounded-bottom p-4">
                                        <a href="{{ route('category', $product->category_id) }}" class="d-block mb-2">
                                            {{ $product->category->category_name ?? 'Uncategorized' }}
                                        </a>
                                        <a href="{{ route('product.show', $product->id) }}" class="d-block h4">
                                            {{ Str::limit($product->product_name, 40) }}
                                        </a>
                                        <span class="text-primary fs-5">¥{{ number_format($product->price, 0) }}</span>
                                        <p class="text-muted mt-2 mb-0">
                                            <small>Stock: {{ $product->stock }}</small>
                                        </p>
                                    </div>
                                </div>
                                <div class="product-item-add border border-top-0 rounded-bottom text-center p-4 pt-0">
                                    <form action="{{ route('cart.add', $product->id) }}" method="POST" class="add-to-cart-form">
                                        @csrf
                                        <input type="hidden" name="quantity" value="1">
                                        <button type="submit" class="btn btn-primary border-secondary rounded-pill py-2 px-4 mb-3">
                                            <i class="fas fa-shopping-cart me-2"></i> Add To Cart
                                        </button>
                                    </form>
                                    <div class="d-flex justify-content-center align-items-center">
                                        <form action="{{ route('wishlist.add', $product->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-link text-primary p-0">
                                                <span class="rounded-circle btn-sm-square border">
                                                    <i class="fas fa-heart"></i>
                                                </span>
                                            </button>
                                        </form>
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
                            {{ $products->links() }}
                        </div>
                    </div>
                </div>
                @endif
            @else
                <div class="row">
                    <div class="col-12">
                        <div class="alert alert-info text-center">
                            <h4>No products found</h4>
                            <p>Try adjusting your search terms or browse our <a href="{{ route('shop') }}">shop</a>.</p>
                        </div>
                    </div>
                </div>
            @endif
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

        // Add to cart with AJAX
        $(document).on('submit', '.add-to-cart-form', function(e) {
            e.preventDefault(); // Prevent default form submission

            const form = $(this);
            const url = form.attr('action');
            const formData = form.serialize();

            $.ajax({
                url: url,
                method: 'POST',
                data: formData,
                success: function(response) {
                    if (response.success) {
                        showNotification(response.message || 'Product added to cart successfully!', 'success');

                        // Dispatch custom event to update cart summary in navbar
                        document.dispatchEvent(new CustomEvent('cartUpdated', {
                            detail: { count: response.cart_count }
                        }));
                    } else {
                        showNotification(response.message || 'Failed to add product to cart', 'error');
                    }
                },
                error: function(xhr) {
                    console.error('Error:', xhr);
                    showNotification('An error occurred while adding to cart', 'error');
                }
            });
        });

        function showNotification(message, type) {
            // Create notification element
            const notification = document.createElement('div');
            notification.className = `alert alert-${type === 'success' ? 'success' : type === 'error' ? 'danger' : 'info'} position-fixed`;
            notification.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 250px; animation: slideIn 0.3s ease; box-shadow: 0 4px 12px rgba(0,0,0,0.15);';
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

    <!-- Notification Animations -->
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
</body>
</html>
