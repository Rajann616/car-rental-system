<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="AutoLux - Premium car rental service in Ahmedabad, Gujarat. Self-drive, chauffeur, outstation & airport pickup. Maruti, Tata, Hyundai, Mahindra & more.">
    <title>@yield('title', 'AutoLux — Premium Car Rental in Ahmedabad')</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- AOS (Animate On Scroll) -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    @stack('styles')
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg fixed-top" id="mainNavbar">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <span class="brand-icon"><i class="fas fa-car-side"></i></span>
                <span class="brand-text">Auto<span class="brand-accent">Lux</span></span>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarContent">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">Home</a>
                    </li>
                    @auth
                        @if(auth()->user()->isCustomer())
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('cars.index') }}">Browse Cars</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('customer.bookings.index') }}">Bookings</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('customer.documents.index') }}">Documents</a>
                            </li>
                        @endif
                        @if(auth()->user()->isAdmin())
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.cars.index') }}">Car Mgr</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.bookings.index') }}">Reservations</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.documents.index') }}">Verifications</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.maintenance.index') }}">Maintenance</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.reports.index') }}">Reports</a>
                            </li>
                        @endif
                    @endauth
                </ul>

                <div class="navbar-actions">
                    @guest
                        <a href="{{ route('login') }}" class="btn btn-nav-outline">Sign In</a>
                        <a href="{{ route('register') }}" class="btn btn-nav-primary">Get Started</a>
                    @else
                        <div class="dropdown">
                            <button class="btn btn-nav-user dropdown-toggle" data-bs-toggle="dropdown">
                                <span class="user-avatar">
                                    <i class="fas fa-user"></i>
                                </span>
                                {{ auth()->user()->name }}
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                @if(auth()->user()->isAdmin())
                                    <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}"><i class="fas fa-tachometer-alt me-2 text-primary"></i>Admin Dashboard</a></li>
                                @else
                                    <li><a class="dropdown-item" href="{{ route('customer.dashboard') }}"><i class="fas fa-tachometer-alt me-2 text-primary"></i>Customer Dashboard</a></li>
                                @endif
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger"><i class="fas fa-sign-out-alt me-2"></i>Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @endguest
                </div>
            </div>
        </div>
    </nav>

    <!-- Flash Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show flash-alert" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show flash-alert" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="site-footer">
        <div class="footer-wave">
            <svg viewBox="0 0 1440 120" preserveAspectRatio="none">
                <path d="M0,60 C360,120 720,0 1080,60 C1260,90 1380,40 1440,60 L1440,120 L0,120 Z" fill="currentColor"></path>
            </svg>
        </div>
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="footer-brand">
                        <span class="brand-icon"><i class="fas fa-car-side"></i></span>
                        <span class="brand-text">Auto<span class="brand-accent">Lux</span></span>
                    </div>
                    <p class="footer-desc">Premium car rental service in Ahmedabad, Gujarat. Drive your dreams with our curated car of the finest vehicles India has to offer.</p>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6">
                    <h5 class="footer-heading">Quick Links</h5>
                    <ul class="footer-links">
                        <li><a href="{{ route('home') }}">Home</a></li>
                        <li><a href="{{ route('cars.index') }}">Our car</a></li>
                        <li><a href="{{ route('home') }}#services">Services</a></li>
                        <li><a href="{{ route('home') }}#about">About Us</a></li>
                        <li><a href="{{ route('home') }}#contact">Contact</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h5 class="footer-heading">Services</h5>
                    <ul class="footer-links">
                        <li><a href="#">Self-Drive Rental</a></li>
                        <li><a href="#">Chauffeur Service</a></li>
                        <li><a href="#">Outstation Trips</a></li>
                        <li><a href="#">Airport Pickup</a></li>
                        <li><a href="#">Corporate Leasing</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h5 class="footer-heading">Contact</h5>
                    <ul class="footer-contact">
                        <li>
                            <i class="fas fa-map-marker-alt"></i>
                            <span>123 SG Highway, Near Iskcon Temple, Ahmedabad, Gujarat 380015</span>
                        </li>
                        <li>
                            <i class="fas fa-phone"></i>
                            <span>+91 98765 43210</span>
                        </li>
                        <li>
                            <i class="fas fa-envelope"></i>
                            <span>info@AutoLux.in</span>
                        </li>
                        <li>
                            <i class="fas fa-clock"></i>
                            <span>Mon - Sun: 8:00 AM - 10:00 PM</span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <p>&copy; {{ date('Y') }} AutoLux. All rights reserved.</p>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <a href="#">Privacy Policy</a>
                        <span class="mx-2">•</span>
                        <a href="#">Terms of Service</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- AOS (Animate On Scroll) -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <script>
        // Initialize AOS
        AOS.init({
            duration: 800,
            easing: 'ease-out-cubic',
            once: true,
            offset: 50,
        });

        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.getElementById('mainNavbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });
    </script>

    @stack('scripts')
</body>
</html>
