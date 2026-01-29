<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Categories - {{ config('app.name', 'Laravel') }}</title>

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

    <style>
        .category-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: all 0.3s ease;
            height: 100%;
        }
        .category-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
        }
        .category-image {
            height: 250px;
            overflow: hidden;
            background: linear-gradient(135deg, #f5f7fa 0%, #e9ecef 100%);
            position: relative;
        }
        .category-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }
        .category-card:hover .category-image img {
            transform: scale(1.1);
        }
        .category-image-placeholder {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100%;
        }
        .category-image-placeholder i {
            font-size: 4rem;
            color: #adb5bd;
        }
        .category-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.5) 0%, transparent 100%);
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        .category-card:hover .category-overlay {
            opacity: 1;
        }
        .category-info {
            padding: 2rem;
        }
        .category-name {
            font-family: 'Playfair Display', serif;
            font-size: 1.25rem;
            font-weight: 700;
            color: #212529;
            margin-bottom: 0.5rem;
            text-align: center;
        }
        .category-card:hover .category-name {
            color: #28a745;
        }
        .category-count {
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.875rem;
            color: #6c757d;
        }
        .category-button {
            background: linear-gradient(to right, #28a745, #34ce57);
            color: white;
            font-weight: 600;
            text-align: center;
            padding: 0.75rem;
            margin: 0 1rem 1rem 1rem;
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        .category-card:hover .category-button {
            background: linear-gradient(to right, #34ce57, #52d273);
        }
        .page-header {
            text-align: center;
            margin-bottom: 3rem;
            margin-top: 2rem;
        }
        .page-title {
            font-family: 'Playfair Display', serif;
            font-size: 2.5rem;
            font-weight: 700;
            color: #212529;
            margin-bottom: 1rem;
        }
        .page-subtitle {
            font-size: 1.125rem;
            color: #6c757d;
        }
        .feature-box {
            text-align: center;
            padding: 2rem 1rem;
        }
        .feature-icon {
            width: 64px;
            height: 64px;
            margin: 0 auto 1rem;
            background: linear-gradient(135deg, #fff3e0 0%, #ffe0b2 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .feature-icon.blue {
            background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
        }
        .feature-icon.green {
            background: linear-gradient(135deg, #e8f5e9 0%, #c8e6c9 100%);
        }
        .feature-icon i {
            font-size: 2rem;
        }
        .feature-title {
            font-size: 1.125rem;
            font-weight: 700;
            color: #212529;
            margin-bottom: 0.5rem;
        }
        .feature-text {
            color: #6c757d;
        }
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
        }
        .empty-icon {
            width: 128px;
            height: 128px;
            margin: 0 auto 1.5rem;
            background: linear-gradient(135deg, #f5f7fa 0%, #e9ecef 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .empty-icon i {
            font-size: 4rem;
            color: #adb5bd;
        }

        /* Fix pagination display */
        .pagination {
            display: flex !important;
            flex-wrap: wrap;
            padding-left: 0;
            list-style: none;
            justify-content: center;
        }
        .pagination .page-item {
            margin: 0 2px;
        }
        .pagination .page-link {
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 40px;
            height: 40px;
            padding: 0.5rem 0.75rem;
            color: #212529;
            background-color: #fff;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            text-decoration: none;
        }
        .pagination .page-item.active .page-link {
            background-color: #28a745;
            border-color: #28a745;
            color: #fff;
        }
        .pagination .page-link:hover {
            background-color: #e9ecef;
            border-color: #dee2e6;
            color: #212529;
        }
        .pagination .page-item.disabled .page-link {
            color: #6c757d;
            background-color: #fff;
            border-color: #dee2e6;
        }
        /* Fix pagination nav wrapper */
        nav[aria-label="Pagination Navigation"] {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 1rem;
        }
        nav[aria-label="Pagination Navigation"] > div {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.5rem;
        }
        @media (min-width: 640px) {
            nav[aria-label="Pagination Navigation"] > div.hidden {
                display: flex !important;
                flex-direction: row;
                justify-content: space-between;
                width: 100%;
            }
        }
    </style>
</head>
<body>
    @include('partials.topbar')

    @php
        $categories_for_navbar = \App\Models\Category::withCount('products')->get();
    @endphp
    @include('partials.navbar', ['categories' => $categories_for_navbar])

    <div class="container-fluid py-5">
        <div class="container">
            <!-- Page Header -->
            <div class="page-header">
                <h1 class="page-title">Browse Categories</h1>
                <p class="page-subtitle">Explore our wide range of product categories</p>
            </div>

            <!-- Categories Grid -->
            @if($categories->count() > 0)
                <div class="row g-4 mb-5">
                    @foreach($categories as $category)
                        <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                            <a href="{{ route('category', $category->id) }}" class="text-decoration-none">
                                <div class="category-card">
                                    <!-- Category Image -->
                                    <div class="category-image">
                                        @if($category->image)
                                            <img src="{{ asset($category->image) }}"
                                                 alt="{{ $category->category_name }}">
                                        @else
                                            <div class="category-image-placeholder">
                                                <i class="fas fa-tag"></i>
                                            </div>
                                        @endif
                                        <div class="category-overlay"></div>
                                    </div>

                                    <!-- Category Info -->
                                    <div class="category-info">
                                        <h3 class="category-name">{{ $category->category_name }}</h3>
                                        <div class="category-count">
                                            <i class="fas fa-box me-2"></i>
                                            <span>{{ $category->products_count }} {{ Str::plural('product', $category->products_count) }}</span>
                                        </div>
                                    </div>

                                    <!-- View Products Link -->
                                    <div class="category-button">
                                        View Products
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                @if($categories->hasPages())
                    <div class="d-flex justify-content-center mt-4">
                        {{ $categories->links('pagination::bootstrap-5') }}
                    </div>
                @endif
            @else
                <!-- Empty State -->
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fas fa-tag"></i>
                    </div>
                    <h3 class="mb-3">No Categories Available</h3>
                    <p class="text-muted mb-4">Check back soon for new product categories</p>
                    <a href="{{ route('home') }}" class="btn btn-primary btn-lg">
                        <i class="fas fa-home me-2"></i>Return to Home
                    </a>
                </div>
            @endif

            <!-- Category Features -->
            <!-- <div class="row g-4 mt-5">
                <div class="col-md-4">
                    <div class="feature-box">
                        <div class="feature-icon">
                            <i class="fas fa-search text-warning"></i>
                        </div>
                        <h3 class="feature-title">Easy Navigation</h3>
                        <p class="feature-text">Browse products by category for a better shopping experience</p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="feature-box">
                        <div class="feature-icon blue">
                            <i class="fas fa-tag text-primary"></i>
                        </div>
                        <h3 class="feature-title">Wide Selection</h3>
                        <p class="feature-text">Diverse categories with thousands of products to choose from</p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="feature-box">
                        <div class="feature-icon green">
                            <i class="fas fa-star text-success"></i>
                        </div>
                        <h3 class="feature-title">Quality Products</h3>
                        <p class="feature-text">Carefully curated categories with premium quality items</p>
                    </div>
                </div>
            </div> -->
        </div>
    </div>

    @include('partials.footer')

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('lib/wow/wow.min.js') }}"></script>
    <script src="{{ asset('lib/easing/easing.min.js') }}"></script>
    <script src="{{ asset('lib/waypoints/waypoints.min.js') }}"></script>
    <script src="{{ asset('lib/counterup/counterup.min.js') }}"></script>
    <script src="{{ asset('lib/owlcarousel/owl.carousel.min.js') }}"></script>

    <!-- Template Javascript -->
    <script src="{{ asset('Electro-Bootstrap-1.0.0/js/main.js') }}"></script>
</body>
</html>
