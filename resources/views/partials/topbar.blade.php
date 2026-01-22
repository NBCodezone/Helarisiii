{{-- resources/views/partials/topbar.blade.php --}}
<!-- Topbar Start -->
<div class="container-fluid px-5 d-none border-bottom d-lg-block">
    <div class="row gx-0 align-items-center">
        <div class="col-lg-4 text-center text-lg-start mb-lg-0">
            <div class="d-inline-flex align-items-center" style="height: 45px;">
                {{-- <a href="{{ route('help') }}" class="text-muted me-2">Help</a><small> / </small> --}}
                {{-- <a href="{{ route('support') }}" class="text-muted mx-2">Support</a><small> / </small> --}}
                <a href="{{ route('contact') }}" class="text-muted">Contact Us</a>
            </div>
        </div>
        <div class="col-lg-4 text-center d-flex align-items-center justify-content-center">
            <small class="text-dark">Call Us:</small>
            <a href="tel:+818044550579" class="text-muted">(+81) 80 4455 0579</a>
        </div>

        <div class="col-lg-4 text-center text-lg-end">
            <div class="d-inline-flex align-items-center" style="height: 45px;">
                {{-- Currency Selection - Commented Out
                <div class="dropdown">
                    <a href="#" class="dropdown-toggle text-muted me-2" data-bs-toggle="dropdown"><small>USD</small></a>
                    <div class="dropdown-menu rounded">
                        <a href="#" class="dropdown-item">Euro</a>
                        <a href="#" class="dropdown-item">Dollar</a>
                    </div>
                </div>
                --}}
                {{-- Language Selection - Commented Out
                <div class="dropdown">
                    <a href="#" class="dropdown-toggle text-muted mx-2" data-bs-toggle="dropdown"><small>English</small></a>
                    <div class="dropdown-menu rounded">
                        <a href="#" class="dropdown-item">English</a>
                        <a href="#" class="dropdown-item">Turkish</a>
                        <a href="#" class="dropdown-item">Spanol</a>
                        <a href="#" class="dropdown-item">Italiano</a>
                    </div>
                </div>
                --}}
                @auth
                    <div class="dropdown me-3">
                        <a href="#" class="dropdown-toggle text-muted position-relative" data-bs-toggle="dropdown" id="notificationBell">
                            <small><i class="fa fa-bell"></i></small>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="notificationCount" style="display: none; font-size: 10px;">
                                0
                            </span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end rounded" style="min-width: 320px; max-height: 400px; overflow-y: auto;" id="notificationDropdown">
                            <div class="d-flex justify-content-between align-items-center px-3 py-2 border-bottom">
                                <h6 class="m-0">Notifications</h6>
                                <a href="#" class="text-primary text-decoration-none small" id="markAllRead">Mark all as read</a>
                            </div>
                            <div id="notificationList">
                                <div class="text-center py-3 text-muted">
                                    <i class="fa fa-bell-slash fa-2x mb-2"></i>
                                    <p class="mb-0">No notifications</p>
                                </div>
                            </div>
                            <div class="border-top p-2 text-center">
                                <a href="{{ route('user.notifications') }}" class="text-primary text-decoration-none small">View all notifications</a>
                            </div>
                        </div>
                    </div>
                @endauth
                <div class="dropdown">
                    @auth
                        @php
                            $dashboardRoute = 'user.dashboard';
                            if (Auth::user()->isAdmin()) {
                                $dashboardRoute = 'admin.dashboard';
                            } elseif (Auth::user()->isDeveloper()) {
                                $dashboardRoute = 'developer.dashboard';
                            } elseif (Auth::user()->role === 'stock_manager') {
                                $dashboardRoute = 'stock-manager.dashboard';
                            } elseif (Auth::user()->role === 'order_manager') {
                                $dashboardRoute = 'order-manager.dashboard';
                            }
                        @endphp
                    @endauth
                    <a href="@auth{{ route($dashboardRoute) }}@else{{ route('login') }}@endauth" class="dropdown-toggle text-muted ms-2" data-bs-toggle="dropdown">
                        <small><i class="fa fa-home me-2"></i>My Dashboard</small>
                    </a>
                    <div class="dropdown-menu rounded">
                        @guest
                            <a href="{{ route('login') }}" class="dropdown-item">Login</a>
                            <a href="{{ route('register') }}" class="dropdown-item">Register</a>
                        @else
                            <a href="{{ route('user.wishlist') }}" class="dropdown-item">Wishlist</a>
                            <a href="{{ route('cart') }}" class="dropdown-item">My Cart</a>
                            <a href="{{ route('user.notifications') }}" class="dropdown-item">Notifications</a>
                            <a href="{{ route('account.settings') }}" class="dropdown-item">Account Settings</a>
                            <a href="{{ route($dashboardRoute) }}" class="dropdown-item">My Dashboard</a>
                            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="dropdown-item">Log Out</button>
                            </form>
                        @endguest
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid px-5 py-4 d-none d-lg-block">
    <div class="row gx-0 align-items-center text-center">
        <div class="col-md-4 col-lg-3 text-center text-lg-start">
            <div class="d-inline-flex align-items-center">
                <a href="{{ route('home') }}" class="navbar-brand p-0 d-flex align-items-center">
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
                        <img src="{{ asset($logoRelPath) }}?v=1.1" alt="{{ config('app.name', 'Helarisi') }}" style="height: 46px;" />
                    @else
                        <h1 class="display-5 text-primary m-0">
                            <i class="fas fa-shopping-bag text-secondary me-2"></i>{{ config('app.name', 'Helarisi') }}
                        </h1>
                    @endif
                </a>
            </div>
        </div>
        <div class="col-md-4 col-lg-6 text-center">
            <div class="position-relative ps-4">
                <form id="site-search-form" action="{{ route('search') }}" method="GET" class="d-flex border rounded-pill search-form">
                    <input class="form-control border-0 rounded-pill w-100 py-3" type="text" name="q" 
                           placeholder="Search Looking For?" value="{{ request('q') }}">
                    <select name="category" class="form-select border-0 border-start rounded-0 p-3" style="width: 200px; color: #212529;">
                        <option value="">All Category</option>
                        @foreach($categories ?? [] as $category)
                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->category_name }}
                            </option>
                        @endforeach
                    </select>
                    <button type="submit" class="btn btn-primary rounded-pill py-3 px-5" style="border: 0;">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
                <script>
                    (function() {
                        const form = document.getElementById('site-search-form');
                        if (!form) return;
                        form.addEventListener('submit', function(e) {
                            const q = form.querySelector('input[name="q"]');
                            const category = form.querySelector('select[name="category"]');
                            const qVal = (q && q.value) ? q.value.trim() : '';
                            const catVal = category ? category.value : '';
                            // If category is the default (empty), avoid sending it to backend
                            if (category && catVal === '') {
                                category.disabled = true; // disables from being submitted
                            }
                            // Prevent fetching everything when both are empty
                            if (qVal === '' && catVal === '') {
                                e.preventDefault();
                            }
                        });
                    })();
                </script>
            </div>
        </div>
        <div class="col-md-4 col-lg-3 text-center text-lg-end">
            <div class="d-inline-flex align-items-center">
                {{-- Compare Icon - Commented Out
                <a href="{{ route('compare') }}" class="text-muted d-flex align-items-center justify-content-center me-3">
                    <span class="rounded-circle btn-md-square border"><i class="fas fa-random"></i></span>
                </a>
                --}}
                @auth
                    <a href="{{ route('user.wishlist') }}" class="text-muted d-flex align-items-center justify-content-center me-3">
                        <span class="rounded-circle btn-md-square border"><i class="fas fa-heart"></i></span>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="text-muted d-flex align-items-center justify-content-center me-3">
                        <span class="rounded-circle btn-md-square border"><i class="fas fa-heart"></i></span>
                    </a>
                @endauth
                <a href="{{ route('cart') }}" class="text-muted d-flex align-items-center justify-content-center position-relative" id="cartIcon">
                    <span class="rounded-circle btn-md-square border">
                        <i class="fas fa-shopping-cart"></i>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-primary" 
                              id="cartCountBadge" 
                              style="display: none; font-size: 10px; margin-left: -5px;">
                            0
                        </span>
                    </span>
                    <span class="text-dark ms-2" id="cartTotal">¥0</span>
                </a>
            </div>
        </div>
    </div>
