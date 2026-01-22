<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }} - Scheduled Maintenance</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500;600&family=Rubik:wght@500;600;700&display=swap" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css">

    <!-- Libraries -->
    <link rel="stylesheet" href="{{ asset('lib/animate/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('lib/owlcarousel/assets/owl.carousel.min.css') }}">

    <!-- Bootstrap / Theme -->
    <link rel="stylesheet" href="{{ asset('Electro-Bootstrap-1.0.0/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('Electro-Bootstrap-1.0.0/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom.css?v=1.1') }}">
</head>
<body>
    @include('partials.topbar')
    @include('partials.navbar')

    <section class="py-5" style="background: linear-gradient(135deg, #fef6f2 0%, #fff 60%); min-height: 70vh;">
        <div class="container py-5">
            <div class="row g-5 align-items-center">
                <div class="col-lg-6">
                    <div class="position-relative rounded-4 shadow-lg bg-white p-4 overflow-hidden">
                        <div class="ratio ratio-4x3 rounded-3 bg-light d-flex align-items-center justify-content-center">
                            <svg width="140" height="140" viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect x="20" y="60" width="160" height="80" rx="16" fill="#FFE3D3"/>
                                <rect x="35" y="40" width="130" height="90" rx="16" fill="#FFD0B3"/>
                                <path d="M60 120L100 70L140 120" stroke="#FF8A4C" stroke-width="10" stroke-linecap="round" stroke-linejoin="round"/>
                                <circle cx="60" cy="120" r="8" fill="#FF8A4C"/>
                                <circle cx="140" cy="120" r="8" fill="#FF8A4C"/>
                                <rect x="90" y="125" width="20" height="20" rx="4" fill="#FF8A4C"/>
                            </svg>
                        </div>
                        <div class="mt-4">
                            <p class="text-muted small mb-2"><i class="fa fa-clock me-2 text-warning"></i>Next check-in</p>
                            <div class="d-flex align-items-center gap-3">
                                <div>
                                    <h4 class="fw-bold mb-0" style="font-family: 'Rubik', sans-serif;">{{ optional($setting->maintenance_enabled_at)->format('M d, Y') ?? now()->format('M d, Y') }}</h4>
                                    <p class="text-muted small mb-0">Maintenance since</p>
                                </div>
                                <div class="vr"></div>
                                <div>
                                    <h4 class="fw-bold mb-0 text-primary" style="font-family: 'Rubik', sans-serif;">{{ config('app.name') }}</h4>
                                    <p class="text-muted small mb-0">Digital storefront</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <span class="badge rounded-pill text-bg-warning text-uppercase mb-3 px-3 py-2">
                        <i class="fa fa-tools me-2"></i> Scheduled Maintenance
                    </span>
                    <h1 class="display-5 fw-bold" style="font-family: 'Rubik', sans-serif;">We're polishing the shop floor.</h1>
                    <p class="lead text-muted mt-3">
                        {{ $setting->maintenance_message ?? "Our storefront is temporarily offline while we deploy the latest improvements. We appreciate your patience and can't wait to welcome you back." }}
                    </p>
                    <div class="d-flex flex-column flex-sm-row gap-3 mt-4">
                        <a href="{{ route('contact') }}" class="btn btn-primary rounded-pill px-4 py-2">
                            <i class="fa fa-headset me-2"></i>Contact Support
                        </a>
                        @if (Route::has('login'))
                            <a href="{{ route('login') }}" class="btn btn-outline-secondary rounded-pill px-4 py-2">
                                <i class="fa fa-user-lock me-2"></i>Developer Login
                            </a>
                        @endif
                    </div>
                    <p class="text-muted small mt-4">
                        @php($supportEmail = config('mail.from.address') ?? 'support@example.com')
                        Need urgent help? Email us at <a href="mailto:{{ $supportEmail }}" class="text-decoration-none">{{ $supportEmail }}</a>
                    </p>
                </div>
            </div>
        </div>
    </section>

    @include('partials.footer')

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('lib/wow/wow.min.js') }}"></script>
    <script src="{{ asset('lib/easing/easing.min.js') }}"></script>
    <script src="{{ asset('lib/waypoints/waypoints.min.js') }}"></script>
    <script src="{{ asset('lib/owlcarousel/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('Electro-Bootstrap-1.0.0/js/main.js') }}"></script>
</body>
</html>
