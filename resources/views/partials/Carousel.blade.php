<div class="container-fluid carousel-section px-0">
    <div class="modern-carousel-wrapper">
        <div class="header-carousel owl-carousel">
            @forelse($carousels as $carousel)
                <div class="carousel-slide">
                    <div class="carousel-slide-inner">
                        <!-- Background Gradient Overlay -->
                        <div class="carousel-bg-overlay"></div>
                        
                        <!-- Two Column Layout -->
                        <div class="carousel-row">
                            <!-- Left Side - Image (50%) -->
                            <div class="carousel-image-col">
                                <div class="carousel-image-wrapper wow fadeInLeft" data-wow-delay="0.1s">
                                    <img src="{{ asset($carousel->image) }}" 
                                         class="carousel-main-image" 
                                         alt="{{ $carousel->title }}">
                                </div>
                                <!-- Decorative Elements for Image Side -->
                                <div class="image-decoration">
                                    <div class="deco-ring ring-1"></div>
                                    <div class="deco-ring ring-2"></div>
                                    <div class="deco-dots"></div>
                                </div>
                            </div>
                            
                            <!-- Right Side - Content (50%) -->
                            <div class="carousel-content-col">
                                <div class="carousel-text-content">
                                    <h4 class="carousel-subtitle wow fadeInRight" data-wow-delay="0.2s">
                                        {{ $carousel->title }}
                                    </h4>
                                    <h1 class="carousel-title wow fadeInRight" data-wow-delay="0.3s">
                                        {{ $carousel->description }}
                                    </h1>
                                    @if($carousel->subtitle)
                                        <p class="carousel-desc wow fadeInRight" data-wow-delay="0.4s">
                                            {{ $carousel->subtitle }}
                                        </p>
                                    @endif
                                    @if($carousel->button_text && $carousel->button_link)
                                        <a class="carousel-btn wow fadeInRight" data-wow-delay="0.5s"
                                            href="{{ $carousel->button_link }}">
                                            {{ $carousel->button_text }}
                                            <i class="fas fa-arrow-right ms-2"></i>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        <!-- Background Decorations -->
                        <div class="carousel-decoration">
                            <div class="decoration-circle circle-1"></div>
                            <div class="decoration-circle circle-2"></div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="carousel-slide">
                    <div class="carousel-slide-inner">
                        <div class="carousel-bg-overlay"></div>
                        <div class="carousel-row">
                            <div class="carousel-image-col">
                                <div class="carousel-image-wrapper wow fadeInLeft" data-wow-delay="0.1s">
                                    <img src="{{ asset('Electro-Bootstrap-1.0.0/img/carousel-1.png') }}" 
                                         class="carousel-main-image" 
                                         alt="Welcome">
                                </div>
                                <div class="image-decoration">
                                    <div class="deco-ring ring-1"></div>
                                    <div class="deco-ring ring-2"></div>
                                    <div class="deco-dots"></div>
                                </div>
                            </div>
                            <div class="carousel-content-col">
                                <div class="carousel-text-content">
                                    <h4 class="carousel-subtitle wow fadeInRight" data-wow-delay="0.2s">
                                        Save Up To $400
                                    </h4>
                                    <h1 class="carousel-title wow fadeInRight" data-wow-delay="0.3s">
                                        On Selected Laptops & Smartphones
                                    </h1>
                                    <p class="carousel-desc wow fadeInRight" data-wow-delay="0.4s">
                                        Terms and Condition Apply
                                    </p>
                                    <a class="carousel-btn wow fadeInRight" data-wow-delay="0.5s" href="{{ route('shop') }}">
                                        Shop Now
                                        <i class="fas fa-arrow-right ms-2"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="carousel-decoration">
                            <div class="decoration-circle circle-1"></div>
                            <div class="decoration-circle circle-2"></div>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>
        
        <!-- Custom Navigation -->
        <div class="carousel-nav-wrapper">
            <button class="carousel-nav-btn prev-btn">
                <i class="fas fa-chevron-left"></i>
            </button>
            <button class="carousel-nav-btn next-btn">
                <i class="fas fa-chevron-right"></i>
            </button>
        </div>
        
        <!-- Custom Dots -->
        <div class="carousel-dots-wrapper">
            <!-- Dots will be generated by Owl Carousel -->
        </div>
    </div>
</div>

<style>
/* Modern Carousel Styles */
.carousel-section {
    position: relative;
    overflow: hidden;
}

.modern-carousel-wrapper {
    position: relative;
    width: 100%;
}

