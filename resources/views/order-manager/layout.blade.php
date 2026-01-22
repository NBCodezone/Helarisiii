<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Manager Dashboard - @yield('title')</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        :root {
            --primary-color: #16a34a; /* emerald-600 */
            --secondary-color: #065f46; /* emerald-900 */
            --dark-color: #1e1e2f;
            --light-color: #f8f9fa;
            --sidebar-width: 250px;
            --sidebar-collapsed-width: 80px;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--light-color);
            overflow-x: hidden;
        }

        /* Sidebar */
        .sidebar {
            width: var(--sidebar-width);
            background: linear-gradient(180deg, var(--primary-color) 0%, #15803d 100%);
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            padding-top: 20px;
            transition: all 0.3s ease;
            box-shadow: 2px 0 8px rgba(0, 0, 0, 0.1);
            z-index: 1030;
        }

        .sidebar.collapsed {
            width: var(--sidebar-collapsed-width);
        }

        .sidebar .brand {
            text-align: center;
            color: #fff;
            font-weight: 700;
            font-size: 1.2rem;
            margin-bottom: 20px;
            white-space: nowrap;
        }

        .sidebar .nav-link {
            color: #fff;
            font-weight: 500;
            padding: 12px 20px;
            margin: 4px 10px;
            border-radius: 10px;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
        }

        .sidebar .nav-link i {
            width: 24px;
            text-align: center;
            margin-right: 10px;
            font-size: 1.1rem;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background-color: rgba(255, 255, 255, 0.25);
            transform: translateX(4px);
        }

        .sidebar.collapsed .nav-link span {
            display: none;
        }

        .sidebar.collapsed .brand span {
            display: none;
        }

        /* Main content */
        .main-content {
            margin-left: var(--sidebar-width);
            padding: 20px;
            transition: all 0.3s ease;
        }

        .sidebar.collapsed ~ .main-content {
            margin-left: var(--sidebar-collapsed-width);
        }

        /* Navbar */
        .navbar {
            background: #fff;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            position: sticky;
            top: 0;
            z-index: 1020;
        }

        .toggle-btn {
            background: transparent;
            border: none;
            color: var(--dark-color);
            font-size: 1.4rem;
            cursor: pointer;
        }

        .badge-admin {
            background: var(--primary-color);
            color: var(--dark-color);
            border-radius: 20px;
            padding: 6px 14px;
            font-weight: 600;
        }

        .card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.05);
        }

        .card-header {
            background: #fff;
            border-bottom: 3px solid var(--primary-color);
            font-weight: 600;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="brand">
            <i class="fas fa-leaf"></i> <span>Admin Panel</span>
        </div>
        <nav class="nav flex-column mt-4">
            <a class="nav-link {{ request()->routeIs('order-manager.dashboard') ? 'active' : '' }}" href="{{ route('order-manager.dashboard') }}">
                <i class="fas fa-home"></i> <span>Dashboard</span>
            </a>
            <a class="nav-link {{ request()->routeIs('order-manager.orders*') ? 'active' : '' }}" href="{{ route('order-manager.orders') }}">
                <i class="fas fa-shopping-cart"></i> <span>Orders</span>
            </a>
            <a class="nav-link {{ request()->routeIs('order-manager.regions.*') ? 'active' : '' }}" href="{{ route('order-manager.regions.index') }}">
                <i class="fas fa-map-marked-alt"></i> <span>Regions</span>
            </a>
            <a class="nav-link {{ request()->routeIs('order-manager.delivery-charges.*') ? 'active' : '' }}" href="{{ route('order-manager.delivery-charges.index') }}">
                <i class="fas fa-yen-sign"></i> <span>Delivery Charges</span>
            </a>

            <hr class="text-white mx-3">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="nav-link border-0 bg-transparent text-start w-100">
                    <i class="fas fa-sign-out-alt"></i> <span>Logout</span>
                </button>
            </form>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <nav class="navbar navbar-expand-lg mb-4">
            <button class="toggle-btn me-3" id="toggleSidebar">
                <i class="fas fa-bars"></i>
            </button>
            <span class="navbar-brand fw-semibold">@yield('page-title', 'Dashboard')</span>

            <div class="ms-auto d-flex align-items-center">
                <span class="badge-admin me-2">
                    <i class="fas fa-user-shield"></i> {{ Auth::user()->name }}
                </span>
            </div>
        </nav>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
                <button class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                <button class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const toggleBtn = document.getElementById('toggleSidebar');
        const sidebar = document.getElementById('sidebar');

        toggleBtn.addEventListener('click', () => {
            sidebar.classList.toggle('collapsed');
            document.querySelector('.main-content').classList.toggle('collapsed');
        });
    </script>

    @yield('scripts')
</body>
</html>
