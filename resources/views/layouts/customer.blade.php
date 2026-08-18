<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="AutoLux - Premium Car Rental Application Dashboard">
    <title>@yield('title', 'Customer Portal — AutoLux Car Rental')</title>

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

    <!-- Custom CSS with Cache Buster -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}?v={{ file_exists(public_path('css/app.css')) ? filemtime(public_path('css/app.css')) : time() }}">

    @stack('styles')
</head>
<body class="customer-app-body">

    <div class="customer-app-wrapper" id="appWrapper">
        
        <!-- Left Collapsible Sidebar (Desktop & Tablet) -->
        <aside class="customer-sidebar shadow-sm" id="customerSidebar">
            <div class="sidebar-header d-flex align-items-center justify-content-between">
                <a class="sidebar-brand d-flex align-items-center gap-2 text-decoration-none" href="{{ route('home') }}">
                    <span class="brand-icon"><i class="fas fa-car-side"></i></span>
                    <span class="brand-text sidebar-label">Auto<span class="brand-accent">Lux</span></span>
                </a>
                <button type="button" class="btn btn-sm btn-icon-toggle d-none d-lg-flex" id="sidebarCollapseBtn" title="Toggle Sidebar">
                    <i class="fas fa-angles-left"></i>
                </button>
            </div>

            <div class="sidebar-content">
                <div class="sidebar-group">
                    <div class="sidebar-group-title sidebar-label">MAIN</div>
                    <ul class="sidebar-nav">
                        <li class="sidebar-item">
                            <a href="{{ route('customer.dashboard') }}" class="sidebar-link {{ request()->routeIs('customer.dashboard') ? 'active' : '' }}" data-bs-toggle="tooltip" data-bs-placement="right" title="Dashboard">
                                <i class="fas fa-house sidebar-icon"></i>
                                <span class="sidebar-label">Dashboard</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{ route('cars.index') }}" class="sidebar-link {{ request()->routeIs('cars.*') ? 'active' : '' }}" data-bs-toggle="tooltip" data-bs-placement="right" title="Browse Cars">
                                <i class="fas fa-car sidebar-icon"></i>
                                <span class="sidebar-label">Browse Cars</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{ route('customer.bookings.index') }}" class="sidebar-link {{ request()->routeIs('customer.bookings.*') || request()->routeIs('bookings.*') ? 'active' : '' }}" data-bs-toggle="tooltip" data-bs-placement="right" title="Bookings">
                                <i class="fas fa-clipboard-list sidebar-icon"></i>
                                <span class="sidebar-label">Bookings</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{ route('customer.documents.index') }}" class="sidebar-link {{ request()->routeIs('customer.documents.*') ? 'active' : '' }}" data-bs-toggle="tooltip" data-bs-placement="right" title="Documents">
                                <i class="fas fa-id-card sidebar-icon"></i>
                                <span class="sidebar-label">Documents</span>
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="sidebar-group mt-4">
                    <div class="sidebar-group-title sidebar-label">ACCOUNT</div>
                    <ul class="sidebar-nav">
                        <li class="sidebar-item">
                            <a href="{{ route('customer.dashboard') }}#profile" class="sidebar-link" data-bs-toggle="tooltip" data-bs-placement="right" title="Profile">
                                <i class="fas fa-user-gear sidebar-icon"></i>
                                <span class="sidebar-label">Profile & Verification</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="sidebar-footer">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="sidebar-link text-danger border-0 bg-transparent w-100 text-start" data-bs-toggle="tooltip" data-bs-placement="right" title="Logout">
                        <i class="fas fa-arrow-right-from-bracket sidebar-icon"></i>
                        <span class="sidebar-label">Logout</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Offcanvas Mobile Sidebar Drawer (<= 767px) -->
        <div class="offcanvas offcanvas-start mobile-sidebar-drawer" tabindex="-1" id="mobileSidebarDrawer" aria-labelledby="mobileSidebarDrawerLabel">
            <div class="offcanvas-header border-bottom">
                <a class="d-flex align-items-center gap-2 text-decoration-none" id="mobileSidebarDrawerLabel" href="{{ route('home') }}">
                    <span class="brand-icon"><i class="fas fa-car-side"></i></span>
                    <span class="brand-text fs-4">Auto<span class="brand-accent">Lux</span></span>
                </a>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body p-0 d-flex flex-column justify-content-between">
                <div class="p-3">
                    <div class="text-muted small fw-bold text-uppercase mb-2">MAIN</div>
                    <ul class="nav flex-column gap-1 mb-4">
                        <li class="nav-item">
                            <a href="{{ route('customer.dashboard') }}" class="nav-link rounded-3 py-2 px-3 {{ request()->routeIs('customer.dashboard') ? 'bg-primary text-white font-weight-bold' : 'text-dark' }}">
                                <i class="fas fa-house me-2"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('cars.index') }}" class="nav-link rounded-3 py-2 px-3 {{ request()->routeIs('cars.*') ? 'bg-primary text-white font-weight-bold' : 'text-dark' }}">
                                <i class="fas fa-car me-2"></i> Browse Cars
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('customer.bookings.index') }}" class="nav-link rounded-3 py-2 px-3 {{ request()->routeIs('customer.bookings.*') || request()->routeIs('bookings.*') ? 'bg-primary text-white font-weight-bold' : 'text-dark' }}">
                                <i class="fas fa-clipboard-list me-2"></i> Bookings
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('customer.documents.index') }}" class="nav-link rounded-3 py-2 px-3 {{ request()->routeIs('customer.documents.*') ? 'bg-primary text-white font-weight-bold' : 'text-dark' }}">
                                <i class="fas fa-id-card me-2"></i> Documents
                            </a>
                        </li>
                    </ul>

                    <div class="text-muted small fw-bold text-uppercase mb-2">ACCOUNT</div>
                    <ul class="nav flex-column gap-1">
                        <li class="nav-item">
                            <a href="{{ route('customer.dashboard') }}#profile" class="nav-link rounded-3 py-2 px-3 text-dark">
                                <i class="fas fa-user-gear me-2"></i> Profile & Verification
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="p-3 border-top bg-light">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger w-100 rounded-3">
                            <i class="fas fa-arrow-right-from-bracket me-2"></i> Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Main Page Container (Header + Body + Footer) -->
        <div class="customer-main-wrapper">
            
            <!-- Simplified Top Header Bar -->
            <header class="customer-top-header border-bottom sticky-top bg-white" id="customerTopHeader">
                <div class="container-fluid px-3 px-md-4 h-100 d-flex align-items-center justify-content-between">
                    
                    <!-- Left: Mobile/Sidebar Toggle + Breadcrumb -->
                    <div class="d-flex align-items-center gap-3">
                        <!-- Mobile Drawer Trigger Button -->
                        <button type="button" class="btn btn-light d-lg-none rounded-3 border-0" data-bs-toggle="offcanvas" data-bs-target="#mobileSidebarDrawer" aria-controls="mobileSidebarDrawer" aria-label="Open navigation menu">
                            <i class="fas fa-bars fs-5 text-dark"></i>
                        </button>

                        <!-- Page Context Title Only (AutoLux logo is in sidebar) -->
                        <h5 class="fw-bold mb-0 text-dark font-display fs-5">
                            @yield('page_title', 'Customer Portal')
                        </h5>
                    </div>

                    <!-- Right: Notification Bell & User Profile Dropdown -->
                    <div class="d-flex align-items-center gap-2">
                        @auth
                            <!-- Notification Bell -->
                            @php
                                $unreadCount = auth()->user()->unreadNotifications->count();
                                $dbNotifications = auth()->user()->notifications()->latest()->take(8)->get();
                            @endphp
                            <div class="dropdown">
                                <button class="btn btn-light rounded-circle position-relative p-2" data-bs-toggle="dropdown" aria-expanded="false" id="notificationBell" aria-label="View notifications">
                                    <i class="fas fa-bell fs-5 text-muted"></i>
                                    @if($unreadCount > 0)
                                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.6rem;">
                                            {{ $unreadCount }}
                                        </span>
                                    @endif
                                </button>
                                <div class="dropdown-menu dropdown-menu-end notification-dropdown p-0 shadow-lg border-0 rounded-3" style="width: 340px; max-height: 420px; overflow-y: auto;">
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

                            <!-- User Profile Dropdown -->
                            <div class="dropdown">
                                <button class="btn btn-outline-light border text-dark dropdown-toggle rounded-pill px-3 py-1 d-flex align-items-center gap-2" data-bs-toggle="dropdown">
                                    <span class="user-avatar-sm" style="width: 28px; height: 28px; background: linear-gradient(135deg, #ff7a00, #ea580c); border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; color: #fff; font-size: 0.75rem; font-weight: 700;">
                                        {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                                    </span>
                                    <span class="fw-semibold small d-none d-sm-inline">{{ auth()->user()->name }}</span>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 rounded-3">
                                    <li>
                                        <div class="px-3 py-2 border-bottom">
                                            <div class="fw-bold text-dark small">{{ auth()->user()->name }}</div>
                                            <div class="text-muted small" style="font-size: 0.75rem;">{{ auth()->user()->email }}</div>
                                        </div>
                                    </li>
                                    <li>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="dropdown-item py-2 small text-danger"><i class="fas fa-arrow-right-from-bracket me-2"></i> Logout</button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3 fw-semibold">Sign In</a>
                            <a href="{{ route('register') }}" class="btn btn-sm btn-primary rounded-pill px-3 fw-semibold" style="background: linear-gradient(135deg, #ff7a00, #ea580c); border: none;">Get Started</a>
                        @endauth
                    </div>
                </div>
            </header>

            <!-- Toast Flash Messages -->
            <div class="toast-container position-fixed bottom-0 end-0 p-4" style="z-index: 1090;">
                @if(session('success'))
                    <div class="toast align-items-center text-white bg-dark border-0 show shadow-lg rounded-4 p-2 mb-2" role="alert">
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
                            <button type="button" class="btn-close btn-close-white me-3 ms-auto" data-bs-dismiss="toast"></button>
                        </div>
                    </div>
                @endif
                @if(session('error'))
                    <div class="toast align-items-center text-white bg-dark border-0 show shadow-lg rounded-4 p-2 mb-2" role="alert">
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
                            <button type="button" class="btn-close btn-close-white me-3 ms-auto" data-bs-dismiss="toast"></button>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Application Main Content Area -->
            <main class="customer-content-area">
                @yield('content')
            </main>

            <!-- Customer App Footer -->
            <footer class="customer-app-footer py-3 px-4 border-top bg-white text-muted small">
                <div class="d-flex flex-column flex-sm-row align-items-center justify-content-between gap-2">
                    <div>&copy; {{ date('Y') }} AutoLux Car Rental. All rights reserved.</div>
                    <div class="d-flex gap-3">
                        <a href="{{ route('home') }}" class="text-muted text-decoration-none">Home</a>
                        <a href="{{ route('cars.index') }}" class="text-muted text-decoration-none">Cars</a>
                        <a href="{{ route('customer.documents.index') }}" class="text-muted text-decoration-none">Documents</a>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({ duration: 600, easing: 'ease-out-cubic', once: true, offset: 40 });

        // Sidebar Collapse Logic with LocalStorage persistence
        document.addEventListener("DOMContentLoaded", function () {
            const appWrapper = document.getElementById('appWrapper');
            const collapseBtn = document.getElementById('sidebarCollapseBtn');
            const headerToggleBtn = document.getElementById('desktopHeaderSidebarToggle');
            const isCollapsed = localStorage.getItem('autolux_sidebar_collapsed') === 'true';

            if (isCollapsed && appWrapper) {
                appWrapper.classList.add('sidebar-collapsed');
            }

            function toggleSidebar() {
                if (appWrapper) {
                    appWrapper.classList.toggle('sidebar-collapsed');
                    const currentState = appWrapper.classList.contains('sidebar-collapsed');
                    localStorage.setItem('autolux_sidebar_collapsed', currentState);
                }
            }

            if (collapseBtn) collapseBtn.addEventListener('click', toggleSidebar);
            if (headerToggleBtn) headerToggleBtn.addEventListener('click', toggleSidebar);

            // Initialize Bootstrap Tooltips for collapsed sidebar links
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });

            // Smooth hash anchor navigation (#profile, #assistance)
            function scrollToHash() {
                if (window.location.hash) {
                    const target = document.querySelector(window.location.hash);
                    if (target) {
                        setTimeout(() => {
                            target.scrollIntoView({ behavior: 'smooth', block: 'center' });
                            target.style.boxShadow = '0 0 20px rgba(37, 99, 235, 0.4)';
                            target.style.border = '2px solid #2563eb';
                            setTimeout(() => {
                                target.style.boxShadow = '';
                                target.style.border = '';
                            }, 2000);
                        }, 150);
                    }
                }
            }

            scrollToHash();
            window.addEventListener('hashchange', scrollToHash);
        });
    </script>
    @stack('scripts')
</body>
</html>
