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
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- AOS (Animate On Scroll) -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <!-- ApexCharts for Modern Analytics -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    @stack('styles')
</head>
<body class="@yield('body_class')">
    <!-- Navbar (Hidden on Auth Pages to Prevent Header Duplication) -->
    @if(!request()->routeIs('login') && !request()->routeIs('register'))
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

                        @auth
                            @if(auth()->user()->isCustomer())
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('customer.dashboard') ? 'active' : '' }}" href="{{ route('customer.dashboard') }}"><i class="fas fa-house me-1 text-primary"></i> Dashboard</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('cars.*') ? 'active' : '' }}" href="{{ route('cars.index') }}">Browse Cars</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('customer.bookings.*') ? 'active' : '' }}" href="{{ route('customer.bookings.index') }}">Bookings</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('customer.documents.*') ? 'active' : '' }}" href="{{ route('customer.documents.index') }}">Documents</a>
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
                            <button type="button" class="btn btn-nav-outline" data-bs-toggle="modal" data-bs-target="#authModal" onclick="switchAuthTab('login')">Sign In</button>
                            <button type="button" class="btn btn-nav-primary" data-bs-toggle="modal" data-bs-target="#authModal" onclick="switchAuthTab('register')">Get Started</button>
                        @else
                            <!-- Notification Bell -->
                            @php
                                $unreadCount = auth()->user()->unreadNotifications->count();
                                $dbNotifications = auth()->user()->notifications()->latest()->take(8)->get();
                            @endphp
                            <div class="dropdown me-2">
                                <button class="btn btn-nav-notification position-relative" data-bs-toggle="dropdown" aria-expanded="false" id="notificationBell">
                                    <i class="fas fa-bell fs-5"></i>
                                    @if($unreadCount > 0)
                                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.6rem;">
                                            {{ $unreadCount }}
                                        </span>
                                    @endif
                                </button>
                                <div class="dropdown-menu dropdown-menu-end notification-dropdown p-0 shadow-lg border-0 rounded-3" style="width: 350px; max-height: 420px; overflow-y: auto;">
                                    <div class="p-3 border-bottom bg-light rounded-top d-flex align-items-center justify-content-between">
                                        <div>
                                            <h6 class="fw-bold mb-0 text-dark"><i class="fas fa-bell me-1 text-primary"></i> Notifications</h6>
                                            <small class="text-muted" style="font-size: 0.72rem;">You have {{ $unreadCount }} unread notification{{ $unreadCount === 1 ? '' : 's' }}</small>
                                        </div>
                                        @if($unreadCount > 0)
                                            <form action="{{ route('notifications.readAll') }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-link text-decoration-none text-primary p-0 fw-semibold" style="font-size: 0.75rem;">
                                                    Mark all read
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                    <div class="notification-list">
                                        @forelse($dbNotifications as $notif)
                                            @php
                                                $data = $notif->data;
                                                $isUnread = is_null($notif->read_at);
                                            @endphp
                                            <form action="{{ route('notifications.read', $notif->id) }}" method="POST" id="read_notif_{{ $notif->id }}" class="d-none">
                                                @csrf
                                            </form>
                                            <div class="p-3 border-bottom notification-item cursor-pointer {{ $isUnread ? 'bg-primary-subtle bg-opacity-10' : '' }}" 
                                                 onclick="event.preventDefault(); document.getElementById('read_notif_{{ $notif->id }}').submit();">
                                                <div class="d-flex align-items-start gap-2">
                                                    <div class="rounded-circle p-2 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 32px; height: 32px; background: rgba(37, 99, 235, 0.1);">
                                                        <i class="fas {{ $data['icon'] ?? 'fa-info-circle' }} {{ $data['color'] ?? 'text-primary' }} fs-6"></i>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                                            <span class="fw-bold text-dark small">{{ $data['title'] ?? 'Notification' }}</span>
                                                            @if($isUnread)
                                                                <span class="badge bg-primary rounded-circle p-1" style="width: 6px; height: 6px;" title="Unread"></span>
                                                            @endif
                                                        </div>
                                                        <div class="text-muted small leading-tight mb-1" style="font-size: 0.78rem;">
                                                            {{ $data['message'] ?? '' }}
                                                        </div>
                                                        @php
                                                            $replyEmail = $data['reply_email'] ?? null;
                                                            if (!$replyEmail && preg_match('/[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}/', $data['message'] ?? '', $matches)) {
                                                                $replyEmail = $matches[0];
                                                            }
                                                        @endphp
                                                        @if($replyEmail)
                                                            <div class="mt-1 pt-1 d-flex justify-content-start align-items-center">
                                                                <a href="mailto:{{ $replyEmail }}?subject=Re: {{ rawurlencode($data['title'] ?? 'AutoLux Inquiry') }}" 
                                                                    class="btn btn-sm btn-outline-primary rounded-pill py-0 px-2 small text-decoration-none" style="font-size: 0.7rem;" 
                                                                    onclick="event.stopPropagation();">
                                                                    <i class="fas fa-reply me-1"></i> Reply to {{ $replyEmail }}
                                                                </a>
                                                            </div>
                                                        @endif
                                                        <div class="text-muted text-end" style="font-size: 0.68rem;">
                                                            {{ $notif->created_at->diffForHumans() }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @empty
                                            <div class="p-4 text-center text-muted small">
                                                <i class="fas fa-bell-slash d-block fs-4 mb-2 text-secondary opacity-50"></i>
                                                No notifications yet
                                            </div>
                                        @endforelse
                                    </div>
                                </div>
                            </div>

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
    @endif

    <!-- Animated Floating Toast Notifications System -->
    <div class="toast-container position-fixed bottom-0 end-0 p-4" style="z-index: 1090;">
        @if(session('success'))
            <div class="toast align-items-center text-white bg-dark border-0 show shadow-lg rounded-4 p-2 mb-2" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex align-items-center">
                    <div class="toast-body d-flex align-items-center gap-3">
                        <div class="rounded-circle bg-success bg-opacity-25 p-2 d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                            <i class="fas fa-check-circle text-success fs-5"></i>
                        </div>
                        <div>
                            <div class="fw-bold text-white small">Action Successful</div>
                            <div class="text-white-50 small">{{ session('success') }}</div>
                        </div>
                    </div>
                    <button type="button" class="btn-close btn-close-white me-3 ms-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="toast align-items-center text-white bg-dark border-0 show shadow-lg rounded-4 p-2 mb-2" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex align-items-center">
                    <div class="toast-body d-flex align-items-center gap-3">
                        <div class="rounded-circle bg-danger bg-opacity-25 p-2 d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                            <i class="fas fa-exclamation-circle text-danger fs-5"></i>
                        </div>
                        <div>
                            <div class="fw-bold text-white small">System Notice</div>
                            <div class="text-white-50 small">{{ session('error') }}</div>
                        </div>
                    </div>
                    <button type="button" class="btn-close btn-close-white me-3 ms-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        @endif
    </div>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="site-footer">
        <div class="container">
            <div class="row g-4 justify-content-between">
                <div class="col-lg-4 col-md-6">
                    <div class="footer-brand mb-3">
                        <span class="brand-icon"><i class="fas fa-car-side"></i></span>
                        <span class="brand-text text-white ms-2">Auto<span class="brand-accent">Lux</span></span>
                    </div>
                    <p class="footer-desc text-white-50">India's premier location-based car rental platform. Online booking with instant doorstep delivery across Ahmedabad and Gujarat.</p>
                    <div class="social-links mt-3">
                        <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                        <a href="#" aria-label="Twitter"><i class="fab fa-x-twitter"></i></a>
                        <a href="#" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6">
                    <h5 class="footer-heading">Quick Links</h5>
                    <ul class="footer-links">
                        <li><a href="{{ route('home') }}">Home</a></li>
                        <li><a href="{{ route('cars.index') }}">Browse Cars</a></li>
                        <li><a href="{{ route('home') }}#services">How It Works</a></li>
                        <li><a href="{{ route('home') }}#faq">FAQ</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h5 class="footer-heading">Car Rental Hub</h5>
                    <ul class="footer-links">
                        <li><a href="{{ route('cars.index') }}">Self-Drive Delivery</a></li>
                        <li><a href="{{ route('cars.index') }}">Airport Transfer</a></li>
                        <li><a href="{{ route('cars.index') }}">Outstation Trips</a></li>
                        <li><a href="{{ route('cars.index') }}">Luxury & SUV Rental</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h5 class="footer-heading">Support & Contact</h5>
                    <ul class="footer-contact">
                        <li>
                            <i class="fas fa-location-dot"></i>
                            <span>SG Highway, Near Iskcon Cross Road, Ahmedabad, GJ 380015</span>
                        </li>
                        <li>
                            <i class="fas fa-phone"></i>
                            <span>+91 98765 43210</span>
                        </li>
                        <li>
                            <i class="fas fa-envelope"></i>
                            <span>support@autolux.in</span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom mt-5">
                <div class="row align-items-center">
                    <div class="col-md-6 text-center text-md-start">
                        <p class="mb-0 text-white-50">&copy; {{ date('Y') }} AutoLux Rental Platform. All rights reserved.</p>
                    </div>
                    <div class="col-md-6 text-center text-md-end mt-2 mt-md-0">
                        <a href="#" class="text-white-50 text-decoration-none me-3">Privacy Policy</a>
                        <a href="#" class="text-white-50 text-decoration-none">Terms & Conditions</a>
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

    <!-- Three.js, OrbitControls & GLTFLoader -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/three@0.128.0/examples/js/controls/OrbitControls.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/three@0.128.0/examples/js/loaders/GLTFLoader.js"></script>

    @guest
        @include('partials.auth_modals')
    @endguest

    @stack('scripts')
</body>
</html>