.carousel-slide {
    width: 100%;
}

.carousel-slide-inner {
    position: relative;
    min-height: 550px;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 50%, #f1f3f5 100%);
    display: flex;
    align-items: center;
    overflow: hidden;
}

/* Gradient Overlay */
.carousel-bg-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, 
        rgba(40, 167, 69, 0.03) 0%, 
        rgba(255, 255, 255, 0.5) 50%, 
        rgba(40, 167, 69, 0.05) 100%);
    pointer-events: none;
}

/* Two Column Row Layout */
.carousel-row {
    display: flex;
    width: 100%;
    min-height: 550px;
    position: relative;
    z-index: 2;
}

/* Left Image Column - 50% */
.carousel-image-col {
    width: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    padding: 40px;
    background: linear-gradient(135deg, rgba(40, 167, 69, 0.05) 0%, transparent 100%);
}

/* Right Content Column - 50% */
.carousel-content-col {
    width: 50%;
    display: flex;
    align-items: center;
    justify-content: flex-start;
    padding: 40px 60px;
}

/* Image Wrapper */
.carousel-image-wrapper {
    position: relative;
    z-index: 2;
}

.carousel-main-image {
    width: 100%;
    max-width: 380px;
    height: auto;
    max-height: 380px;
    object-fit: contain;
    border-radius: 24px;
    box-shadow: 0 30px 80px rgba(0, 0, 0, 0.12);
    transition: transform 0.6s ease;
    background: white;
    padding: 20px;
}

.carousel-slide:hover .carousel-main-image {
    transform: scale(1.05) rotate(-2deg);
}

/* Image Side Decorations */
.image-decoration {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    pointer-events: none;
}

.deco-ring {
    position: absolute;
    border-radius: 50%;
    border: 3px solid rgba(40, 167, 69, 0.15);
}

.ring-1 {
    width: 450px;
    height: 450px;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    animation: pulse-ring 3s ease-in-out infinite;
}

.ring-2 {
    width: 350px;
    height: 350px;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    border-color: rgba(32, 201, 151, 0.1);
    animation: pulse-ring 3s ease-in-out infinite 0.5s;
}

.deco-dots {
    position: absolute;
    width: 100px;
    height: 100px;
    top: 20%;
    right: 10%;
    background-image: radial-gradient(circle, rgba(40, 167, 69, 0.3) 2px, transparent 2px);
    background-size: 15px 15px;
}

@keyframes pulse-ring {
    0%, 100% {
        opacity: 0.5;
        transform: translate(-50%, -50%) scale(1);
    }
    50% {
        opacity: 0.8;
        transform: translate(-50%, -50%) scale(1.05);
    }
}

/* Text Content Styles */
.carousel-text-content {
    max-width: 500px;
}

.carousel-subtitle {
    font-size: 14px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 4px;
    color: #28a745;
    margin-bottom: 20px;
    position: relative;
    display: inline-block;
}

.carousel-subtitle::before {
    content: '';
    position: absolute;
    left: -40px;
    top: 50%;
    transform: translateY(-50%);
    width: 30px;
    height: 3px;
    background: linear-gradient(90deg, #28a745, #20c997);
    border-radius: 2px;
}

.carousel-title {
    font-size: clamp(32px, 4vw, 52px);
    font-weight: 800;
    color: #1a1a2e;
    line-height: 1.15;
    margin-bottom: 25px;
    background: linear-gradient(135deg, #1a1a2e 0%, #2d3436 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.carousel-desc {
    font-size: 17px;
    color: #6c757d;
    margin-bottom: 35px;
    line-height: 1.7;
}

/* Button Styles */
.carousel-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 16px 45px;
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
    color: white;
    font-weight: 600;
    font-size: 15px;
    text-decoration: none;
    border-radius: 50px;
    box-shadow: 0 12px 35px rgba(40, 167, 69, 0.35);
    transition: all 0.4s ease;
    position: relative;
    overflow: hidden;
}

.carousel-btn::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
    transition: left 0.5s ease;
}

.carousel-btn:hover {
    transform: translateY(-4px);
    box-shadow: 0 18px 45px rgba(40, 167, 69, 0.45);
    color: white;
}

.carousel-btn:hover::before {
    left: 100%;
}

.carousel-btn i {
    transition: transform 0.3s ease;
}

.carousel-btn:hover i {
    transform: translateX(6px);
}

/* Background Decorative Elements */
.carousel-decoration {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    pointer-events: none;
    overflow: hidden;
}

.decoration-circle {
    position: absolute;
    border-radius: 50%;
    opacity: 0.4;
}

