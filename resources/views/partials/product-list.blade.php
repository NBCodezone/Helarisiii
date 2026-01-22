{{-- resources/views/partials/product-list.blade.php --}}
<!-- Product List Start -->
<div class="container-fluid products productList overflow-hidden">
    <div class="container products-mini py-5">
        <div class="mx-auto text-center mb-5" style="max-width: 900px;">
            <h4 class="text-primary border-bottom border-primary border-2 d-inline-block p-2 title-border-radius wow fadeInUp" 
                data-wow-delay="0.1s">Products</h4>
            <h1 class="mb-0 display-3 wow fadeInUp" data-wow-delay="0.3s">All Product Items</h1>
        </div>
        <div class="productList-carousel owl-carousel pt-4 wow fadeInUp" data-wow-delay="0.3s">
            @php
                $productChunks = collect($allProducts ?? [])->chunk(4);
            @endphp
            
            @foreach($productChunks as $chunk)
            <div class="productImg-carousel owl-carousel productList-item">
                @foreach($chunk as $product)
                <div class="productImg-item products-mini-item border">
                    <div class="row g-0">
                        <div class="col-5">
                            <div class="products-mini-img border-end h-100">
                                <img src="{{ asset($product->image) }}" class="img-fluid w-100 h-100" alt="{{ $product->name }}">
                                <div class="products-mini-icon rounded-circle bg-primary">
                                    <a href="{{ route('product.show', $product->id) }}"><i class="fa fa-eye fa-1x text-white"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-7">
                            <div class="products-mini-content p-3">
                                <a href="{{ route('category', $product->category->id) }}" class="d-block mb-2">
                                    {{ $product->category->name }}
                                </a>
                                <a href="{{ route('product.show', $product->id) }}" class="d-block h4">
                                    {{ Str::limit($product->name, 25) }}
                                </a>
                                @if($product->regular_price > $product->sale_price)
                                <del class="me-2 fs-5">¥{{ number_format($product->regular_price, 0) }}</del>
                                @endif
                                <span class="text-primary fs-5">¥{{ number_format($product->sale_price, 0) }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="products-mini-add border p-3">
                        <form action="{{ route('cart.add', $product->id) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-primary border-secondary rounded-pill py-2 px-4">
                                <i class="fas fa-shopping-cart me-2"></i> Add To Cart
                            </button>
                        </form>
                        <div class="d-flex">
                            <a href="{{ route('compare.add', $product->id) }}" 
                               class="text-primary d-flex align-items-center justify-content-center me-3">
                                <span class="rounded-circle btn-sm-square border"><i class="fas fa-random"></i></span>
                            </a>
                            <a href="{{ route('wishlist.add', $product->id) }}" 
                               class="text-primary d-flex align-items-center justify-content-center me-0">
                                <span class="rounded-circle btn-sm-square border"><i class="fas fa-heart"></i></span>
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @endforeach
        </div>
    </div>
</div>
<!-- Product List End -->