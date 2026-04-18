<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Vendor Portal') — Travel Portal</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('css/vendor-portal.css') }}" rel="stylesheet">
    @stack('styles')
</head>
<body class="vp-body">

<div class="vp-wrapper">
    <!-- Sidebar -->
    <aside class="vp-sidebar" id="vpSidebar">
        <div class="vp-sidebar-header">
            @php $logo = \App\Models\Setting::get('logo'); @endphp
            @if($logo)
                <img src="{{ asset('storage/'.$logo) }}" alt="Logo" class="vp-logo-img">
            @else
                <div class="vp-brand">
                    <i class="fas fa-paper-plane"></i>
                    <span>Travel<strong>Portal</strong></span>
                </div>
            @endif
        </div>

        <div class="vp-user-card">
            <div class="vp-user-avatar">
                <i class="fas fa-store"></i>
            </div>
            <div class="vp-user-info">
                <div class="vp-user-name">{{ auth()->user()->vendor->company_name ?? auth()->user()->name }}</div>
                <div class="vp-user-role">Vendor Portal</div>
            </div>
        </div>

        <nav class="vp-nav">
            <div class="vp-nav-label">Main Menu</div>

            <a href="{{ route('vendor.dashboard') }}"
               class="vp-nav-link {{ request()->routeIs('vendor.dashboard') ? 'active' : '' }}">
                <i class="fas fa-th-large"></i><span>Dashboard</span>
            </a>

            <a href="{{ route('vendor.bookings.new') }}"
               class="vp-nav-link {{ request()->routeIs('vendor.bookings.new','vendor.bookings.create') ? 'active' : '' }}">
                <i class="fas fa-plus-circle"></i><span>New Booking</span>
            </a>

            <a href="{{ route('vendor.bookings.index') }}"
               class="vp-nav-link {{ request()->routeIs('vendor.bookings.index','vendor.bookings.show') ? 'active' : '' }}">
                <i class="fas fa-ticket-alt"></i><span>My Ticket Bookings</span>
            </a>

            <div class="vp-nav-label mt-3">Finance</div>

            <a href="{{ route('vendor.bank-accounts') }}"
               class="vp-nav-link {{ request()->routeIs('vendor.bank-accounts') ? 'active' : '' }}">
                <i class="fas fa-university"></i><span>Bank Accounts</span>
            </a>

            <div class="vp-nav-label mt-3">Account</div>

            <a href="{{ route('vendor.settings') }}"
               class="vp-nav-link {{ request()->routeIs('vendor.settings') ? 'active' : '' }}">
                <i class="fas fa-cog"></i><span>Settings</span>
            </a>

            <form method="POST" action="{{ route('vendor.logout') }}" class="mt-2">
                @csrf
                <button type="submit" class="vp-nav-link w-100 text-start border-0 bg-transparent">
                    <i class="fas fa-sign-out-alt"></i><span>Logout</span>
                </button>
            </form>
        </nav>
    </aside>

    <!-- Main Content -->
    <div class="vp-main">
        <header class="vp-topbar">
            <button class="vp-toggle-btn" id="vpToggle">
                <i class="fas fa-bars"></i>
            </button>
            <div class="vp-topbar-title">@yield('page-title', 'Vendor Portal')</div>
            <div class="vp-topbar-right">
                <span class="vp-date">{{ now()->format('D, d M Y') }}</span>
                <div class="vp-topbar-vendor">
                    <i class="fas fa-store me-1"></i>
                    {{ auth()->user()->vendor->company_name ?? auth()->user()->name }}
                </div>
            </div>
        </header>

        <div class="vp-content">
            @if(session('success'))
                <div class="vp-alert vp-alert-success">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                    <button class="vp-alert-close" onclick="this.parentElement.remove()">&times;</button>
                </div>
            @endif
            @if(session('error'))
                <div class="vp-alert vp-alert-error">
                    <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                    <button class="vp-alert-close" onclick="this.parentElement.remove()">&times;</button>
                </div>
            @endif

            @yield('content')
        </div>
    </div>
</div>

<div class="vp-overlay" id="vpOverlay"></div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.getElementById('vpToggle').addEventListener('click', function() {
    document.getElementById('vpSidebar').classList.toggle('open');
    document.getElementById('vpOverlay').classList.toggle('show');
});
document.getElementById('vpOverlay').addEventListener('click', function() {
    document.getElementById('vpSidebar').classList.remove('open');
    this.classList.remove('show');
});
</script>
@stack('scripts')
</body>
</html>
