{{-- resources/views/partials/navbar.blade.php --}}
<!-- Navbar & Hero Start -->
<div class="container-fluid nav-bar p-0">
    <div class="row gx-0 bg-primary px-5 align-items-center">
        <div class="col-lg-3 d-none d-lg-block">
            <nav class="navbar navbar-light position-relative" style="width: 250px;">
                <button class="navbar-toggler border-0 fs-4 w-100 px-0 text-start" type="button" 
                        data-bs-toggle="collapse" data-bs-target="#allCat">
                    <h4 class="m-0"><i class="fa fa-bars me-2"></i>All Categories</h4>
                </button>
                <div class="collapse navbar-collapse rounded-bottom" id="allCat">
                    <div class="navbar-nav ms-auto py-0">
                        <ul class="list-unstyled categories-bars">
                            @foreach($categories ?? [] as $category)
                                <li>
                                    <div class="categories-bars-item">
                                        <a href="{{ route('category', $category->id) }}">{{ $category->category_name }}</a>
                                        <span>({{ $category->products_count ?? 0 }})</span>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
        <div class="col-12 col-lg-9">
            <nav class="navbar navbar-expand-lg navbar-light bg-primary">
                <a href="{{ route('home') }}" class="navbar-brand d-block d-lg-none d-flex align-items-center">
                    @php
                        $logoRelPath = null;
                        $envLogo = config('app.logo') ?? env('APP_LOGO');
                        if ($envLogo && file_exists(public_path($envLogo))) {
                            $logoRelPath = ltrim($envLogo, '/');
                        }
                        if (!$logoRelPath) {
                            foreach (['images/logo.png','images/logo.svg','images/logo.webp','images/logo.jpg','images/logo.jpeg'] as $p) {
                                if (file_exists(public_path($p))) { $logoRelPath = $p; break; }
                            }
                        }
                        if (!$logoRelPath) {
                            $matches = glob(public_path('images/*logo*.*'));
                            if (!$matches || count($matches) === 0) {
                                $matches = glob(public_path('images/*.*'));
                            }
                            if ($matches && count($matches) > 0) {
                                $logoRelPath = 'images/' . basename($matches[0]);
                            }
                        }
                    @endphp
                    @if($logoRelPath)
                        <img src="{{ asset($logoRelPath) }}?v=1.1" alt="{{ config('app.name', 'Helarisi') }}" style="height: 40px;" />
                    @else
                        <h1 class="display-5 text-secondary m-0">
                            <i class="fas fa-shopping-bag text-white me-2"></i>{{ config('app.name', 'Helarisi') }}
                        </h1>
                    @endif
                </a>
                <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse" 
                        data-bs-target="#navbarCollapse">
                    <span class="fa fa-bars fa-1x"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <div class="navbar-nav ms-auto py-0">
                        <a href="{{ route('home') }}" class="nav-item nav-link {{ request()->routeIs('home') ? 'active' : '' }}">Home</a>
                        <a href="{{ route('shop') }}" class="nav-item nav-link {{ request()->routeIs('shop') ? 'active' : '' }}">Shop</a>
                        <a href="{{ route('categories') }}" class="nav-item nav-link {{ request()->routeIs('categories') ? 'active' : '' }}">Categories</a>
                        <a href="{{ route('bestseller') }}" class="nav-item nav-link {{ request()->routeIs('bestseller') ? 'active' : '' }}">Bestseller</a>
                        <a href="{{ route('cart') }}" class="nav-item nav-link {{ request()->routeIs('cart') ? 'active' : '' }}">Cart</a>
                        <a href="{{ route('contact') }}" class="nav-item nav-link me-2 {{ request()->routeIs('contact') ? 'active' : '' }}">Contact</a>
                        <div class="nav-item dropdown d-block d-lg-none mb-3">
                            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">All Category</a>
                            <div class="dropdown-menu m-0">
                                <ul class="list-unstyled categories-bars">
                                    @foreach($categories ?? [] as $category)
                                        <li>
                                            <div class="categories-bars-item">
                                                <a href="{{ route('category', $category->id) }}">{{ $category->category_name }}</a>
                                                <span>({{ $category->products_count ?? 0 }})</span>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                    <a href="tel:+818044550579" class="btn btn-secondary rounded-pill py-2 px-4 px-lg-3 mb-3 mb-md-3 mb-lg-0">
                        <i class="fa fa-mobile-alt me-2"></i> +81 80 4455 0579
                    </a>
                </div>
            </nav>
        </div>
    </div>
</div>
<!-- Navbar & Hero End -->
