{{-- resources/views/partials/single/product-display.blade.php --}}
<div class="row g-4 single-product">
    <div class="col-xl-6">
        <!-- Modern Product Gallery -->
        <div class="product-gallery">
            <!-- Main Image Display -->
            <div class="main-image-container position-relative mb-3">
                <div class="main-image bg-light rounded overflow-hidden" style="aspect-ratio: 1/1;">
                    <img id="mainProductImage" src="{{ asset($product->image) }}" class="img-fluid w-100 h-100" style="object-fit: contain;" alt="{{ $product->product_name }}">
                </div>
                <!-- Zoom Icon -->
                <button type="button" class="btn btn-light position-absolute top-0 end-0 m-2 rounded-circle shadow-sm" onclick="openLightbox()" title="View larger">
                    <i class="fas fa-search-plus"></i>
                </button>
            </div>

            <!-- Thumbnail Gallery -->
            @if($product->images->count() > 0)
            <div class="thumbnail-gallery">
                <div class="row g-2">
                    <!-- Main Image Thumbnail -->
                    <div class="col-3">
                        <div class="thumbnail-item active rounded overflow-hidden cursor-pointer border border-2 border-primary" onclick="changeMainImage('{{ asset($product->image) }}', this)" style="aspect-ratio: 1/1;">
                            <img src="{{ asset($product->image) }}" class="img-fluid w-100 h-100" style="object-fit: cover;" alt="Main">
                        </div>
                    </div>
                    <!-- Gallery Images Thumbnails -->
                    @foreach($product->images as $galleryImage)
                    <div class="col-3">
                        <div class="thumbnail-item rounded overflow-hidden cursor-pointer border border-2 border-transparent" onclick="changeMainImage('{{ asset($galleryImage->image_path) }}', this)" style="aspect-ratio: 1/1;">
                            <img src="{{ asset($galleryImage->image_path) }}" class="img-fluid w-100 h-100" style="object-fit: cover;" alt="Gallery {{ $loop->iteration }}">
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        <!-- Lightbox Modal -->
        <div id="imageLightbox" class="lightbox-overlay" onclick="closeLightbox(event)">
            <div class="lightbox-content">
                <button type="button" class="lightbox-close" onclick="closeLightbox(event)">&times;</button>
                <button type="button" class="lightbox-nav lightbox-prev" onclick="navigateLightbox(-1, event)"><i class="fas fa-chevron-left"></i></button>
                <img id="lightboxImage" src="{{ asset($product->image) }}" class="lightbox-image" alt="{{ $product->product_name }}">
                <button type="button" class="lightbox-nav lightbox-next" onclick="navigateLightbox(1, event)"><i class="fas fa-chevron-right"></i></button>
                <div class="lightbox-counter" id="lightboxCounter">1 / {{ 1 + $product->images->count() }}</div>
            </div>
        </div>

        <style>
            .product-gallery .thumbnail-item {
                cursor: pointer;
                transition: all 0.3s ease;
                opacity: 0.7;
            }
            .product-gallery .thumbnail-item:hover {
                opacity: 1;
                transform: scale(1.05);
            }
            .product-gallery .thumbnail-item.active {
                opacity: 1;
                border-color: var(--bs-primary) !important;
            }
            .main-image-container .main-image img {
                transition: transform 0.3s ease;
            }
            .main-image-container:hover .main-image img {
                transform: scale(1.02);
            }
            /* Lightbox Styles */
            .lightbox-overlay {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.95);
                z-index: 9999;
                justify-content: center;
                align-items: center;
            }
            .lightbox-overlay.active {
                display: flex;
            }
            .lightbox-content {
                position: relative;
                max-width: 90%;
                max-height: 90%;
            }
            .lightbox-image {
                max-width: 100%;
                max-height: 85vh;
                object-fit: contain;
                border-radius: 8px;
            }
            .lightbox-close {
                position: absolute;
                top: -40px;
                right: 0;
                background: none;
                border: none;
                color: white;
                font-size: 36px;
                cursor: pointer;
                padding: 0 10px;
            }
            .lightbox-nav {
                position: absolute;
                top: 50%;
                transform: translateY(-50%);
                background: rgba(255, 255, 255, 0.2);
                border: none;
                color: white;
                font-size: 24px;
                padding: 20px 15px;
                cursor: pointer;
                transition: background 0.3s;
                border-radius: 4px;
            }
            .lightbox-nav:hover {
                background: rgba(255, 255, 255, 0.4);
            }
            .lightbox-prev { left: -60px; }
            .lightbox-next { right: -60px; }
            .lightbox-counter {
                position: absolute;
                bottom: -35px;
                left: 50%;
                transform: translateX(-50%);
                color: white;
                font-size: 14px;
            }
            @media (max-width: 768px) {
                .lightbox-prev { left: 10px; }
                .lightbox-next { right: 10px; }
                .lightbox-nav { padding: 15px 10px; font-size: 18px; }
            }
        </style>

        <script>
            // Gallery images array
            const galleryImages = [
                '{{ asset($product->image) }}'
                @foreach($product->images as $galleryImage)
                ,'{{ asset($galleryImage->image_path) }}'
                @endforeach
            ];
            let currentImageIndex = 0;

            function changeMainImage(imageSrc, element) {
                // Update main image
                document.getElementById('mainProductImage').src = imageSrc;

                // Update active thumbnail
                document.querySelectorAll('.thumbnail-item').forEach(item => {
                    item.classList.remove('active', 'border-primary');
                    item.classList.add('border-transparent');
                });
                element.classList.add('active', 'border-primary');
                element.classList.remove('border-transparent');

                // Update current index
                currentImageIndex = galleryImages.indexOf(imageSrc);
            }

            function openLightbox() {
                const lightbox = document.getElementById('imageLightbox');
                const lightboxImage = document.getElementById('lightboxImage');
                lightboxImage.src = document.getElementById('mainProductImage').src;
                currentImageIndex = galleryImages.indexOf(lightboxImage.src);
                updateLightboxCounter();
                lightbox.classList.add('active');
                document.body.style.overflow = 'hidden';
            }

            function closeLightbox(event) {
                if (event.target === event.currentTarget || event.target.classList.contains('lightbox-close')) {
                    document.getElementById('imageLightbox').classList.remove('active');
                    document.body.style.overflow = '';
                }
            }

            function navigateLightbox(direction, event) {
                event.stopPropagation();
                currentImageIndex += direction;
                if (currentImageIndex < 0) currentImageIndex = galleryImages.length - 1;
                if (currentImageIndex >= galleryImages.length) currentImageIndex = 0;

                document.getElementById('lightboxImage').src = galleryImages[currentImageIndex];
                updateLightboxCounter();
            }

            function updateLightboxCounter() {
                document.getElementById('lightboxCounter').textContent = `${currentImageIndex + 1} / ${galleryImages.length}`;
            }

            // Keyboard navigation for lightbox
            document.addEventListener('keydown', function(e) {
                const lightbox = document.getElementById('imageLightbox');
                if (!lightbox.classList.contains('active')) return;

                if (e.key === 'Escape') closeLightbox({ target: lightbox, currentTarget: lightbox });
                if (e.key === 'ArrowLeft') navigateLightbox(-1, { stopPropagation: () => {} });
                if (e.key === 'ArrowRight') navigateLightbox(1, { stopPropagation: () => {} });
            });
        </script>
    </div>
    <div class="col-xl-6">
        <h4 class="fw-bold mb-3">{{ $product->product_name }}</h4>
        <p class="mb-3">Category: {{ $product->category->category_name ?? 'Uncategorized' }}</p>
        <h5 class="fw-bold mb-3">¥{{ number_format($product->price, 0) }}</h5>
        <div class="d-flex flex-column mb-3">
            <small>Product SKU: {{ $product->id }}</small>
            <small>Available: <strong class="text-primary">{{ $product->stock }} items in stock</strong></small>
            @if($product->net_weight)
                <small>Net Weight: {{ $product->net_weight }}</small>
            @endif
        </div>
        @if($product->description)
            <p class="mb-4">{{ $product->description }}</p>
        @endif
        <div class="input-group quantity mb-5" style="width: 130px;">
            <div class="input-group-btn">
                <button type="button" class="btn btn-sm btn-minus rounded-circle bg-light border">
                    <i class="fa fa-minus"></i>
                </button>
            </div>
            <input type="number" id="product-quantity" class="form-control form-control-sm text-center border-0" value="1" min="1" max="{{ $product->stock }}" style="min-width: 50px;">
            <div class="input-group-btn">
                <button type="button" class="btn btn-sm btn-plus rounded-circle bg-light border">
                    <i class="fa fa-plus"></i>
                </button>
            </div>
        </div>
        <button onclick="addToCartSingle({{ $product->id }})" class="btn btn-primary border border-secondary rounded-pill px-4 py-2 mb-4 text-white">
            <i class="fa fa-shopping-bag me-2"></i> Add to cart
        </button>
    </div>
    <div class="col-lg-12">
        <nav>
            <div class="nav nav-tabs mb-3">
                <button class="nav-link active border-white border-bottom-0" type="button"
                    role="tab" id="nav-about-tab" data-bs-toggle="tab" data-bs-target="#nav-about"
                    aria-controls="nav-about" aria-selected="true">Description</button>
            </div>
        </nav>
        <div class="tab-content mb-5">
            <div class="tab-pane active" id="nav-about" role="tabpanel" aria-labelledby="nav-about-tab">
                <p>{{ $product->description ?? 'No description available for this product.' }}</p>
                @if($product->net_weight)
                    <p><strong>Net Weight:</strong> {{ $product->net_weight }}</p>
                @endif
                <p><strong>Stock Available:</strong> {{ $product->stock }} units</p>
            </div>
        </div>
    </div>
</div>
