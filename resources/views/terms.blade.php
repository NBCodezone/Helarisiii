<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Terms & Conditions - {{ config('app.name', 'Laravel') }}</title>

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500;600&family=Rubik:wght@500;600;700&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="{{ asset('lib/animate/animate.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="{{ asset('Electro-Bootstrap-1.0.0/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="{{ asset('Electro-Bootstrap-1.0.0/css/style.css') }}" rel="stylesheet">

    <!-- Custom Stylesheet -->
    <link href="{{ asset('css/custom.css?v=1.1') }}" rel="stylesheet">
</head>
<body>
    @include('partials.topbar')

    @include('partials.navbar')

    @include('partials.page-header', ['title' => 'Terms & Conditions'])

    <!-- Terms & Conditions Start -->
    <div class="container-fluid py-5">
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="bg-light rounded p-5 wow fadeInUp" data-wow-delay="0.1s">
                        <h2 class="text-primary mb-4">Terms & Conditions</h2>
                        <p class="text-muted mb-4">Last Updated: {{ date('F d, Y') }}</p>

                        <div class="mb-5">
                            <h4 class="text-dark mb-3"><i class="fas fa-file-contract text-primary me-2"></i>Agreement to Terms</h4>
                            <p>Welcome to Helarisi Products. These Terms and Conditions govern your use of our website and the purchase of products from our online store. By accessing our website or placing an order, you agree to be bound by these terms.</p>
                            <p>Please read these terms carefully before using our services. If you do not agree with any part of these terms, you may not access our website or use our services.</p>
                        </div>

                        <div class="mb-5">
                            <h4 class="text-dark mb-3"><i class="fas fa-shopping-cart text-primary me-2"></i>Orders and Purchases</h4>
                            <ul class="list-unstyled ps-4">
                                <li class="mb-3"><i class="fas fa-check text-primary me-2"></i><strong>Order Acceptance:</strong> All orders are subject to acceptance and availability. We reserve the right to refuse or cancel any order for any reason.</li>
                                <li class="mb-3"><i class="fas fa-check text-primary me-2"></i><strong>Pricing:</strong> All prices are displayed in the applicable currency and are subject to change without notice. Prices include applicable taxes unless otherwise stated.</li>
                                <li class="mb-3"><i class="fas fa-check text-primary me-2"></i><strong>Payment:</strong> Payment must be made at the time of purchase through our accepted payment methods. For Cash on Delivery orders, payment is due upon delivery.</li>
                                <li class="mb-3"><i class="fas fa-check text-primary me-2"></i><strong>Order Confirmation:</strong> You will receive an order confirmation email once your order has been successfully placed.</li>
                            </ul>
                        </div>

                        <div class="mb-5">
                            <h4 class="text-dark mb-3"><i class="fas fa-truck text-primary me-2"></i>Shipping and Delivery</h4>
                            <ul class="list-unstyled ps-4">
                                <li class="mb-3"><i class="fas fa-arrow-right text-primary me-2"></i><strong>Delivery Areas:</strong> We deliver to addresses within our service areas. Delivery availability will be confirmed during checkout.</li>
                                <li class="mb-3"><i class="fas fa-arrow-right text-primary me-2"></i><strong>Delivery Times:</strong> Estimated delivery times are provided at checkout but are not guaranteed. Delays may occur due to circumstances beyond our control.</li>
                                <li class="mb-3"><i class="fas fa-arrow-right text-primary me-2"></i><strong>Shipping Charges:</strong> Shipping charges are calculated based on your location and order value. Free shipping may be available for orders above a certain threshold.</li>
                                <li class="mb-3"><i class="fas fa-arrow-right text-primary me-2"></i><strong>Risk of Loss:</strong> Risk of loss and title for products pass to you upon delivery to the carrier.</li>
                            </ul>
                        </div>
<!-- 
                        <div class="mb-5">
                            <h4 class="text-dark mb-3"><i class="fas fa-undo text-primary me-2"></i>Returns and Refunds</h4>
                            <ul class="list-unstyled ps-4">
                                <li class="mb-3"><i class="fas fa-circle text-primary me-2" style="font-size: 8px;"></i><strong>Return Period:</strong> You may return eligible products within 7 days of delivery for a refund or exchange.</li>
                                <li class="mb-3"><i class="fas fa-circle text-primary me-2" style="font-size: 8px;"></i><strong>Condition:</strong> Products must be unused, in original packaging, and in the same condition as received.</li>
                                <li class="mb-3"><i class="fas fa-circle text-primary me-2" style="font-size: 8px;"></i><strong>Non-Returnable Items:</strong> Certain items such as perishable goods, personal care products, and customized items cannot be returned.</li>
                                <li class="mb-3"><i class="fas fa-circle text-primary me-2" style="font-size: 8px;"></i><strong>Refund Processing:</strong> Refunds will be processed within 7-14 business days after we receive the returned item.</li>
                                <li class="mb-3"><i class="fas fa-circle text-primary me-2" style="font-size: 8px;"></i><strong>Return Shipping:</strong> Return shipping costs are the responsibility of the customer unless the return is due to our error.</li>
                            </ul>
                        </div> -->

                        <div class="mb-5">
                            <h4 class="text-dark mb-3"><i class="fas fa-box text-primary me-2"></i>Product Information</h4>
                            <ul class="list-unstyled ps-4">
                                <li class="mb-3"><i class="fas fa-info-circle text-primary me-2"></i><strong>Accuracy:</strong> We strive to provide accurate product descriptions, images, and pricing. However, we do not warrant that product descriptions or other content is accurate, complete, or error-free.</li>
                                <li class="mb-3"><i class="fas fa-info-circle text-primary me-2"></i><strong>Availability:</strong> Product availability is subject to change without notice. We reserve the right to limit quantities.</li>
                                <li class="mb-3"><i class="fas fa-info-circle text-primary me-2"></i><strong>Colors:</strong> Product colors may vary slightly from images displayed on your screen due to monitor settings.</li>
                            </ul>
                        </div>

                        <div class="mb-5">
                            <h4 class="text-dark mb-3"><i class="fas fa-user text-primary me-2"></i>User Accounts</h4>
                            <ul class="list-unstyled ps-4">
                                <li class="mb-3"><i class="fas fa-key text-primary me-2"></i><strong>Account Security:</strong> You are responsible for maintaining the confidentiality of your account credentials and for all activities under your account.</li>
                                <li class="mb-3"><i class="fas fa-exclamation-triangle text-primary me-2"></i><strong>Accurate Information:</strong> You agree to provide accurate, current, and complete information when creating an account.</li>
                                <li class="mb-3"><i class="fas fa-ban text-primary me-2"></i><strong>Account Termination:</strong> We reserve the right to suspend or terminate accounts that violate these terms.</li>
                            </ul>
                        </div>

                        <div class="mb-5">
                            <h4 class="text-dark mb-3"><i class="fas fa-copyright text-primary me-2"></i>Intellectual Property</h4>
                            <p>All content on this website, including text, graphics, logos, images, and software, is the property of Helarisi Products or its content suppliers and is protected by copyright and trademark laws. You may not reproduce, distribute, or create derivative works without our express written permission.</p>
                        </div>

                        <div class="mb-5">
                            <h4 class="text-dark mb-3"><i class="fas fa-exclamation-circle text-primary me-2"></i>Limitation of Liability</h4>
                            <p>To the fullest extent permitted by law, Helarisi Products shall not be liable for any indirect, incidental, special, consequential, or punitive damages arising from your use of our website or products. Our total liability shall not exceed the amount you paid for the product giving rise to the claim.</p>
                        </div>

                        <div class="mb-5">
                            <h4 class="text-dark mb-3"><i class="fas fa-shield-alt text-primary me-2"></i>Indemnification</h4>
                            <p>You agree to indemnify and hold harmless Helarisi Products, its officers, directors, employees, and agents from any claims, damages, losses, or expenses arising from your use of our website or violation of these terms.</p>
                        </div>

                        <div class="mb-5">
                            <h4 class="text-dark mb-3"><i class="fas fa-ban text-primary me-2"></i>Prohibited Activities</h4>
                            <p>You agree not to:</p>
                            <ul class="list-unstyled ps-4">
                                <li class="mb-2"><i class="fas fa-times text-danger me-2"></i>Use our website for any unlawful purpose</li>
                                <li class="mb-2"><i class="fas fa-times text-danger me-2"></i>Attempt to gain unauthorized access to our systems</li>
                                <li class="mb-2"><i class="fas fa-times text-danger me-2"></i>Interfere with the proper functioning of our website</li>
                                <li class="mb-2"><i class="fas fa-times text-danger me-2"></i>Upload malicious code or harmful content</li>
                                <li class="mb-2"><i class="fas fa-times text-danger me-2"></i>Engage in fraudulent activities</li>
                                <li class="mb-2"><i class="fas fa-times text-danger me-2"></i>Violate any applicable laws or regulations</li>
                            </ul>
                        </div>

                        <div class="mb-5">
                            <h4 class="text-dark mb-3"><i class="fas fa-gavel text-primary me-2"></i>Governing Law</h4>
                            <p>These terms shall be governed by and construed in accordance with the laws of Japan. Any disputes arising from these terms or your use of our website shall be subject to the exclusive jurisdiction of the courts in Japan.</p>
                        </div>

                        <div class="mb-5">
                            <h4 class="text-dark mb-3"><i class="fas fa-edit text-primary me-2"></i>Changes to Terms</h4>
                            <p>We reserve the right to modify these terms at any time. Changes will be effective immediately upon posting on our website. Your continued use of our website after any changes indicates your acceptance of the modified terms. We encourage you to review these terms periodically.</p>
                        </div>

                        <div class="mb-4">
                            <h4 class="text-dark mb-3"><i class="fas fa-envelope text-primary me-2"></i>Contact Us</h4>
                            <p>If you have any questions about these Terms & Conditions, please contact us:</p>
                            <div class="row mt-4">
                                <div class="col-md-4 mb-3">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-envelope text-primary me-3 fa-lg"></i>
                                        <span>helarisiproducts@gmail.com</span>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-phone text-primary me-3 fa-lg"></i>
                                        <span>+81 80 4455 0579</span>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-map-marker-alt text-primary me-3 fa-lg"></i>
                                        <span>Ibaraki ken, Moriya Shi</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Terms & Conditions End -->

    @include('partials.footer')

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('lib/wow/wow.min.js') }}"></script>
    <script src="{{ asset('lib/easing/easing.min.js') }}"></script>
    <script src="{{ asset('lib/waypoints/waypoints.min.js') }}"></script>
    <script src="{{ asset('lib/owlcarousel/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('lib/counterup/counterup.min.js') }}"></script>

    <!-- Template Javascript -->
    <script src="{{ asset('Electro-Bootstrap-1.0.0/js/main.js') }}"></script>

    <!-- Initialize Template Features -->
    <script>
        new WOW().init();
    </script>
</body>
</html>
