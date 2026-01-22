{{-- resources/views/partials/single/featured-products-sidebar.blade.php --}}
<div class="featured-product mb-4">
    <h4 class="mb-3">Featured products</h4>
    @foreach($featuredProducts as $product)
        <a href="{{ route('product.show', $product->id) }}" class="text-decoration-none text-dark">
            <div class="featured-product-item">
                <div class="rounded me-4" style="width: 100px; height: 100px;">
                    <img src="{{ asset($product->image) }}" class="img-fluid rounded" alt="{{ $product->product_name }}">
                </div>
                <div>
                    <h6 class="mb-2">{{ Str::limit($product->product_name, 30) }}</h6>
                    <div class="d-flex mb-2">
                        <h5 class="fw-bold me-2">¥{{ number_format($product->price, 0) }}</h5>
                    </div>
                </div>
            </div>
        </a>
    @endforeach
    <div class="d-flex justify-content-center my-4">
        <a href="{{ route('shop') }}" class="btn btn-primary px-4 py-3 rounded-pill w-100">View More</a>
    </div>
</div>
