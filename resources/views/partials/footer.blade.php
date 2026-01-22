{{-- resources/views/partials/footer.blade.php --}}
<!-- Footer Start -->
<div class="container-fluid footer py-5 wow fadeIn" data-wow-delay="0.2s">
    <div class="container py-5">
        <div class="row g-4 rounded mb-5" style="background: rgba(255, 255, 255, .03);">
            <div class="col-md-6 col-lg-6 col-xl-3">
                <div class="rounded p-4">
                    <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center mb-4" 
                         style="width: 70px; height: 70px;">
                        <i class="fas fa-map-marker-alt fa-2x text-primary"></i>
                    </div>
                    <div>
                        <h4 class="text-white">Address</h4>
                        <p class="mb-2">Ibaraki ken, Moriya Shi</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-6 col-xl-3">
                <div class="rounded p-4">
                    <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center mb-4" 
                         style="width: 70px; height: 70px;">
                        <i class="fas fa-envelope fa-2x text-primary"></i>
                    </div>
                    <div>
                        <h4 class="text-white">Mail Us</h4>
                        <p class="mb-2">helarisiproducts@gmail.com</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-6 col-xl-3">
                <div class="rounded p-4">
                    <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center mb-4" 
                         style="width: 70px; height: 70px;">
                        <i class="fa fa-phone-alt fa-2x text-primary"></i>
                    </div>
                    <div>
                        <h4 class="text-white">Telephone</h4>
                        <p class="mb-2">+81 80 4455 0579</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-6 col-xl-3">
                <div class="rounded p-4">
                    <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center mb-4" 
                         style="width: 70px; height: 70px;">
                        <i class="fab fa-firefox-browser fa-2x text-primary"></i>
                    </div>
                    <div>
                        <h4 class="text-white">helarisiproducts@gmail.com</h4>
                        <p class="mb-2">+81 80 4455 0579</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row g-5 justify-content-center">
            <div class="col-md-6 col-lg-4">
                <div class="footer-item d-flex flex-column">
                    <h4 class="text-primary mb-4">Customer Service</h4>
                    <a href="{{ route('contact') }}" class=""><i class="fas fa-angle-right me-2"></i> Contact Us</a>
                    <!-- <a href="{{ route('returns') }}" class=""><i class="fas fa-angle-right me-2"></i> Returns</a> -->
                    <a href="{{ route('order.history') }}" class=""><i class="fas fa-angle-right me-2"></i> Order History</a>
                    <!-- <a href="{{ route('sitemap') }}" class=""><i class="fas fa-angle-right me-2"></i> Site Map</a>
                    <a href="{{ route('testimonials') }}" class=""><i class="fas fa-angle-right me-2"></i> Testimonials</a> -->
                    @auth
                        <a href="{{ route('user.dashboard') }}" class=""><i class="fas fa-angle-right me-2"></i> My Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class=""><i class="fas fa-angle-right me-2"></i> My Dashboard</a>
                    @endauth
                    <!-- <a href="{{ route('unsubscribe') }}" class=""><i class="fas fa-angle-right me-2"></i> Unsubscribe Notification</a> -->
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="footer-item d-flex flex-column">
                    <h4 class="text-primary mb-4">Information</h4>
                    <a href="{{ route('about') }}" class=""><i class="fas fa-angle-right me-2"></i> About Us</a>
                    <!-- <a href="{{ route('delivery') }}" class=""><i class="fas fa-angle-right me-2"></i> Delivery Information</a> -->
                    <a href="{{ route('privacy') }}" class=""><i class="fas fa-angle-right me-2"></i> Privacy Policy</a>
                    <a href="{{ route('terms') }}" class=""><i class="fas fa-angle-right me-2"></i> Terms & Conditions</a>
                    <!-- <a href="{{ route('warranty') }}" class=""><i class="fas fa-angle-right me-2"></i> Warranty</a>
                    <a href="{{ route('faq') }}" class=""><i class="fas fa-angle-right me-2"></i> FAQ</a>
                    <a href="{{ route('seller.login') }}" class=""><i class="fas fa-angle-right me-2"></i> Seller Login</a> -->
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="footer-item d-flex flex-column">
                    <h4 class="text-primary mb-4">Extras</h4>
                    <!-- <a href="{{ route('brands') }}" class=""><i class="fas fa-angle-right me-2"></i> Brands</a>
                    <a href="{{ route('vouchers') }}" class=""><i class="fas fa-angle-right me-2"></i> Gift Vouchers</a>
                    <a href="{{ route('affiliates') }}" class=""><i class="fas fa-angle-right me-2"></i> Affiliates</a> -->
                    @auth
                        <a href="{{ route('user.wishlist') }}" class=""><i class="fas fa-angle-right me-2"></i> Wishlist</a>
                    @else
                        <a href="{{ route('login') }}" class=""><i class="fas fa-angle-right me-2"></i> Wishlist</a>
                    @endauth
                    <a href="{{ route('order.history') }}" class=""><i class="fas fa-angle-right me-2"></i> Order History</a>
                    <a href="{{ route('track') }}" class=""><i class="fas fa-angle-right me-2"></i> Track Your Order</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Footer End -->

<!-- Copyright Start -->
<div class="container-fluid copyright py-4">
    <div class="container">
        <div class="row g-4 align-items-center">
            <div class="col-12 text-center">
                <span class="text-white">
                    Developed by <strong>NB Code Zone</strong>
                </span>
            </div>
        </div>
    </div>
</div>
<!-- Copyright End -->

<!-- WhatsApp Floating Button -->
@include('partials.whatsapp-button')