.circle-1 {
    width: 400px;
    height: 400px;
    background: linear-gradient(135deg, rgba(40, 167, 69, 0.08) 0%, transparent 70%);
    bottom: -150px;
    right: -100px;
    animation: float 10s ease-in-out infinite;
}

.circle-2 {
    width: 250px;
    height: 250px;
    background: linear-gradient(135deg, rgba(32, 201, 151, 0.08) 0%, transparent 70%);
    top: -80px;
    right: 30%;
    animation: float 8s ease-in-out infinite reverse;
}

@keyframes float {
    0%, 100% {
        transform: translateY(0) scale(1);
    }
    50% {
        transform: translateY(-25px) scale(1.03);
    }
}

/* Navigation Buttons */
.carousel-nav-wrapper {
    position: absolute;
    top: 50%;
    left: 0;
    right: 0;
    transform: translateY(-50%);
    display: flex;
    justify-content: space-between;
    padding: 0 25px;
    pointer-events: none;
    z-index: 10;
}

.carousel-nav-btn {
    width: 55px;
    height: 55px;
    border-radius: 50%;
    border: none;
    background: white;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
    color: #28a745;
    font-size: 18px;
    cursor: pointer;
    transition: all 0.3s ease;
    pointer-events: auto;
    display: flex;
    align-items: center;
    justify-content: center;
}

.carousel-nav-btn:hover {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
    color: white;
    transform: scale(1.1);
    box-shadow: 0 12px 35px rgba(40, 167, 69, 0.35);
}

/* Custom Dots */
.carousel-dots-wrapper {
    position: absolute;
    bottom: 35px;
    left: 50%;
    transform: translateX(-50%);
    z-index: 10;
}

.owl-dots {
    display: flex;
    gap: 12px;
}

.owl-dot {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    background: rgba(40, 167, 69, 0.25);
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
}

.owl-dot.active {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
    width: 35px;
    border-radius: 6px;
}

/* Responsive Styles */
@media (max-width: 992px) {
    .carousel-row {
        flex-direction: column;
        min-height: auto;
    }
    
    .carousel-image-col,
    .carousel-content-col {
        width: 100%;
        padding: 30px;
    }
    
    .carousel-image-col {
        padding-bottom: 10px;
    }
    
    .carousel-content-col {
        padding-top: 10px;
        justify-content: center;
        text-align: center;
    }
    
    .carousel-text-content {
        max-width: 100%;
    }
    
    .carousel-subtitle::before {
        display: none;
    }
    
    .carousel-main-image {
        max-width: 280px;
        max-height: 280px;
    }
    
    .ring-1 {
        width: 350px;
        height: 350px;
    }
    
    .ring-2 {
        width: 280px;
        height: 280px;
    }
    
    .carousel-slide-inner {
        min-height: auto;
        padding: 40px 0;
    }
}

@media (max-width: 768px) {
    .carousel-image-col,
    .carousel-content-col {
        padding: 20px;
    }
    
    .carousel-main-image {
        max-width: 220px;
        max-height: 220px;
        padding: 15px;
    }
    
    .carousel-nav-wrapper {
        padding: 0 15px;
    }
    
    .carousel-nav-btn {
        width: 45px;
        height: 45px;
        font-size: 14px;
    }
    
    .carousel-btn {
        padding: 14px 35px;
        font-size: 14px;
    }
    
    .deco-dots {
        display: none;
    }
}

@media (max-width: 480px) {
    .carousel-main-image {
        max-width: 180px;
        max-height: 180px;
    }
    
    .carousel-subtitle {
        font-size: 12px;
        letter-spacing: 2px;
    }
    
    .carousel-title {
        font-size: 26px;
    }
    
    .ring-1, .ring-2 {
        display: none;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Modern Carousel
    if (typeof $.fn.owlCarousel !== 'undefined') {
        $('.header-carousel').owlCarousel({
            items: 1,
            loop: true,
            autoplay: true,
            autoplayTimeout: 5000,
            autoplayHoverPause: true,
            smartSpeed: 800,
            dots: true,
            nav: false,
            dotsContainer: '.carousel-dots-wrapper',
            animateIn: 'fadeIn',
            animateOut: 'fadeOut'
        });
        
        // Custom Navigation
        $('.prev-btn').click(function() {
            $('.header-carousel').trigger('prev.owl.carousel');
        });
        
        $('.next-btn').click(function() {
            $('.header-carousel').trigger('next.owl.carousel');
        });
    }
});
</script>