<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }} - Order Success</title>

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
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
</head>
<body>
    @include('partials.topbar')

    @include('partials.navbar')

    @include('partials.page-header', ['title' => 'Order Success'])

    <!-- Order Success Section Start -->
    <div class="container-fluid py-5">
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="text-center mb-5">
                        <div class="mb-4">
                            <i class="fas fa-check-circle text-success" style="font-size: 80px;"></i>
                        </div>
                        <h1 class="mb-3">Order Placed Successfully!</h1>
                        <p class="lead">Thank you for your order. Your order has been received and is being processed.</p>
                    </div>

                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-primary text-white">
                            <h4 class="mb-0">Order Details</h4>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <p><strong>Order ID:</strong> #{{ $order->id }}</p>
                                    <p><strong>Order Date:</strong> {{ $order->created_at->format('M d, Y h:i A') }}</p>
                                    <p><strong>Payment Method:</strong>
                                        @if($order->payment_method === 'bank_transfer')
                                            <span class="badge bg-info">Bank Transfer</span>
                                        @else
                                            <span class="badge bg-warning">Cash on Delivery</span>
                                        @endif
                                    </p>
                                    <p><strong>Status:</strong>
                                        <span class="badge bg-secondary">{{ ucfirst($order->status) }}</span>
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Subtotal:</strong> ¥{{ number_format($order->subtotal, 0) }}</p>
                                    @if($order->discount_amount > 0)
                                    <p><strong><i class="fas fa-tag text-success"></i> Product Discounts:</strong> <span class="text-success">-¥{{ number_format($order->discount_amount, 0) }}</span></p>
                                    @endif
                                    <p><strong>Tax (8%):</strong> ¥{{ number_format($order->tax_amount, 0) }}</p>
                                    <p><strong>Delivery Charge:</strong> ¥{{ number_format($order->delivery_charge, 0) }}</p>
                                    @if($order->frozen_charge > 0)
                                    <p><strong>Frozen Item Charge:</strong> ¥{{ number_format($order->frozen_charge, 0) }}</p>
                                    @endif
                                    <p class="mt-2 pt-2 border-top"><strong>Total Amount:</strong> <span class="text-primary fs-5">¥{{ number_format($order->total_amount, 0) }}</span></p>
                                </div>
                            </div>

                            <!-- Delivery Schedule Section -->
                            @if($order->delivery_date || $order->delivery_time_slot)
                            <div class="row mb-3 mt-3 pt-3 border-top">
                                <div class="col-12">
                                    <h6 class="mb-3"><i class="fas fa-truck text-primary me-2"></i>Delivery Schedule</h6>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Preferred Date:</strong> 
                                        <span class="badge bg-info fs-6">
                                            {{ $order->delivery_date ? $order->delivery_date->format('D, M d, Y') : 'Not specified' }}
                                        </span>
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Time Slot:</strong> 
                                        <span class="badge bg-success fs-6">
                                            @php
                                                $timeSlots = [
                                                    '8-12' => '8:00 AM - 12:00 PM',
                                                    '12-14' => '12:00 PM - 2:00 PM',
                                                    '14-16' => '2:00 PM - 4:00 PM',
                                                    '16-18' => '4:00 PM - 6:00 PM',
                                                    '18-20' => '6:00 PM - 8:00 PM',
                                                    '19-21' => '7:00 PM - 9:00 PM',
                                                ];
                                            @endphp
                                            {{ $timeSlots[$order->delivery_time_slot] ?? $order->delivery_time_slot ?? 'Not specified' }}
                                        </span>
                                    </p>
                                </div>
                            </div>
                            @endif

                            @if($order->payment_method === 'bank_transfer')
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i>
                                <strong>Important:</strong> Your order will be processed once the admin verifies your payment receipt.
                                You will be notified once your order is approved.
                            </div>
                            @endif
                        </div>
                    </div>

                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">Billing Information</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>Name:</strong> {{ $order->first_name }} {{ $order->last_name }}</p>
                                    <p><strong>Email:</strong> {{ $order->email }}</p>
                                    <p><strong>Mobile:</strong> {{ $order->mobile_number }}</p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Region:</strong> {{ $order->region->region_name }}</p>
                                    <p><strong>Ken:</strong> {{ $order->ken_name }}</p>
                                    <p><strong>Address:</strong> {{ $order->apartment }}</p>
                                    <p><strong>Postal Code:</strong> {{ $order->postal_code }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">Order Items</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Product</th>
                                            <th>Price</th>
                                            <th>Quantity</th>
                                            <th>Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($order->items as $item)
                                        <tr>
                                            <td>
                                                {{ $item->product->product_name }}
                                                @if($item->discount_percentage > 0)
                                                    <span class="badge bg-danger ms-2">-{{ $item->discount_percentage }}%</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($item->discount_percentage > 0 && $item->original_price)
                                                    <span style="text-decoration: line-through; color: #999; font-size: 0.85rem;">¥{{ number_format($item->original_price, 0) }}</span><br>
                                                    <span class="text-success fw-bold">¥{{ number_format($item->price, 0) }}</span>
                                                @else
                                                    ¥{{ number_format($item->price, 0) }}
                                                @endif
                                            </td>
                                            <td>{{ $item->quantity }}</td>
                                            <td>¥{{ number_format($item->subtotal, 0) }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    @if(session('whatsapp_notification_link'))
                    <div class="alert alert-success text-center mb-4">
                        <i class="fab fa-whatsapp fa-2x text-success mb-2"></i>
                        <h5>Send Order Details to Admin</h5>
                        <p class="mb-3">Click the button below to notify the admin via WhatsApp</p>
                        <a href="{{ session('whatsapp_notification_link') }}"
                           target="_blank"
                           class="btn btn-success btn-lg"
                           id="whatsapp-notify-btn">
                            <i class="fab fa-whatsapp me-2"></i>Notify Admin on WhatsApp
                        </a>
                    </div>
                    @endif

                    <div class="text-center">
                        <a href="{{ route('order.invoice.download', $order->id) }}" class="btn btn-success btn-lg me-2 mb-2">
                            <i class="fas fa-download me-2"></i>Download Invoice
                        </a>
                        <a href="{{ route('home') }}" class="btn btn-primary btn-lg me-2 mb-2">
                            <i class="fas fa-home me-2"></i>Continue Shopping
                        </a>
                        <a href="{{ route('order.history') }}" class="btn btn-outline-primary btn-lg mb-2">
                            <i class="fas fa-history me-2"></i>View Order History
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Order Success Section End -->

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

        // Auto-trigger WhatsApp notification for admin
        @if(session('whatsapp_notification_link'))
        (function() {
            console.log('WhatsApp notification script loaded');
            const whatsappBtn = document.getElementById('whatsapp-notify-btn');

            if (whatsappBtn) {
                // Wait for page to fully load
                setTimeout(function() {
                    console.log('Auto-clicking WhatsApp button');
                    // Simulate click on the button
                    whatsappBtn.click();

                    // Highlight the button to show it was clicked
                    whatsappBtn.style.animation = 'pulse 0.5s';
                    setTimeout(() => {
                        whatsappBtn.style.animation = '';
                    }, 500);
                }, 1500); // Wait 1.5 seconds for page to fully render
            } else {
                console.error('WhatsApp button not found');
            }
        })();
        @endif
    </script>

    <style>
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
    </style>
</body>
</html>
