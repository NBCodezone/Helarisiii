<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Products - Ecommerce Store</title>

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500;600;700&family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" />

    <style>
        :root {
            --primary-color: #16A34A;
            --secondary-color: #065F46;
            --dark-color: #45595B;
            --light-color: #F4F6F8;
        }

        body {
            font-family: 'Open Sans', sans-serif;
        }

        .navbar {
            background: linear-gradient(90deg, var(--primary-color) 0%, #15803D 100%);
            padding: 20px 0;
        }

        .navbar-brand {
            font-family: 'Roboto', sans-serif;
            font-weight: 700;
            font-size: 28px;
            color: white !important;
        }

        .hero-section {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            padding: 60px 0;
            color: white;
        }

        .product-card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s, box-shadow 0.3s;
            margin-bottom: 30px;
            overflow: hidden;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        }

        .product-card .card-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, #15803D 100%);
            color: white;
            font-weight: 600;
            padding: 15px;
        }

        .product-card .card-body {
            padding: 20px;
        }

        .badge-category {
            background-color: var(--secondary-color);
            color: white;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
        }

        .badge-stock {
            background-color: var(--primary-color);
            color: var(--dark-color);
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .badge-out {
            background-color: #dc3545;
            color: white;
        }

        .product-info {
            display: flex;
            justify-content: space-between;
            margin-top: 10px;
            padding-top: 10px;
            border-top: 1px solid #eee;
        }

        footer {
            background-color: var(--dark-color);
            color: white;
            padding: 30px 0;
            margin-top: 50px;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="/">
                <i class="fas fa-shopping-bag me-2"></i>Ecommerce Store
            </a>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="hero-section">
        <div class="container text-center">
            <h1 class="display-4 fw-bold mb-3">Our Products</h1>
            <p class="lead">Browse our amazing collection of products</p>
        </div>
    </div>

    <!-- Products Section -->
    <div class="container my-5">
        @if($products->count() > 0)
            <div class="row">
                @foreach($products as $product)
                    <div class="col-md-4">
                        <div class="card product-card">
                            <div class="card-header">
                                <h5 class="mb-0">{{ $product->product_name }}</h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <span class="badge-category">
                                        <i class="fas fa-tag me-1"></i>{{ $product->category_name }}
                                    </span>
                                </div>

                                <p class="text-muted">
                                    {{ $product->description ?? 'No description available.' }}
                                </p>

                                <div class="product-info">
                                    <div>
                                        <small class="text-muted d-block">Stock</small>
                                        @if($product->stock > 0)
                                            <span class="badge-stock">{{ $product->stock }} available</span>
                                        @else
                                            <span class="badge-stock badge-out">Out of Stock</span>
                                        @endif
                                    </div>
                                    <div>
                                        <small class="text-muted d-block">Weight</small>
                                        <strong>{{ $product->net_weight }} kg</strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $products->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-box-open fa-5x text-muted mb-4"></i>
                <h3 class="text-muted">No Products Available</h3>
                <p class="text-muted">Check back later for new products!</p>
            </div>
        @endif
    </div>

    <!-- Footer -->
    <footer>
        <div class="container text-center">
            <p class="mb-0">&copy; 2025 Ecommerce Store. All rights reserved.</p>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
