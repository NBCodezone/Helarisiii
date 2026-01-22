{{-- resources/views/partials/bestseller.blade.php --}}
<!-- Bestseller Products Start -->
<div class="container-fluid py-5">
    <div class="container py-5">
        <div class="mx-auto text-center mb-5" style="max-width: 700px;">
            <h4 class="text-primary mb-4 border-bottom border-primary border-2 d-inline-block p-2 title-border-radius wow fadeInUp"
                data-wow-delay="0.1s">Bestseller Products</h4>
            <p class="mb-0 wow fadeInUp" data-wow-delay="0.2s">
                Our top 10 most popular products based on customer purchases. These items are loved by our customers!
            </p>
        </div>

        @if(isset($bestsellerProducts) && count($bestsellerProducts) > 0)
        <div class="row g-4 product">
            @foreach($bestsellerProducts as $product)
            <div class="col-md-6 col-lg-4 col-xl-3 wow fadeInUp" data-wow-delay="{{ 0.1 + ($loop->index * 0.1) }}s">
                <div class="product-item rounded">
                    <div class="product-item-inner border rounded">
                        <div class="product-item-inner-item">
                            <img src="{{ asset($product->image) }}"
                                 class="img-fluid w-100 rounded-top"
                                 alt="{{ $product->product_name }}"
                                 onerror="this.src='{{ asset('Electro-Bootstrap-1.0.0/img/product-3.png') }}'">
                            <div class="product-bestseller">
                                <i class="fas fa-fire me-1"></i> #{{ $loop->iteration }} Best
                            </div>
                            @if($product->has_discount)
                            <div class="product-discount">-{{ $product->discount_percentage }}%</div>
                            @endif
                            <div class="product-details">
                                <a href="{{ route('product.show', $product->id) }}">
                                    <i class="fa fa-eye fa-1x"></i>
                                </a>
                            </div>
                        </div>
                        <div class="text-center rounded-bottom p-4">
                            <a href="{{ route('category', $product->category->id ?? $product->category_id) }}" class="d-block mb-2">
                                {{ $product->category->category_name ?? $product->category_name }}
                            </a>
                            <a href="{{ route('product.show', $product->id) }}" class="d-block h4">
                                {{ Str::limit($product->product_name, 30) }}
                            </a>
                            <div class="mb-2">
                                @if($product->has_discount)
                                <del class="text-muted me-2">¥{{ number_format($product->price, 0) }}</del>
                                <span class="text-primary fs-5">¥{{ number_format($product->discounted_price, 0) }}</span>
                                @else
                                <span class="text-primary fs-5">¥{{ number_format($product->price, 0) }}</span>
                                @endif
                            </div>
                            <p class="text-muted mb-0">
                                <small><i class="fas fa-shopping-bag me-1"></i> {{ number_format($product->total_sold) }} sold</small>
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
        @else
        <div class="row">
            <div class="col-12">
                <div class="alert alert-info text-center py-5">
                    <i class="fas fa-chart-line fa-3x mb-3 text-primary"></i>
                    <h4>No Bestseller Products Yet</h4>
                    <p class="mb-3">We're still collecting data on our most popular products. Check back soon!</p>
                    <a href="{{ route('shop') }}" class="btn btn-primary rounded-pill py-2 px-4">
                        <i class="fas fa-store me-2"></i> Browse All Products
                    </a>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
<!-- Bestseller Products End -->

<style>
    .product-bestseller {
        position: absolute;
        top: 10px;
        left: 10px;
        background: linear-gradient(135deg, #ff6b35, #f7931e);
        color: white;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        z-index: 2;
        box-shadow: 0 2px 8px rgba(255, 107, 53, 0.4);
    }

    .product-discount {
        position: absolute;
        top: 10px;
        right: 10px;
        background: #dc3545;
        color: white;
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        z-index: 2;
    }
</style>
