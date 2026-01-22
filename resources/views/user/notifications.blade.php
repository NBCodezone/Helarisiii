<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Notifications - {{ config('app.name', 'Laravel') }}</title>

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

    @include('partials.page-header', ['title' => 'Notifications'])

    <!-- Notifications Start -->
    <div class="container-fluid py-5">
        <div class="container py-5">
            <div class="row">
                <div class="col-lg-12">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h3 class="mb-0">My Notifications</h3>
                        @if($notifications->where('is_read', false)->count() > 0)
                            <button class="btn btn-primary btn-sm" id="markAllReadBtn">
                                <i class="fas fa-check-double me-2"></i>Mark All as Read
                            </button>
                        @endif
                    </div>

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if($notifications->count() > 0)
                        <div class="list-group mb-4">
                            @foreach($notifications as $notification)
                                <div class="list-group-item {{ !$notification->is_read ? 'border-start border-primary border-4' : '' }}" data-notification-id="{{ $notification->id }}">
                                    <div class="d-flex w-100 justify-content-between align-items-start">
                                        <div class="flex-grow-1">
                                            <div class="d-flex align-items-center mb-2">
                                                <span class="badge {{ $notification->type == 'order_delivered' ? 'bg-success' : ($notification->type == 'order_cancelled' ? 'bg-danger' : 'bg-primary') }} me-2">
                                                    @switch($notification->type)
                                                        @case('order_placed')
                                                            <i class="fas fa-shopping-cart me-1"></i>Order Placed
                                                            @break
                                                        @case('order_approved')
                                                            <i class="fas fa-check-circle me-1"></i>Approved
                                                            @break
                                                        @case('order_processing')
                                                            <i class="fas fa-cog me-1"></i>Processing
                                                            @break
                                                        @case('order_shipped')
                                                            <i class="fas fa-shipping-fast me-1"></i>Shipped
                                                            @break
                                                        @case('order_delivered')
                                                            <i class="fas fa-check-double me-1"></i>Delivered
                                                            @break
                                                        @case('order_cancelled')
                                                            <i class="fas fa-times-circle me-1"></i>Cancelled
                                                            @break
                                                        @default
                                                            <i class="fas fa-bell me-1"></i>Notification
                                                    @endswitch
                                                </span>
                                                <h5 class="mb-0">{{ $notification->title }}</h5>
                                                @if(!$notification->is_read)
                                                    <span class="badge bg-danger ms-2">New</span>
                                                @endif
                                            </div>
                                            <p class="mb-2">{{ $notification->message }}</p>
                                            <small class="text-muted">
                                                <i class="far fa-clock me-1"></i>
                                                {{ $notification->created_at->diffForHumans() }}
                                            </small>
                                        </div>
                                        <div class="ms-3">
                                            @if(!$notification->is_read)
                                                <button class="btn btn-sm btn-outline-primary mark-read-btn" data-id="{{ $notification->id }}">
                                                    <i class="fas fa-check"></i> Mark as Read
                                                </button>
                                            @endif
                                            <button class="btn btn-sm btn-outline-danger delete-notification-btn ms-1" data-id="{{ $notification->id }}">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center">
                            {{ $notifications->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-bell-slash fa-4x text-muted mb-3"></i>
                            <h4>No Notifications</h4>
                            <p class="text-muted">You don't have any notifications yet.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!-- Notifications End -->

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

        // Mark notification as read
        document.querySelectorAll('.mark-read-btn').forEach(button => {
            button.addEventListener('click', function() {
                const notificationId = this.dataset.id;
                markAsRead(notificationId);
            });
        });

        // Mark all as read
        document.getElementById('markAllReadBtn')?.addEventListener('click', function() {
            fetch('{{ route("user.notifications.markAllRead") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                }
            })
            .catch(error => console.error('Error:', error));
        });

        // Delete notification
        document.querySelectorAll('.delete-notification-btn').forEach(button => {
            button.addEventListener('click', function() {
                if (confirm('Are you sure you want to delete this notification?')) {
                    const notificationId = this.dataset.id;
                    fetch(`/user/notifications/${notificationId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            const item = document.querySelector(`[data-notification-id="${notificationId}"]`);
                            item.remove();

                            // Check if no more notifications
                            if (document.querySelectorAll('.list-group-item').length === 0) {
                                location.reload();
                            }
                        }
                    })
                    .catch(error => console.error('Error:', error));
                }
            });
        });

        function markAsRead(notificationId) {
            fetch(`/user/notifications/${notificationId}/read`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                }
            })
            .catch(error => console.error('Error:', error));
        }
    </script>
</body>
</html>
