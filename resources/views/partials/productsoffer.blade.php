 <div class="container-fluid bg-light py-5">
        <div class="container">
            <div class="row g-4">
                @forelse($offers as $offer)
                    <div class="col-lg-6 wow {{ $loop->index % 2 == 0 ? 'fadeInLeft' : 'fadeInRight' }}" data-wow-delay="{{ 0.2 + ($loop->index * 0.1) }}s">
                        <a href="{{ $offer->product ? route('product.show', $offer->product->id) : '#' }}" class="d-flex align-items-center justify-content-between border bg-white rounded p-4">
                            <div>
                                <p class="text-muted mb-3">{{ $offer->title }}</p>
                                <h3 class="text-primary">{{ $offer->product_name }}</h3>
                                <h1 class="display-3 text-secondary mb-0">{{ $offer->discount_percentage }}% <span class="text-primary fw-normal">Off</span></h1>
                            </div>
                            @if($offer->product && $offer->product->image)
                                <img src="{{ asset($offer->product->image) }}" class="img-fluid" alt="{{ $offer->product_name }}" style="max-width: 200px; max-height: 200px; object-fit: contain;">
                            @else
                                <img src="{{ asset('img/product-2.png') }}" class="img-fluid" alt="{{ $offer->product_name }}">
                            @endif
                        </a>
                    </div>
                @empty
                    <div class="col-lg-6 wow fadeInLeft" data-wow-delay="0.2s">
                        <a href="#" class="d-flex align-items-center justify-content-between border bg-white rounded p-4">
                            <div>
                                <p class="text-muted mb-3">Find The Best Camera for You!</p>
                                <h3 class="text-primary">Smart Camera</h3>
                                <h1 class="display-3 text-secondary mb-0">40% <span class="text-primary fw-normal">Off</span></h1>
                            </div>
                            <img src="{{ asset('img/product-1.png') }}" class="img-fluid" alt="">
                        </a>
                    </div>
                    <div class="col-lg-6 wow fadeInRight" data-wow-delay="0.3s">
                        <a href="#" class="d-flex align-items-center justify-content-between border bg-white rounded p-4">
                            <div>
                                <p class="text-muted mb-3">Find The Best Watches for You!</p>
                                <h3 class="text-primary">Smart Watch</h3>
                                <h1 class="display-3 text-secondary mb-0">20% <span class="text-primary fw-normal">Off</span></h1>
                            </div>
                            <img src="{{ asset('img/product-2.png') }}" class="img-fluid" alt="">
                        </a>
                    </div>
                @endforelse
            </div>
        </div>
    </div>