</div>
<!-- Topbar End -->

@auth
<script>
    // Notification functionality
    (function() {
        function loadNotifications() {
            fetch('{{ route("user.notifications.recent") }}')
                .then(response => response.json())
                .then(data => {
                    const notificationList = document.getElementById('notificationList');
                    const notificationCount = document.getElementById('notificationCount');
                    const unreadCount = data.unread_count || 0;

                    // Update badge count
                    if (unreadCount > 0) {
                        notificationCount.textContent = unreadCount > 99 ? '99+' : unreadCount;
                        notificationCount.style.display = 'block';
                    } else {
                        notificationCount.style.display = 'none';
                    }

                    // Update notification list
                    if (data.notifications && data.notifications.length > 0) {
                        notificationList.innerHTML = '';
                        data.notifications.forEach(notification => {
                            const notifItem = document.createElement('a');
                            notifItem.href = '{{ route("user.notifications") }}';
                            notifItem.className = 'dropdown-item py-2 ' + (notification.is_read ? '' : 'bg-light');
                            notifItem.innerHTML = `
                                <div class="d-flex justify-content-between align-items-start">
                                    <div class="flex-grow-1">
                                        <strong class="d-block">${notification.title}</strong>
                                        <small class="text-muted">${notification.message.substring(0, 60)}${notification.message.length > 60 ? '...' : ''}</small>
                                        <br><small class="text-muted">${formatDate(notification.created_at)}</small>
                                    </div>
                                    ${!notification.is_read ? '<span class="badge bg-primary ms-2">New</span>' : ''}
                                </div>
                            `;
                            notificationList.appendChild(notifItem);
                        });
                    } else {
                        notificationList.innerHTML = `
                            <div class="text-center py-3 text-muted">
                                <i class="fa fa-bell-slash fa-2x mb-2"></i>
                                <p class="mb-0">No notifications</p>
                            </div>
                        `;
                    }
                })
                .catch(error => console.error('Error loading notifications:', error));
        }

        function formatDate(dateString) {
            const date = new Date(dateString);
            const now = new Date();
            const diffMs = now - date;
            const diffMins = Math.floor(diffMs / 60000);
            const diffHours = Math.floor(diffMs / 3600000);
            const diffDays = Math.floor(diffMs / 86400000);

            if (diffMins < 1) return 'Just now';
            if (diffMins < 60) return `${diffMins} min${diffMins > 1 ? 's' : ''} ago`;
            if (diffHours < 24) return `${diffHours} hour${diffHours > 1 ? 's' : ''} ago`;
            if (diffDays < 7) return `${diffDays} day${diffDays > 1 ? 's' : ''} ago`;
            return date.toLocaleDateString();
        }

        // Mark all as read
        document.getElementById('markAllRead')?.addEventListener('click', function(e) {
            e.preventDefault();
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
                    loadNotifications();
                }
            })
            .catch(error => console.error('Error:', error));
        });

        // Load notifications on page load
        loadNotifications();

        // Refresh notifications every 30 seconds
        setInterval(loadNotifications, 30000);

        // Reload when dropdown is opened
        document.getElementById('notificationBell')?.addEventListener('click', function() {
            loadNotifications();
        });
</script>
@endauth

<script>
    // Cart Summary Update Functionality
    (function() {
        function updateCartSummary() {
            fetch('{{ route("cart.summary") }}')
                .then(response => response.json())
                .then(data => {
                    const cartCountBadge = document.getElementById('cartCountBadge');
                    const cartTotal = document.getElementById('cartTotal');
                    
                    // Update count badge
                    if (data.count > 0) {
                        cartCountBadge.textContent = data.count > 99 ? '99+' : data.count;
                        cartCountBadge.style.display = 'block';
                    } else {
                        cartCountBadge.style.display = 'none';
                    }
                    
                    // Update total
                    if (cartTotal) {
                        cartTotal.textContent = data.formatted_total || '¥0';
                    }
                })
                .catch(error => console.error('Error loading cart summary:', error));
        }

        // Update cart summary on page load
        updateCartSummary();

        // Listen for cart update events (when items are added/removed)
        document.addEventListener('cartUpdated', function() {
            updateCartSummary();
        });

        // Also update when the page becomes visible again
        document.addEventListener('visibilitychange', function() {
            if (!document.hidden) {
                updateCartSummary();
            }
        });
    })();
</script>

