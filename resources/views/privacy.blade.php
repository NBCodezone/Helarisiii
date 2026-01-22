<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Privacy Policy - {{ config('app.name', 'Laravel') }}</title>

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

    @include('partials.page-header', ['title' => 'Privacy Policy'])

    <!-- Privacy Policy Start -->
    <div class="container-fluid py-5">
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="bg-light rounded p-5 wow fadeInUp" data-wow-delay="0.1s">
                        <h2 class="text-primary mb-4">Privacy Policy</h2>
                        <p class="text-muted mb-4">Last Updated: {{ date('F d, Y') }}</p>

                        <div class="mb-5">
                            <h4 class="text-dark mb-3"><i class="fas fa-info-circle text-primary me-2"></i>Introduction</h4>
                            <p>Welcome to Helarisi Products. We are committed to protecting your personal information and your right to privacy. This Privacy Policy explains how we collect, use, disclose, and safeguard your information when you visit our website or make a purchase from us.</p>
                            <p>Please read this privacy policy carefully. If you do not agree with the terms of this privacy policy, please do not access the site.</p>
                        </div>

                        <div class="mb-5">
                            <h4 class="text-dark mb-3"><i class="fas fa-database text-primary me-2"></i>Information We Collect</h4>
                            <p>We collect information that you provide directly to us, including:</p>
                            <ul class="list-unstyled ps-4">
                                <li class="mb-2"><i class="fas fa-check text-primary me-2"></i><strong>Personal Information:</strong> Name, email address, phone number, shipping address, and billing address.</li>
                                <li class="mb-2"><i class="fas fa-check text-primary me-2"></i><strong>Payment Information:</strong> Payment method details (processed securely through our payment providers).</li>
                                <li class="mb-2"><i class="fas fa-check text-primary me-2"></i><strong>Order Information:</strong> Products purchased, order history, and delivery preferences.</li>
                                <li class="mb-2"><i class="fas fa-check text-primary me-2"></i><strong>Account Information:</strong> Username, password, and account preferences.</li>
                                <li class="mb-2"><i class="fas fa-check text-primary me-2"></i><strong>Communication Data:</strong> Messages and inquiries you send to us.</li>
                            </ul>
                        </div>

                        <div class="mb-5">
                            <h4 class="text-dark mb-3"><i class="fas fa-cogs text-primary me-2"></i>How We Use Your Information</h4>
                            <p>We use the information we collect for various purposes, including:</p>
                            <ul class="list-unstyled ps-4">
                                <li class="mb-2"><i class="fas fa-arrow-right text-primary me-2"></i>Processing and fulfilling your orders</li>
                                <li class="mb-2"><i class="fas fa-arrow-right text-primary me-2"></i>Sending order confirmations and shipping updates</li>
                                <li class="mb-2"><i class="fas fa-arrow-right text-primary me-2"></i>Responding to your inquiries and customer service requests</li>
                                <li class="mb-2"><i class="fas fa-arrow-right text-primary me-2"></i>Improving our website and services</li>
                                <li class="mb-2"><i class="fas fa-arrow-right text-primary me-2"></i>Sending promotional communications (with your consent)</li>
                                <li class="mb-2"><i class="fas fa-arrow-right text-primary me-2"></i>Preventing fraudulent transactions and protecting against illegal activity</li>
                            </ul>
                        </div>

                        <div class="mb-5">
                            <h4 class="text-dark mb-3"><i class="fas fa-share-alt text-primary me-2"></i>Information Sharing</h4>
                            <p>We may share your information with:</p>
                            <ul class="list-unstyled ps-4">
                                <li class="mb-2"><i class="fas fa-truck text-primary me-2"></i><strong>Shipping Partners:</strong> To deliver your orders.</li>
                                <li class="mb-2"><i class="fas fa-credit-card text-primary me-2"></i><strong>Payment Processors:</strong> To process your payments securely.</li>
                                <li class="mb-2"><i class="fas fa-gavel text-primary me-2"></i><strong>Legal Requirements:</strong> When required by law or to protect our rights.</li>
                            </ul>
                            <p class="mt-3">We do not sell, trade, or rent your personal information to third parties for marketing purposes.</p>
                        </div>

                        <div class="mb-5">
                            <h4 class="text-dark mb-3"><i class="fas fa-cookie text-primary me-2"></i>Cookies and Tracking</h4>
                            <p>We use cookies and similar tracking technologies to enhance your browsing experience. Cookies help us:</p>
                            <ul class="list-unstyled ps-4">
                                <li class="mb-2"><i class="fas fa-check-circle text-primary me-2"></i>Remember your preferences and settings</li>
                                <li class="mb-2"><i class="fas fa-check-circle text-primary me-2"></i>Keep items in your shopping cart</li>
                                <li class="mb-2"><i class="fas fa-check-circle text-primary me-2"></i>Analyze site traffic and usage patterns</li>
                                <li class="mb-2"><i class="fas fa-check-circle text-primary me-2"></i>Improve our website functionality</li>
                            </ul>
                            <p>You can control cookies through your browser settings.</p>
                        </div>

                        <div class="mb-5">
                            <h4 class="text-dark mb-3"><i class="fas fa-shield-alt text-primary me-2"></i>Data Security</h4>
                            <p>We implement appropriate technical and organizational security measures to protect your personal information against unauthorized access, alteration, disclosure, or destruction. However, no method of transmission over the Internet is 100% secure, and we cannot guarantee absolute security.</p>
                        </div>

                        <div class="mb-5">
                            <h4 class="text-dark mb-3"><i class="fas fa-user-shield text-primary me-2"></i>Your Rights</h4>
                            <p>You have the right to:</p>
                            <ul class="list-unstyled ps-4">
                                <li class="mb-2"><i class="fas fa-eye text-primary me-2"></i>Access your personal information</li>
                                <li class="mb-2"><i class="fas fa-edit text-primary me-2"></i>Correct inaccurate data</li>
                                <li class="mb-2"><i class="fas fa-trash text-primary me-2"></i>Request deletion of your data</li>
                                <li class="mb-2"><i class="fas fa-ban text-primary me-2"></i>Opt-out of marketing communications</li>
                                <li class="mb-2"><i class="fas fa-download text-primary me-2"></i>Request a copy of your data</li>
                            </ul>
                        </div>

                        <div class="mb-5">
                            <h4 class="text-dark mb-3"><i class="fas fa-child text-primary me-2"></i>Children's Privacy</h4>
                            <p>Our website is not intended for children under 16 years of age. We do not knowingly collect personal information from children under 16. If you are a parent or guardian and believe your child has provided us with personal information, please contact us.</p>
                        </div>

                        <div class="mb-5">
                            <h4 class="text-dark mb-3"><i class="fas fa-sync-alt text-primary me-2"></i>Changes to This Policy</h4>
                            <p>We may update this privacy policy from time to time. We will notify you of any changes by posting the new privacy policy on this page and updating the "Last Updated" date. We encourage you to review this policy periodically.</p>
                        </div>

                        <div class="mb-4">
                            <h4 class="text-dark mb-3"><i class="fas fa-envelope text-primary me-2"></i>Contact Us</h4>
                            <p>If you have any questions about this Privacy Policy, please contact us:</p>
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
    <!-- Privacy Policy End -->

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
