{{-- resources/views/partials/products-section.blade.php --}}
<!-- Our Products Start -->
<div class="container-fluid product py-5">
    <div class="container py-5">
        <div class="tab-class">
            <div class="row g-4">
                <div class="col-lg-4 text-start wow fadeInLeft" data-wow-delay="0.1s">
                    <h1>Our Products</h1>
                </div>
                <div class="col-lg-8 text-end wow fadeInRight" data-wow-delay="0.1s">
                    <ul class="nav nav-pills d-inline-flex text-center mb-5">
                        <li class="nav-item mb-4">
                            <a class="d-flex mx-2 py-2 bg-light rounded-pill active" data-bs-toggle="pill" href="#tab-1">
                                <span class="text-dark" style="width: 130px;">All Products</span>
                            </a>
                        </li>
                        <li class="nav-item mb-4">
                            <a class="d-flex py-2 mx-2 bg-light rounded-pill" data-bs-toggle="pill" href="#tab-2">
                                <span class="text-dark" style="width: 130px;">New Arrivals</span>
                            </a>
                        </li>
                        <li class="nav-item mb-4">
                            <a class="d-flex mx-2 py-2 bg-light rounded-pill" data-bs-toggle="pill" href="#tab-3">
                                <span class="text-dark" style="width: 130px;">Featured</span>
                            </a>
                        </li>
                        <li class="nav-item mb-4">
                            <a class="d-flex mx-2 py-2 bg-light rounded-pill" data-bs-toggle="pill" href="#tab-4">
                                <span class="text-dark" style="width: 130px;">Top Selling</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="tab-content">
                {{-- All Products Tab --}}
                <div id="tab-1" class="tab-pane fade show p-0 active">
                    <div class="row g-4">
                        @foreach($products ?? [] as $product)
                        <div class="col-md-6 col-lg-4 col-xl-3">
                            <div class="product-item rounded wow fadeInUp" data-wow-delay="0.1s">
                                <div class="product-item-inner border rounded">
                                    <div class="product-item-inner-item">
                                        <img src="{{ asset($product->image) }}" class="img-fluid w-100 rounded-top" alt="{{ $product->product_name }}">
                                        @if($product->is_new)
                                        <div class="product-new">New</div>
                                        @endif
                                        @if($product->on_sale)
                                        <div class="product-sale">Sale</div>
                                        @endif
                                        <div class="product-details">
                                            <a href="{{ route('product.show', $product->id) }}"><i class="fa fa-eye fa-1x"></i></a>
                                        </div>
                                    </div>
                                    <div class="text-center rounded-bottom p-4">
                                        <a href="{{ route('category', $product->category_id) }}" class="d-block mb-2">
                                            {{ $product->category->category_name ?? 'Uncategorized' }}
                                        </a>
                                        <a href="{{ route('product.show', $product->id) }}" class="d-block h4">
                                            {{ Str::limit($product->product_name, 30) }}
                                        </a>
                                        @if($product->regular_price > $product->sale_price)
                                        <del class="me-2 fs-5">¥{{ number_format($product->regular_price, 0) }}</del>
                                        @endif
                                        <span class="text-primary fs-5">¥{{ number_format($product->sale_price, 0) }}</span>
                                    </div>
                                </div>
                                <div class="product-item-add border border-top-0 rounded-bottom text-center p-4 pt-0">
                                    <form action="{{ route('cart.add', $product->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-primary border-secondary rounded-pill py-2 px-4 mb-3">
                                            <i class="fas fa-shopping-cart me-2"></i> Add To Cart
                                        </button>
                                    </form>
                                    <div class="d-flex justify-content-center align-items-center gap-2">
                                        <a href="{{ route('compare.add', $product->id) }}" class="text-primary d-flex align-items-center justify-content-center">
                                            <span class="rounded-circle btn-sm-square border"><i class="fas fa-random"></i></span>
                                        </a>
                                        <a href="{{ route('wishlist.add', $product->id) }}" class="text-primary d-flex align-items-center justify-content-center">
                                            <span class="rounded-circle btn-sm-square border"><i class="fas fa-heart"></i></span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- New Arrivals Tab --}}
                <div id="tab-2" class="tab-pane fade show p-0">
                    <div class="row g-4">
                        @foreach($newArrivals ?? [] as $product)
                        <div class="col-md-6 col-lg-4 col-xl-3">
                            <div class="product-item rounded wow fadeInUp" data-wow-delay="0.1s">
                                <div class="product-item-inner border rounded">
                                    <div class="product-item-inner-item">
                                        <img src="{{ asset($product->image) }}" class="img-fluid rounded-top" alt="{{ $product->product_name }}">
                                        <div class="product-new">New</div>
                                        <div class="product-details">
                                            <a href="{{ route('product.show', $product->id) }}"><i class="fa fa-eye fa-1x"></i></a>
                                        </div>
                                    </div>
                                    <div class="text-center rounded-bottom p-4">
                                        <a href="{{ route('category', $product->category_id) }}" class="d-block mb-2">
                                            {{ $product->category->category_name ?? 'Uncategorized' }}
                                        </a>
                                        <a href="{{ route('product.show', $product->id) }}" class="d-block h4">
                                            {{ Str::limit($product->product_name, 30) }}
                                        </a>
                                        @if($product->regular_price > $product->sale_price)
                                        <del class="me-2 fs-5">¥{{ number_format($product->regular_price, 0) }}</del>
                                        @endif
                                        <span class="text-primary fs-5">¥{{ number_format($product->sale_price, 0) }}</span>
                                    </div>
                                </div>
                                <div class="product-item-add border border-top-0 rounded-bottom text-center p-4 pt-0">
                                    <form action="{{ route('cart.add', $product->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-primary border-secondary rounded-pill py-2 px-4 mb-3">
                                            <i class="fas fa-shopping-cart me-2"></i> Add To Cart
                                        </button>
                                    </form>
                                    <div class="d-flex justify-content-center align-items-center gap-2">
                                        <a href="{{ route('compare.add', $product->id) }}" class="text-primary d-flex align-items-center justify-content-center">
                                            <span class="rounded-circle btn-sm-square border"><i class="fas fa-random"></i></span>
                                        </a>
                                        <a href="{{ route('wishlist.add', $product->id) }}" class="text-primary d-flex align-items-center justify-content-center">
                                            <span class="rounded-circle btn-sm-square border"><i class="fas fa-heart"></i></span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- Featured Tab --}}
                <div id="tab-3" class="tab-pane fade show p-0">
                    <div class="row g-4">
                        @foreach($featuredProducts ?? [] as $product)
                        <div class="col-md-6 col-lg-4 col-xl-3">
                            <div class="product-item rounded wow fadeInUp" data-wow-delay="0.1s">
                                <div class="product-item-inner border rounded">
                                    <div class="product-item-inner-item">
                                        <img src="{{ asset($product->image) }}" class="img-fluid w-100 rounded-top" alt="{{ $product->product_name }}">
                                        <div class="product-details">
                                            <a href="{{ route('product.show', $product->id) }}"><i class="fa fa-eye fa-1x"></i></a>
                                        </div>
                                    </div>
                                    <div class="text-center rounded-bottom p-4">
                                        <a href="{{ route('category', $product->category_id) }}" class="d-block mb-2">
                                            {{ $product->category->category_name ?? 'Uncategorized' }}
                                        </a>
                                        <a href="{{ route('product.show', $product->id) }}" class="d-block h4">
                                            {{ Str::limit($product->product_name, 30) }}
                                        </a>
                                        @if($product->regular_price > $product->sale_price)
                                        <del class="me-2 fs-5">¥{{ number_format($product->regular_price, 0) }}</del>
                                        @endif
                                        <span class="text-primary fs-5">¥{{ number_format($product->sale_price, 0) }}</span>
                                    </div>
                                </div>
                                <div class="product-item-add border border-top-0 rounded-bottom text-center p-4 pt-0">
                                    <form action="{{ route('cart.add', $product->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-primary border-secondary rounded-pill py-2 px-4 mb-3">
                                            <i class="fas fa-shopping-cart me-2"></i> Add To Cart
                                        </button>
                                    </form>
                                    <div class="d-flex justify-content-center align-items-center gap-2">
                                        <a href="{{ route('compare.add', $product->id) }}" class="text-primary d-flex align-items-center justify-content-center">
                                            <span class="rounded-circle btn-sm-square border"><i class="fas fa-random"></i></span>
                                        </a>
                                        <a href="{{ route('wishlist.add', $product->id) }}" class="text-primary d-flex align-items-center justify-content-center">
                                            <span class="rounded-circle btn-sm-square border"><i class="fas fa-heart"></i></span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- Top Selling Tab --}}
                <div id="tab-4" class="tab-pane fade show p-0">
                    <div class="row g-4">
                        @foreach($topSellingProducts ?? [] as $product)
                        <div class="col-md-6 col-lg-4 col-xl-3">
                            <div class="product-item rounded wow fadeInUp" data-wow-delay="0.1s">
                                <div class="product-item-inner border rounded">
                                    <div class="product-item-inner-item">
                                        <img src="{{ asset($product->image) }}" class="img-fluid w-100 rounded-top" alt="{{ $product->product_name }}">
                                        <div class="product-details">
                                            <a href="{{ route('product.show', $product->id) }}"><i class="fa fa-eye fa-1x"></i></a>
                                        </div>
                                    </div>
                                    <div class="text-center rounded-bottom p-4">
                                        <a href="{{ route('category', $product->category_id) }}" class="d-block mb-2">
                                            {{ $product->category->category_name ?? 'Uncategorized' }}
                                        </a>
                                        <a href="{{ route('product.show', $product->id) }}" class="d-block h4">
                                            {{ Str::limit($product->product_name, 30) }}
                                        </a>
                                        @if($product->regular_price > $product->sale_price)
                                        <del class="me-2 fs-5">¥{{ number_format($product->regular_price, 0) }}</del>
                                        @endif
                                        <span class="text-primary fs-5">¥{{ number_format($product->sale_price, 0) }}</span>
                                    </div>
                                </div>
                                <div class="product-item-add border border-top-0 rounded-bottom text-center p-4 pt-0">
                                    <form action="{{ route('cart.add', $product->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-primary border-secondary rounded-pill py-2 px-4 mb-3">
                                            <i class="fas fa-shopping-cart me-2"></i> Add To Cart
                                        </button>
                                    </form>
                                    <div class="d-flex justify-content-center align-items-center gap-2">
                                        <a href="{{ route('compare.add', $product->id) }}" class="text-primary d-flex align-items-center justify-content-center">
                                            <span class="rounded-circle btn-sm-square border"><i class="fas fa-random"></i></span>
                                        </a>
                                        <a href="{{ route('wishlist.add', $product->id) }}" class="text-primary d-flex align-items-center justify-content-center">
                                            <span class="rounded-circle btn-sm-square border"><i class="fas fa-heart"></i></span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Our Products End -->