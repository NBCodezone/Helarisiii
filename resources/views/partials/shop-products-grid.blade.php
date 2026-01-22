<!-- Shop Products Grid Start -->
<div class="col-lg-9 wow fadeInUp" data-wow-delay="0.1s">
    @include('partials.shop-banner')

    <!-- Search and Sort Bar -->
    <div class="row g-4">
        <div class="col-xl-7">
            <form action="{{ route('shop') }}" method="GET" class="input-group w-100 mx-auto d-flex">
                @if(request('category'))
                <input type="hidden" name="category" value="{{ request('category') }}">
                @endif
                @if(request('max_price'))
                <input type="hidden" name="max_price" value="{{ request('max_price') }}">
                @endif
                @if(request('sort'))
                <input type="hidden" name="sort" value="{{ request('sort') }}">
                @endif
                <input type="search" name="search" class="form-control p-3" placeholder="Search products..."
                    value="{{ request('search') }}" aria-describedby="search-icon-1">
                <button type="submit" id="search-icon-1" class="input-group-text p-3">
                    <i class="fa fa-search"></i>
                </button>
            </form>
        </div>
        <div class="col-xl-3 text-end">
            <form action="{{ route('shop') }}" method="GET" id="sortForm">
                @if(request('category'))
                <input type="hidden" name="category" value="{{ request('category') }}">
                @endif
                @if(request('max_price'))
                <input type="hidden" name="max_price" value="{{ request('max_price') }}">
                @endif
                @if(request('search'))
                <input type="hidden" name="search" value="{{ request('search') }}">
                @endif
                <div class="bg-light ps-3 py-3 rounded d-flex justify-content-between">
                    <label for="sortSelect">Sort By:</label>
                    <select id="sortSelect" name="sort" class="border-0 form-select-sm bg-light me-3"
                        onchange="document.getElementById('sortForm').submit()">
                        <option value="">Default Sorting</option>
                        <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Name (A-Z)</option>
                        <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Name (Z-A)</option>
                        <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price (Low to High)</option>
                        <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price (High to Low)</option>
                        <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest First</option>
                    </select>
                </div>
            </form>
        </div>
        <div class="col-lg-4 col-xl-2">
            <ul class="nav nav-pills d-inline-flex text-center py-2 px-2 rounded bg-light mb-4">
                <li class="nav-item me-4">
                    <a class="bg-light active" data-bs-toggle="pill" href="#tab-grid">
                        <i class="fas fa-th fa-3x text-primary"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="bg-light" data-bs-toggle="pill" href="#tab-list">
                        <i class="fas fa-bars fa-3x text-primary"></i>
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <!-- Products Grid/List View -->
    <div class="tab-content">
        <!-- Grid View -->
        <div id="tab-grid" class="tab-pane fade show p-0 active">
            <div class="row g-4 product">
                @forelse($products as $product)
                <div class="col-lg-4">
                    <div class="product-item rounded wow fadeInUp" data-wow-delay="0.1s">
                        <div class="product-item-inner border rounded">
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
                                <a href="{{ route('product.show', $product->id) }}" class="d-block mb-2">
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
                @empty
                <div class="col-12">
                    <div class="alert alert-info text-center">
                        <h4>No products found</h4>
                        <p>Try adjusting your filters or search terms.</p>
                        <a href="{{ route('shop') }}" class="btn btn-primary">View All Products</a>
                    </div>
                </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($products->hasPages())
            <div class="row mt-5">
                <div class="col-12">
                    <div class="pagination d-flex justify-content-center">
                        <nav aria-label="Page navigation">
                            <ul class="pagination">
                                {{-- Previous Page Link --}}
                                @if ($products->onFirstPage())
                                    <li class="page-item disabled">
                                        <span class="page-link rounded-pill me-2 px-3 py-2"><i class="fa fa-chevron-left"></i></span>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link rounded-pill me-2 px-3 py-2" href="{{ $products->previousPageUrl() }}" rel="prev"><i class="fa fa-chevron-left"></i></a>
                                    </li>
                                @endif

                                {{-- Pagination Elements --}}
                                @foreach ($products->getUrlRange(1, $products->lastPage()) as $page => $url)
                                    @if ($page == $products->currentPage())
                                        <li class="page-item active">
                                            <span class="page-link rounded-circle mx-1" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">{{ $page }}</span>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a class="page-link rounded-circle mx-1" href="{{ $url }}" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">{{ $page }}</a>
                                        </li>
                                    @endif
                                @endforeach

                                {{-- Next Page Link --}}
                                @if ($products->hasMorePages())
                                    <li class="page-item">
                                        <a class="page-link rounded-pill ms-2 px-3 py-2" href="{{ $products->nextPageUrl() }}" rel="next"><i class="fa fa-chevron-right"></i></a>
                                    </li>
                                @else
                                    <li class="page-item disabled">
                                        <span class="page-link rounded-pill ms-2 px-3 py-2"><i class="fa fa-chevron-right"></i></span>
                                    </li>
                                @endif
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- List View -->
        <div id="tab-list" class="tab-pane fade p-0">
            <div class="row g-4">
                @forelse($products as $product)
                <div class="col-12">
                    <div class="product-item rounded border d-flex wow fadeInUp" data-wow-delay="0.1s">
                        <div class="col-md-3">
                            <div class="product-item-inner-item">
                                <img src="{{ asset($product->image) }}"
                                     class="img-fluid rounded"
                                     alt="{{ $product->product_name }}"
                                     onerror="this.src='{{ asset('Electro-Bootstrap-1.0.0/img/product-3.png') }}'">
                                @if($product->created_at && $product->created_at->diffInDays(now()) < 30)
                                <div class="product-new">New</div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-9 p-4">
                            <div class="d-flex justify-content-between mb-3">
                                <div>
                                    <a href="{{ route('product.show', $product->id) }}" class="text-primary">
                                        {{ $product->category->category_name ?? 'Uncategorized' }}
                                    </a>
                                    <h4 class="mt-2">
                                        <a href="{{ route('product.show', $product->id) }}" class="text-dark">
                                            {{ $product->product_name }}
                                        </a>
                                    </h4>
                                </div>
                                <div>
                                    <h4 class="text-primary">¥{{ number_format($product->price, 0) }}</h4>
                                </div>
                            </div>
                            <p class="text-muted">{{ Str::limit($product->description ?? 'No description available', 150) }}</p>
                            <div>
                                <form action="{{ route('cart.add', $product->id) }}" method="POST" class="d-inline add-to-cart-form">
                                    @csrf
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="btn btn-primary rounded-pill py-2 px-4">
                                        <i class="fas fa-shopping-cart me-2"></i> Add To Cart
                                    </button>
                                </form>
                                <a href="{{ route('product.show', $product->id) }}" class="btn btn-outline-primary rounded-pill py-2 px-4 ms-2">
                                    <i class="fa fa-eye me-2"></i> View Details
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12">
                    <div class="alert alert-info text-center">
                        <h4>No products found</h4>
                        <p>Try adjusting your filters or search terms.</p>
                        <a href="{{ route('shop') }}" class="btn btn-primary">View All Products</a>
                    </div>
                </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($products->hasPages())
            <div class="row mt-5">
                <div class="col-12">
                    <div class="pagination d-flex justify-content-center">
                        <nav aria-label="Page navigation">
                            <ul class="pagination">
                                {{-- Previous Page Link --}}
                                @if ($products->onFirstPage())
                                    <li class="page-item disabled">
                                        <span class="page-link rounded-pill me-2 px-3 py-2"><i class="fa fa-chevron-left"></i></span>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link rounded-pill me-2 px-3 py-2" href="{{ $products->previousPageUrl() }}" rel="prev"><i class="fa fa-chevron-left"></i></a>
                                    </li>
                                @endif

                                {{-- Pagination Elements --}}
                                @foreach ($products->getUrlRange(1, $products->lastPage()) as $page => $url)
                                    @if ($page == $products->currentPage())
                                        <li class="page-item active">
                                            <span class="page-link rounded-circle mx-1" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">{{ $page }}</span>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a class="page-link rounded-circle mx-1" href="{{ $url }}" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">{{ $page }}</a>
                                        </li>
                                    @endif
                                @endforeach

                                {{-- Next Page Link --}}
                                @if ($products->hasMorePages())
                                    <li class="page-item">
                                        <a class="page-link rounded-pill ms-2 px-3 py-2" href="{{ $products->nextPageUrl() }}" rel="next"><i class="fa fa-chevron-right"></i></a>
                                    </li>
                                @else
                                    <li class="page-item disabled">
                                        <span class="page-link rounded-pill ms-2 px-3 py-2"><i class="fa fa-chevron-right"></i></span>
                                    </li>
                                @endif
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
<!-- Shop Products Grid End -->
