<!-- Shop Sidebar Start -->
<div class="col-lg-3 wow fadeInUp" data-wow-delay="0.1s">
    <!-- Product Categories -->
    <div class="product-categories mb-4">
        <h4>Products Categories</h4>
        <ul class="list-unstyled">
            @forelse($categories as $category)
            <li>
                <div class="categories-item">
                    <a href="{{ route('shop', ['category' => $category->id]) }}" class="text-dark">
                        <i class="fas fa-apple-alt text-secondary me-2"></i>
                        {{ $category->category_name }}
                    </a>
                    <span>({{ $category->products_count ?? 0 }})</span>
                </div>
            </li>
            @empty
            <li class="text-muted">No categories available</li>
            @endforelse
        </ul>
    </div>

    <!-- Price Filter -->
    <div class="price mb-4">
        <h4 class="mb-2">Price</h4>
        <form id="priceFilterForm" action="{{ route('shop') }}" method="GET">
            @if(request('category'))
            <input type="hidden" name="category" value="{{ request('category') }}">
            @endif
            @if(request('search'))
            <input type="hidden" name="search" value="{{ request('search') }}">
            @endif
            @if(request('sort'))
            <input type="hidden" name="sort" value="{{ request('sort') }}">
            @endif
            <input type="range" class="form-range w-100" id="rangeInput" name="max_price" min="0" max="5000" step="50"
                value="{{ request('max_price', 5000) }}" oninput="amount.value='¥' + Number(rangeInput.value).toLocaleString()">
            <output id="amount" name="amount" for="rangeInput">¥{{ number_format(request('max_price', 5000), 0) }}</output>
            <button type="submit" class="btn btn-primary btn-sm mt-2 w-100">Apply Filter</button>
        </form>
    </div>

    <!-- Featured Products -->
    <div class="featured-product mb-4">
        <h4 class="mb-3">Featured Products</h4>
        @forelse($featuredProducts ?? [] as $featured)
        <div class="featured-product-item">
            <div class="rounded me-4" style="width: 100px; height: 100px;">
                <img src="{{ asset($featured->image) }}" class="img-fluid rounded"
                     alt="{{ $featured->product_name }}"
                     onerror="this.src='{{ asset('Electro-Bootstrap-1.0.0/img/product-3.png') }}'">
            </div>
            <div>
                <h6 class="mb-2">{{ Str::limit($featured->product_name, 20) }}</h6>
                <div class="d-flex mb-2">
                    <h5 class="fw-bold me-2">¥{{ number_format($featured->price, 0) }}</h5>
                </div>
            </div>
        </div>
        @empty
        <p class="text-muted">No featured products</p>
        @endforelse

        @if(isset($featuredProducts) && $featuredProducts->count() > 0)
        <div class="d-flex justify-content-center my-4">
            <a href="{{ route('shop') }}" class="btn btn-primary px-4 py-3 rounded-pill w-100">View More</a>
        </div>
        @endif
    </div>

    <!-- Banner -->
    <!-- <a href="{{ route('shop') }}">
        <div class="position-relative">
            <img src="{{ asset('Electro-Bootstrap-1.0.0/img/product-banner-2.jpg') }}" class="img-fluid w-100 rounded" alt="Image">
            <div class="text-center position-absolute d-flex flex-column align-items-center justify-content-center rounded p-4"
                style="width: 100%; height: 100%; top: 0; right: 0; background: rgba(242, 139, 0, 0.3);">
                <h5 class="display-6 text-primary">SALE</h5>
                <h4 class="text-secondary">Get UP To 50% Off</h4>
                <a href="{{ route('shop') }}" class="btn btn-primary rounded-pill px-4">Shop Now</a>
            </div>
        </div>
    </a> -->

    <!-- Product Tags -->
    <!-- <div class="product-tags py-4">
        <h4 class="mb-3">PRODUCT TAGS</h4>
        <div class="product-tags-items bg-light rounded p-3">
            @php
            $tags = ['New', 'Brand', 'Electronics', 'Phone', 'Camera', 'Laptop', 'Tablet', 'Watch'];
            @endphp
            @foreach($tags as $tag)
            <a href="{{ route('shop', ['search' => $tag]) }}" class="border rounded py-1 px-2 mb-2">{{ $tag }}</a>
            @endforeach
        </div>
    </div> -->
</div>
<!-- Shop Sidebar End -->
