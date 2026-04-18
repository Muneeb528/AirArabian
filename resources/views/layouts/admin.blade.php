<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel') — AirArabian</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
    @stack('styles')
</head>
<body class="admin-body">

<div class="admin-wrapper">
    <!-- Sidebar -->
    <aside class="admin-sidebar" id="adminSidebar">
        <div class="sidebar-header">
            <a href="{{ route('admin.dashboard') }}" class="sidebar-brand">
                <i class="fas fa-plane me-2"></i>Air<span class="gold-text">Arabian</span>
            </a>
            <button class="sidebar-toggle d-lg-none" id="sidebarToggle">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <div class="sidebar-user">
            <div class="user-avatar"><i class="fas fa-user-shield"></i></div>
            <div>
                <div class="user-name">{{ auth()->user()->name }}</div>
                <div class="user-role">Administrator</div>
            </div>
        </div>

        <nav class="sidebar-nav">
            <div class="nav-section-title">Main Menu</div>
            <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fas fa-tachometer-alt"></i><span>Dashboard</span>
            </a>

            <div class="nav-section-title mt-3">Management</div>
            <a href="{{ route('admin.tickets.index') }}" class="sidebar-link {{ request()->routeIs('admin.tickets.*') ? 'active' : '' }}">
                <i class="fas fa-ticket-alt"></i><span>Tickets</span>
                <span class="badge bg-primary ms-auto">{{ \App\Models\Ticket::where('status','available')->count() }}</span>
            </a>
            <a href="{{ route('admin.vendors.index') }}" class="sidebar-link {{ request()->routeIs('admin.vendors.*') ? 'active' : '' }}">
                <i class="fas fa-users-cog"></i><span>Vendors</span>
                @if($pendingVendorCount = \App\Models\Vendor::where('status','pending')->count())
                    <span class="badge bg-warning ms-auto">{{ $pendingVendorCount }}</span>
                @endif
            </a>
            <a href="{{ route('admin.bookings.index') }}" class="sidebar-link {{ request()->routeIs('admin.bookings.*') ? 'active' : '' }}">
                <i class="fas fa-book-open"></i><span>Bookings</span>
            </a>
            <a href="{{ route('admin.payments.index') }}" class="sidebar-link {{ request()->routeIs('admin.payments.*') ? 'active' : '' }}">
                <i class="fas fa-credit-card"></i><span>Payments</span>
                @if($pendingPaymentCount = \App\Models\Payment::where('status','pending')->count())
                    <span class="badge bg-danger ms-auto">{{ $pendingPaymentCount }}</span>
                @endif
            </a>
            <a href="{{ route('admin.bank-accounts.index') }}" class="sidebar-link {{ request()->routeIs('admin.bank-accounts.*') ? 'active' : '' }}">
                <i class="fas fa-university"></i><span>Bank Accounts</span>
            </a>

            <div class="nav-section-title mt-3">Account</div>
            <a href="{{ route('home') }}" class="sidebar-link" target="_blank">
                <i class="fas fa-globe"></i><span>View Website</span>
            </a>
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit" class="sidebar-link w-100 text-start border-0 bg-transparent">
                    <i class="fas fa-sign-out-alt"></i><span>Logout</span>
                </button>
            </form>
        </nav>
    </aside>

    <!-- Main Content -->
    <div class="admin-main">
        <!-- Top Bar -->
        <header class="admin-topbar">
            <button class="sidebar-toggle-btn" id="mobileSidebarToggle">
                <i class="fas fa-bars"></i>
            </button>
            <div class="topbar-title">@yield('page-title', 'Dashboard')</div>
            <div class="topbar-actions ms-auto">
                <span class="text-muted small">{{ now()->format('D, d M Y') }}</span>
            </div>
        </header>

        <!-- Page Content -->
        <div class="admin-content">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </div>
</div>

<!-- Sidebar Overlay -->
<div class="sidebar-overlay" id="sidebarOverlay"></div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/app.js') }}"></script>
@stack('scripts')
</body>
</html>