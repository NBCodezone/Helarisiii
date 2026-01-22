{{-- resources/views/partials/product-banners.blade.php --}}
<!-- Product Banner Start -->
<div class="container-fluid py-5">
    <div class="container">
        <div class="row g-4">
            @if(isset($banners) && count($banners) > 0)
                @foreach($banners as $banner)
                <div class="col-lg-6 wow fadeInLeft" data-wow-delay="{{ 0.1 * $loop->iteration }}s">
                    <a href="{{ $banner->link ?? '#' }}">
                        <div class="{{ $banner->bg_class ?? 'bg-primary' }} rounded position-relative">
                            <img src="{{ asset('storage/' . $banner->image) }}" class="img-fluid w-100 rounded" alt="{{ $banner->title }}">
                            <div class="position-absolute top-0 start-0 w-100 h-100 d-flex flex-column justify-content-center rounded p-4" 
                                 style="background: {{ $banner->overlay ?? 'rgba(255, 255, 255, 0.5)' }};">
                                <h3 class="display-5 text-primary">{{ $banner->title }}</h3>
                                <p class="fs-4 text-muted">{{ $banner->price ?? '' }}</p>
                                <a href="{{ $banner->link ?? '#' }}" class="btn btn-primary rounded-pill align-self-start py-2 px-4">
                                    Shop Now
                                </a>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            @else
                {{-- Default Banners --}}
                <div class="col-lg-6 wow fadeInLeft" data-wow-delay="0.1s">
                    <a href="{{ route('category', 'cameras') }}">
                        <div class="bg-primary rounded position-relative">
                            <img src="{{ asset('img/product-banner.jpg') }}" class="img-fluid w-100 rounded" alt="Camera Banner">
                            <div class="position-absolute top-0 start-0 w-100 h-100 d-flex flex-column justify-content-center rounded p-4" 
                                 style="background: rgba(255, 255, 255, 0.5);">
                                <h3 class="display-5 text-primary">EOS Rebel <br> <span>T7i Kit</span></h3>
                                <p class="fs-4 text-muted">$899.99</p>
                                <a href="{{ route('category', 'cameras') }}" class="btn btn-primary rounded-pill align-self-start py-2 px-4">
                                    Shop Now
                                </a>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-6 wow fadeInRight" data-wow-delay="0.2s">
                    <a href="{{ route('shop') }}">
                        <div class="text-center bg-primary rounded position-relative">
                            <img src="{{ asset('img/product-banner-2.jpg') }}" class="img-fluid w-100" alt="Sale Banner">
                            <div class="position-absolute top-0 start-0 w-100 h-100 d-flex flex-column justify-content-center rounded p-4" 
                                 style="background: rgba(242, 139, 0, 0.5);">
                                <h2 class="display-2 text-secondary">SALE</h2>
                                <h4 class="display-5 text-white mb-4">Get UP To 50% Off</h4>
                                <a href="{{ route('shop') }}" class="btn btn-secondary rounded-pill align-self-center py-2 px-4">
                                    Shop Now
                                </a>
                            </div>
                        </div>
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
<!-- Product Banner End -->