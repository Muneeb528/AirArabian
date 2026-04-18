<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="AirArabian - Your trusted airline ticketing partner for UAE, KSA, Umrah, and Tour packages">
    <meta name="keywords" content="airline tickets, UAE flights, KSA flights, Umrah packages, tour packages">
    <title>@yield('title', 'AirArabian - Premium Airline Ticketing')</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @stack('styles')
</head>
<body>

<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="mainNav">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('home') }}">
            <div class="brand-icon">
                <i class="fas fa-plane"></i>
            </div>
            <span class="brand-name">Air<span class="gold-text">Arabian</span></span>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center gap-1">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                        <i class="fas fa-home me-1"></i>Home
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}#tickets">
                        <i class="fas fa-ticket-alt me-1"></i>Flights
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}?category=Umrah">
                        <i class="fas fa-kaaba me-1"></i>Umrah
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}?category=Tour">
                        <i class="fas fa-globe me-1"></i>Tours
                    </a>
                </li>
                <li class="nav-item ms-2">
                    <a class="btn btn-gold" href="{{ route('vendor.inquiry') }}">
                        <i class="fas fa-handshake me-1"></i>Become a Vendor
                    </a>
                </li>
                <li class="nav-item">
                    <a class="btn btn-outline-gold ms-1" href="{{ route('vendor.login') }}">
                        <i class="fas fa-user me-1"></i>Vendor Login
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Main Content -->
<main>
    @if(session('success'))
        <div class="alert-floating alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert-floating alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @yield('content')
</main>

<!-- Footer -->
<footer class="site-footer">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-4">
                <div class="footer-brand mb-3">
                    <i class="fas fa-plane me-2 gold-text"></i>
                    <span class="brand-name">Air<span class="gold-text">Arabian</span></span>
                </div>
                <p class="text-muted">Your premium airline ticketing partner for UAE, KSA, Umrah, and world tour packages. Trusted by thousands of travelers.</p>
                <div class="social-links mt-3">
                    <a href="#" class="social-link"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="social-link"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="social-link"><i class="fab fa-whatsapp"></i></a>
                </div>
            </div>
            <div class="col-lg-2 col-sm-6">
                <h6 class="footer-heading">Destinations</h6>
                <ul class="footer-links">
                    <li><a href="{{ route('home') }}?category=UAE">UAE Flights</a></li>
                    <li><a href="{{ route('home') }}?category=KSA">KSA Flights</a></li>
                    <li><a href="{{ route('home') }}?category=Umrah">Umrah Packages</a></li>
                    <li><a href="{{ route('home') }}?category=Tour">Tour Packages</a></li>
                </ul>
            </div>
            <div class="col-lg-2 col-sm-6">
                <h6 class="footer-heading">Company</h6>
                <ul class="footer-links">
                    <li><a href="#">About Us</a></li>
                    <li><a href="{{ route('vendor.inquiry') }}">Become a Vendor</a></li>
                    <li><a href="#">Contact Us</a></li>
                    <li><a href="{{ route('admin.login') }}">Admin</a></li>
                </ul>
            </div>
            <div class="col-lg-4">
                <h6 class="footer-heading">Contact Info</h6>
                <ul class="footer-links">
                    <li><i class="fas fa-envelope me-2 gold-text"></i>info@airarbian.com</li>
                    <li><i class="fas fa-phone me-2 gold-text"></i>+92 300 0000000</li>
                    <li><i class="fas fa-map-marker-alt me-2 gold-text"></i>Karachi, Pakistan</li>
                </ul>
                <div class="payment-badges mt-3">
                    <span class="payment-badge">JazzCash</span>
                    <span class="payment-badge">EasyPaisa</span>
                </div>
            </div>
        </div>
        <hr class="footer-divider">
        <div class="d-flex flex-wrap justify-content-between align-items-center">
            <p class="text-muted mb-0">&copy; {{ date('Y') }} AirArabian. All rights reserved.</p>
            <p class="text-muted mb-0">Built with <i class="fas fa-heart gold-text"></i> for Premium Travel</p>
        </div>
    </div>
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/app.js') }}"></script>
@stack('scripts')
</body>
</html>
