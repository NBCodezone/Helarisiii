@props(['categories'])

<!-- Categories Section Start -->
<div class="container-fluid py-5" style="background: linear-gradient(to bottom, #f0fdf4 0%, #fff 100%);">
    <div class="container">
        <!-- Section Header -->
        <div class="text-center mb-5 wow fadeInUp" data-wow-delay="0.1s">
            <div class="d-inline-block border rounded text-primary px-4 mb-3" style="border-color: var(--bs-primary) !important; color: var(--bs-primary) !important;">
                Browse Categories
            </div>
            <h1 class="display-5 mb-3" style="font-family: 'Playfair Display', serif; color: #2c3e50;">
                Shop By <span style="color: var(--bs-primary);">Category</span>
            </h1>
            <p class="text-muted">Explore our wide range of product categories</p>
        </div>

        @if($categories->count() > 0)
            <!-- Categories Grid -->
            <div class="row g-4">
                @foreach($categories->take(8) as $category)
                    <div class="col-lg-3 col-md-4 col-sm-6 wow fadeInUp" data-wow-delay="{{ 0.1 * $loop->iteration }}s">
                        <a href="{{ route('category', $category->id) }}" class="text-decoration-none">
                            <div class="category-card-home h-100">
                                <!-- Category Image -->
                                <div class="category-image-home">
                                    @if($category->image)
                                        <img src="{{ asset($category->image) }}"
                                             alt="{{ $category->category_name }}"
                                             class="img-fluid">
                                    @else
                                        <div class="category-placeholder-home">
                                            <i class="fas fa-tag"></i>
                                        </div>
                                    @endif
                                    
                                    <!-- Overlay -->
                                    <div class="category-overlay-home">
                                        <div class="view-link">
                                            <i class="fas fa-arrow-right me-2"></i>View Products
                                        </div>
                                    </div>

                                    <!-- Product Count Badge -->
                                    <div class="category-count-badge">
                                        <i class="fas fa-box me-1"></i>
                                        {{ $category->products_count }} {{ Str::plural('Product', $category->products_count) }}
                                    </div>
                                </div>

                                <!-- Category Info -->
                                <div class="category-info-home">
                                    <h5 class="category-name-home">{{ $category->category_name }}</h5>
                                    <div class="category-action-home">
                                        <span class="explore-text">Explore Now</span>
                                        <i class="fas fa-chevron-right"></i>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>

            <!-- View All Button -->
            <div class="text-center mt-5 wow fadeInUp" data-wow-delay="0.1s">
                <a href="{{ route('categories') }}"
                   class="btn btn-lg px-5 py-3"
                   style="background: linear-gradient(135deg, #16a34a 0%, #22c55e 100%);
                          color: white;
                          border: none;
                          border-radius: 30px;
                          font-weight: 700;
                          box-shadow: 0 4px 15px rgba(22, 163, 74, 0.3);
                          transition: all 0.3s ease;"
                   onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 8px 25px rgba(22, 163, 74, 0.4)';"
                   onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 15px rgba(22, 163, 74, 0.3)';">
                    <i class="fas fa-th-large me-2"></i>View All Categories
                </a>
            </div>
        @else
            <!-- No Categories Message -->
            <div class="text-center py-5">
                <div class="mb-4">
                    <i class="fas fa-tags" style="font-size: 4rem; color: #ddd;"></i>
                </div>
                <h4 class="text-muted mb-3">No Categories Available</h4>
                <p class="text-muted">Check back soon for our product categories!</p>
            </div>
        @endif
    </div>
</div>

<!-- Category Section Styles -->
<style>
    .category-card-home {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        border: 1px solid #f0f0f0;
    }

    .category-card-home:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(22, 163, 74, 0.15);
        border-color: rgba(22, 163, 74, 0.2);
    }

    .category-image-home {
        height: 200px;
        position: relative;
        overflow: hidden;
        background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
    }

    .category-image-home img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .category-card-home:hover .category-image-home img {
        transform: scale(1.1);
    }

    .category-placeholder-home {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #16a34a 0%, #22c55e 100%);
    }

    .category-placeholder-home i {
        font-size: 4rem;
        color: rgba(255, 255, 255, 0.9);
    }

    .category-overlay-home {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(to top, rgba(22, 163, 74, 0.9) 0%, rgba(22, 163, 74, 0.3) 50%, transparent 100%);
        display: flex;
        align-items: flex-end;
        justify-content: center;
        padding-bottom: 50px;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .category-card-home:hover .category-overlay-home {
        opacity: 1;
    }

    .view-link {
        color: white;
        font-weight: 600;
        font-size: 0.95rem;
        padding: 10px 20px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 25px;
        backdrop-filter: blur(5px);
        transform: translateY(20px);
        opacity: 0;
        transition: all 0.3s ease 0.1s;
    }

    .category-card-home:hover .view-link {
        transform: translateY(0);
        opacity: 1;
    }

    .category-count-badge {
        position: absolute;
        top: 15px;
        right: 15px;
        background: rgba(255, 255, 255, 0.95);
        color: #16a34a;
        font-weight: 600;
        font-size: 0.75rem;
        padding: 8px 12px;
        border-radius: 20px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .category-info-home {
        padding: 1.5rem;
        text-align: center;
    }

    .category-name-home {
        font-family: 'Playfair Display', serif;
        font-size: 1.15rem;
        font-weight: 700;
        color: #2c3e50;
        margin-bottom: 0.75rem;
        transition: color 0.3s ease;
    }

    .category-card-home:hover .category-name-home {
        color: #16a34a;
    }

    .category-action-home {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        color: #6c757d;
        font-size: 0.875rem;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .category-card-home:hover .category-action-home {
        color: #16a34a;
    }

    .category-action-home i {
        transition: transform 0.3s ease;
    }

    .category-card-home:hover .category-action-home i {
        transform: translateX(5px);
    }

    .explore-text {
        position: relative;
    }

    .explore-text::after {
        content: '';
        position: absolute;
        bottom: -2px;
        left: 0;
        width: 0;
        height: 2px;
        background: #16a34a;
        transition: width 0.3s ease;
    }

    .category-card-home:hover .explore-text::after {
        width: 100%;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .category-image-home {
            height: 160px;
        }
        
        .category-name-home {
            font-size: 1rem;
        }
        
        .category-info-home {
            padding: 1rem;
        }
    }
</style>
<!-- Categories Section End -->
