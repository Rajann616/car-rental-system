@extends('layouts.customer')

@section('title', 'Customer Dashboard — AutoLux')
@section('page_title', 'Dashboard')

@push('styles')
<style>
    /* Liquid Glass Aesthetic Theme */
    .dashboard-hero-card {
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.14) 0%, rgba(255, 255, 255, 0.03) 100%),
                    linear-gradient(125deg, #071322 0%, #0c2547 45%, #143b73 100%);
        backdrop-filter: blur(24px) saturate(190%);
        -webkit-backdrop-filter: blur(24px) saturate(190%);
        border: 1px solid rgba(255, 255, 255, 0.22);
        border-radius: 1.5rem;
        box-shadow: 0 30px 60px -15px rgba(3, 10, 22, 0.65), 
                    inset 0 1px 1px rgba(255, 255, 255, 0.4),
                    inset 0 -1px 1px rgba(0, 0, 0, 0.3);
        position: relative;
        overflow: hidden;
    }
    
    /* Top Specular Gloss Highlight Shine */
    .dashboard-hero-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 1px;
        background: linear-gradient(90deg, 
            rgba(255, 255, 255, 0) 0%, 
            rgba(255, 255, 255, 0.5) 25%, 
            rgba(255, 255, 255, 0.95) 50%, 
            rgba(255, 255, 255, 0.5) 75%, 
            rgba(255, 255, 255, 0) 100%);
        z-index: 4;
    }

    /* Morphing Fluid Liquid Orbs */
    .hero-glow-1 {
        width: 320px;
        height: 320px;
        background: radial-gradient(circle, rgba(255, 122, 0, 0.35) 0%, rgba(245, 158, 11, 0.15) 50%, rgba(0,0,0,0) 75%);
        top: -90px;
        right: -70px;
        filter: blur(50px);
        animation: liquidMorph 12s infinite ease-in-out alternate;
    }
    .hero-glow-2 {
        width: 280px;
        height: 280px;
        background: radial-gradient(circle, rgba(37, 99, 235, 0.4) 0%, rgba(56, 189, 248, 0.15) 50%, rgba(0,0,0,0) 75%);
        bottom: -70px;
        left: 20%;
        filter: blur(45px);
        animation: liquidMorph 15s infinite ease-in-out alternate-reverse;
    }
    .hero-glow-3 {
        width: 220px;
        height: 220px;
        background: radial-gradient(circle, rgba(168, 85, 247, 0.3) 0%, rgba(236, 72, 153, 0.1) 60%, rgba(0,0,0,0) 80%);
        top: 20%;
        left: 45%;
        filter: blur(40px);
        animation: liquidMorph 18s infinite ease-in-out alternate;
    }

    @keyframes liquidMorph {
        0% { border-radius: 60% 40% 30% 70% / 60% 30% 70% 40%; transform: rotate(0deg) translate(0, 0); }
        50% { border-radius: 30% 60% 70% 30% / 50% 60% 30% 60%; transform: rotate(180deg) translate(20px, -15px); }
        100% { border-radius: 60% 40% 30% 70% / 60% 30% 70% 40%; transform: rotate(360deg) translate(-10px, 15px); }
    }

    /* Liquid Glass Badges */
    .liquid-badge {
        background: rgba(255, 255, 255, 0.08);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15), inset 0 1px 1px rgba(255, 255, 255, 0.3);
        color: #ffffff;
        transition: all 0.3s ease;
    }
    .liquid-badge:hover {
        background: rgba(255, 255, 255, 0.16);
        border-color: rgba(255, 255, 255, 0.35);
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.25), inset 0 1px 1px rgba(255, 255, 255, 0.5);
        transform: translateY(-2px);
    }

    /* Liquid Glass Buttons */
    .btn-liquid-primary {
        background: linear-gradient(135deg, #ff7a00 0%, #ea580c 50%, #d97706 100%);
        border: 1px solid rgba(255, 255, 255, 0.35);
        box-shadow: 0 10px 25px -4px rgba(255, 122, 0, 0.5), inset 0 1px 1px rgba(255, 255, 255, 0.45);
        color: #ffffff;
        position: relative;
        overflow: hidden;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .btn-liquid-primary:hover {
        transform: translateY(-3px) scale(1.02);
        box-shadow: 0 16px 32px -4px rgba(255, 122, 0, 0.65), inset 0 1px 1px rgba(255, 255, 255, 0.6);
        color: #ffffff;
    }
    
    .btn-liquid-glass {
        background: rgba(255, 255, 255, 0.12);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.3);
        box-shadow: 0 10px 25px -4px rgba(0, 0, 0, 0.25), inset 0 1px 1px rgba(255, 255, 255, 0.35);
        color: #ffffff;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .btn-liquid-glass:hover {
        background: rgba(255, 255, 255, 0.22);
        border-color: rgba(255, 255, 255, 0.5);
        box-shadow: 0 14px 28px -4px rgba(0, 0, 0, 0.35), inset 0 1px 1px rgba(255, 255, 255, 0.6);
        transform: translateY(-3px) scale(1.02);
        color: #ffffff;
    }

    .stat-card-modern {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 1.25rem;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .stat-card-modern:hover {
        transform: translateY(-4px);
        box-shadow: 0 16px 32px -8px rgba(15, 23, 42, 0.08);
        border-color: #cbd5e1;
    }
    .stat-icon-wrapper {
        width: 52px;
        height: 52px;
        border-radius: 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.35rem;
    }
    .car-card-hover {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border: 1px solid #e2e8f0;
    }
    .car-card-hover:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 30px -10px rgba(0, 0, 0, 0.08);
        border-color: #ff7a00;
    }
    .car-card-hover:hover .car-img-zoom {
        transform: scale(1.06);
    }
    .car-img-zoom {
        transition: transform 0.4s ease;
    }
    .quick-filter-chip {
        padding: 0.45rem 1.1rem;
        border-radius: 50rem;
        font-size: 0.825rem;
        font-weight: 600;
        color: #475569;
        background: #f1f5f9;
        border: 1px solid #e2e8f0;
        transition: all 0.2s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
    }
    .quick-filter-chip:hover, .quick-filter-chip.active {
        background: linear-gradient(135deg, #ff7a00, #ea580c);
        color: #ffffff;
        border-color: transparent;
        box-shadow: 0 4px 12px rgba(255, 122, 0, 0.25);
    }
    .pulse-online-dot {
        width: 9px;
        height: 9px;
        background-color: #10b981;
        border-radius: 50%;
        display: inline-block;
        box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7);
        animation: pulse-dot 1.8s infinite;
    }
    @keyframes pulse-dot {
        0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7); }
        70% { transform: scale(1); box-shadow: 0 0 0 8px rgba(16, 185, 129, 0); }
        100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
    }
</style>
@endpush

@section('content')
<section class="dashboard-section pb-5">
    <div class="container">
        
        <!-- Welcome Hero Banner Card (Compact Liquid Glass 3-Column Layout) -->
        <div class="mb-4" data-aos="fade-down">
            <div class="dashboard-hero-card p-3 p-md-4 rounded-4 text-white">
                
                <!-- Fluid Morphing Liquid Orbs -->
                <div class="position-absolute rounded-circle hero-glow-1 pointer-events-none"></div>
                <div class="position-absolute rounded-circle hero-glow-2 pointer-events-none"></div>
                <div class="position-absolute rounded-circle hero-glow-3 pointer-events-none"></div>

                <div class="row align-items-center g-3 position-relative" style="z-index: 2;">
                    
                    <!-- Left: User Greeting & Badges -->
                    <div class="col-xl-5 col-lg-5">
                        <div class="d-flex align-items-center gap-3">
                            <div class="user-avatar-large flex-shrink-0" style="width: 54px; height: 54px; background: linear-gradient(135deg, #ff7a00, #ea580c); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.4rem; font-weight: 800; color: #fff; border: 2px solid rgba(255,255,255,0.4); box-shadow: 0 8px 20px rgba(255,122,0,0.4), inset 0 1px 1px rgba(255,255,255,0.6);">
                                {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                            </div>
                            <div>
                                <div class="d-flex align-items-center gap-2 flex-wrap">
                                    <h3 class="fw-bold mb-0 text-white font-display fs-4">
                                        <span id="timeGreeting">Welcome</span>, {{ auth()->user()->name }}! 👋
                                    </h3>
                                    @if(auth()->user()->hasApprovedDocuments())
                                        <span class="liquid-badge rounded-pill px-2 py-0.5 fs-7 fw-semibold text-success border-success border-opacity-50">
                                            <i class="fas fa-check-circle me-1"></i> Verified
                                        </span>
                                    @else
                                        <span class="liquid-badge rounded-pill px-2 py-0.5 fs-7 fw-semibold text-warning border-warning border-opacity-50">
                                            <i class="fas fa-exclamation-triangle me-1"></i> Action Needed
                                        </span>
                                    @endif
                                </div>
                                <p class="text-white-50 mb-0 small mt-1">
                                    <i class="fas fa-map-marker-alt me-1 text-warning"></i> Serving Gujarat Hub (Ahmedabad) &nbsp;|&nbsp; Member since {{ auth()->user()->created_at->format('M Y') }}
                                </p>
                            </div>
                        </div>

                        <div class="d-flex flex-wrap gap-2 mt-3">
                            <span class="liquid-badge rounded-pill px-3 py-1 fs-7 font-monospace">
                                <i class="fas fa-bolt text-warning me-1"></i> Instant Self-Drive Pickup
                            </span>
                        </div>
                    </div>

                    <!-- Middle: Live Liquid Quick Stats -->
                    <div class="col-xl-4 col-lg-4">
                        <div class="row g-2">
                            <div class="col-6">
                                <div class="liquid-badge p-3 rounded-4 h-100 d-flex flex-column justify-content-between">
                                    <div class="d-flex align-items-center justify-content-between text-white-50 fs-7 mb-1">
                                        <span>Active Rental</span>
                                        <i class="fas fa-car-side text-warning"></i>
                                    </div>
                                    <div class="fw-bold fs-5 text-white">
                                        {{ $activeBookings->count() > 0 ? $activeBookings->count() . ' Active' : '0 Active' }}
                                    </div>
                                    <div class="fs-7 text-white-50 mt-1">
                                        {{ $activeBookings->count() > 0 ? 'Vehicle in use' : 'Ready for trip' }}
                                    </div>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="liquid-badge p-3 rounded-4 h-100 d-flex flex-column justify-content-between">
                                    <div class="d-flex align-items-center justify-content-between text-white-50 fs-7 mb-1">
                                        <span>ID Status</span>
                                        <i class="fas fa-id-card text-info"></i>
                                    </div>
                                    <div class="fw-bold fs-5 text-white">
                                        {{ auth()->user()->hasApprovedDocuments() ? 'Verified' : 'Pending' }}
                                    </div>
                                    <div class="fs-7 text-white-50 mt-1">
                                        {{ $documentsCount }} docs uploaded
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right: Action Buttons -->
                    <div class="col-xl-3 col-lg-3 text-lg-end">
                        <div class="d-flex flex-column gap-2">
                            <a href="{{ route('cars.index') }}" class="btn btn-liquid-primary btn-md rounded-pill px-3 py-2 fw-bold d-inline-flex align-items-center justify-content-center gap-2">
                                <i class="fas fa-car-side fs-6"></i> Book New Vehicle
                            </a>
                            <a href="{{ route('customer.documents.index') }}" class="btn btn-liquid-glass btn-md rounded-pill px-3 py-2 fw-medium d-inline-flex align-items-center justify-content-center gap-2">
                                <i class="fas fa-id-card fs-6"></i> My Documents
                            </a>
                        </div>
                    </div>

                </div>

            </div>
        </div>

        <!-- Quick Search & Category Filter Bar -->
        <div class="mb-4" data-aos="fade-up">
            <div class="bg-white p-3 rounded-4 shadow-sm border d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
                <form action="{{ route('cars.index') }}" method="GET" class="flex-grow-1">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-0 ps-3 text-muted"><i class="fas fa-search"></i></span>
                        <input type="text" name="search" class="form-control bg-light border-0 py-2 fs-6" placeholder="Quick search vehicles by model, brand (e.g. Swift, Fortuner, Thar)...">
                        <button type="submit" class="btn btn-primary rounded-end-3 px-4 fw-bold" style="background: linear-gradient(135deg, #ff7a00, #ea580c); border: none;">Search Fleet</button>
                    </div>
                </form>

                <div class="d-flex align-items-center gap-2 flex-wrap flex-shrink-0">
                    <span class="text-muted small fw-semibold d-none d-lg-inline"><i class="fas fa-filter text-primary me-1"></i> Filter:</span>
                    <a href="{{ route('cars.index') }}" class="quick-filter-chip active">All Fleet</a>
                    <a href="{{ route('cars.index', ['fuel' => 'Petrol']) }}" class="quick-filter-chip"><i class="fas fa-gas-pump fs-7 text-danger"></i> Petrol</a>
                    <a href="{{ route('cars.index', ['fuel' => 'Diesel']) }}" class="quick-filter-chip"><i class="fas fa-oil-can fs-7 text-warning"></i> Diesel</a>
                    <a href="{{ route('cars.index', ['fuel' => 'Electric']) }}" class="quick-filter-chip"><i class="fas fa-charging-station fs-7 text-success"></i> EV</a>
                </div>
            </div>
        </div>

        <!-- System Performance Stat Cards -->
        <div class="row g-4 mb-4">
            <div class="col-xl-3 col-sm-6" data-aos="fade-up" data-aos-delay="100">
                <div class="stat-card-modern p-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <span class="stat-label text-muted fw-bold small text-uppercase tracking-wider">Active Rentals</span>
                        <div class="stat-icon-wrapper" style="background: rgba(37, 99, 235, 0.1); color: #2563eb;">
                            <i class="fas fa-key"></i>
                        </div>
                    </div>
                    <div class="stat-value font-display fs-2 fw-bold text-dark">{{ $activeBookings->count() }}</div>
                    <div class="small mt-2">
                        @if($activeBookings->count() > 0)
                            <span class="text-success fw-semibold"><i class="fas fa-circle me-1 fs-7"></i> {{ $activeBookings->count() }} vehicle checked out</span>
                        @else
                            <span class="text-muted"><i class="fas fa-circle me-1 text-secondary opacity-50 fs-7"></i> No active rental</span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-sm-6" data-aos="fade-up" data-aos-delay="200">
                <div class="stat-card-modern p-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <span class="stat-label text-muted fw-bold small text-uppercase tracking-wider">Total Trips</span>
                        <div class="stat-icon-wrapper" style="background: rgba(16, 185, 129, 0.1); color: #10b981;">
                            <i class="fas fa-route"></i>
                        </div>
                    </div>
                    <div class="stat-value font-display fs-2 fw-bold text-dark">{{ $totalBookings }}</div>
                    <div class="small mt-2">
                        <a href="{{ route('customer.bookings.index') }}" class="text-primary fw-semibold text-decoration-none">
                            View full history <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-sm-6" data-aos="fade-up" data-aos-delay="300">
                <div class="stat-card-modern p-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <span class="stat-label text-muted fw-bold small text-uppercase tracking-wider">Total Amount Spent</span>
                        <div class="stat-icon-wrapper" style="background: rgba(245, 158, 11, 0.1); color: #f59e0b;">
                            <i class="fas fa-wallet"></i>
                        </div>
                    </div>
                    <div class="stat-value font-display fs-2 fw-bold text-dark">₹{{ number_format($totalSpent, 0) }}</div>
                    <div class="small mt-2">
                        <span class="text-success fw-medium"><i class="fas fa-shield-alt me-1"></i> Instant UPI / Razorpay Secured</span>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-sm-6" data-aos="fade-up" data-aos-delay="400">
                <div class="stat-card-modern p-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <span class="stat-label text-muted fw-bold small text-uppercase tracking-wider">ID Verification</span>
                        <div class="stat-icon-wrapper" style="background: {{ auth()->user()->hasApprovedDocuments() ? 'rgba(16, 185, 129, 0.1)' : 'rgba(239, 68, 68, 0.1)' }}; color: {{ auth()->user()->hasApprovedDocuments() ? '#10b981' : '#ef4444' }};">
                            <i class="fas {{ auth()->user()->hasApprovedDocuments() ? 'fa-id-card-clip' : 'fa-id-card' }}"></i>
                        </div>
                    </div>
                    <div class="stat-value font-display fs-4 fw-bold text-dark">
                        {{ auth()->user()->hasApprovedDocuments() ? 'Verified' : 'Pending Upload' }}
                    </div>
                    <div class="small mt-2">
                        <a href="{{ route('customer.documents.index') }}" class="text-primary fw-semibold text-decoration-none">
                            {{ $documentsCount }} documents uploaded <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Area: Active Rentals & Driver Profile Panel -->
        <div class="row g-4 mb-4">
            
            <!-- Left: Current & Upcoming Rentals -->
            <div class="col-lg-8" data-aos="fade-up">
                <div class="dashboard-card border-0 shadow-sm rounded-4 bg-white overflow-hidden">
                    <div class="card-header-custom bg-white p-4 border-bottom d-flex align-items-center justify-content-between">
                        <h5 class="fw-bold mb-0 text-dark">
                            <i class="fas fa-key me-2 text-primary"></i> Current & Active Rentals
                        </h5>
                        @if($activeBookings->count() > 0)
                            <span class="badge bg-primary rounded-pill px-3">{{ $activeBookings->count() }} Active</span>
                        @endif
                    </div>
                    <div class="card-body-custom p-4">
                        @if($activeBookings->count() > 0)
                            <div class="row g-3">
                                @foreach($activeBookings as $booking)
                                    <div class="col-12">
                                        <div class="p-3 rounded-4 border bg-light d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 shadow-xs">
                                            <div class="d-flex align-items-center gap-3">
                                                <div class="rounded-3 overflow-hidden bg-white border" style="width: 100px; height: 70px; flex-shrink: 0;">
                                                    @if($booking->car->thumbnail)
                                                        <img src="{{ asset('storage/' . $booking->car->thumbnail) }}" class="w-100 h-100 object-fit-cover">
                                                    @else
                                                        <div class="d-flex align-items-center justify-content-center h-100 text-primary">
                                                            <i class="fas fa-car fs-3"></i>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div>
                                                    <div class="d-flex align-items-center gap-2 flex-wrap">
                                                        <h6 class="fw-bold mb-0 text-dark fs-5">{{ $booking->car->brand }} {{ $booking->car->model }}</h6>
                                                        <span class="badge-status {{ $booking->status_badge }}">{{ $booking->status }}</span>
                                                    </div>
                                                    <div class="small text-muted mt-1">
                                                        <i class="fas fa-hashtag text-primary me-1"></i> {{ $booking->booking_number }} &nbsp;|&nbsp;
                                                        <i class="fas fa-gas-pump text-primary me-1"></i> {{ $booking->car->fuel_type }} &nbsp;|&nbsp;
                                                        <i class="fas fa-cogs text-primary me-1"></i> {{ $booking->car->transmission ?? 'Manual' }}
                                                    </div>
                                                    <div class="small text-dark fw-medium mt-1">
                                                        <i class="fas fa-calendar-alt text-primary me-1"></i> {{ $booking->pickup_date->format('d M, Y') }} — {{ $booking->return_date->format('d M, Y') }}
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="text-md-end d-flex flex-md-column justify-content-between align-items-center align-items-md-end gap-2 border-top border-md-0 pt-2 pt-md-0">
                                                <div class="fw-bold fs-4 text-primary">₹{{ number_format($booking->total_amount, 0) }}</div>
                                                <div class="d-flex gap-2 flex-wrap justify-content-end">
                                                    <button type="button" class="btn btn-sm btn-warning text-dark rounded-pill px-3 fw-bold" data-bs-toggle="modal" data-bs-target="#extendModal{{ $booking->id }}">
                                                        <i class="fas fa-clock-rotate-left me-1"></i> Extend +24h
                                                    </button>
                                                    <a href="{{ route('bookings.show', $booking->id) }}" class="btn btn-sm btn-outline-primary rounded-pill px-3 fw-semibold">
                                                        View Invoice <i class="fas fa-receipt ms-1"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-4">
                                <div class="mb-3">
                                    <div class="d-inline-flex align-items-center justify-content-center rounded-circle p-3" style="background: rgba(37, 99, 235, 0.08); color: #2563eb;">
                                        <i class="fas fa-car-side fs-2"></i>
                                    </div>
                                </div>
                                <h6 class="fw-bold text-dark mb-2">No Active Vehicle Rental</h6>
                                <p class="text-muted mx-auto mb-3 small" style="max-width: 440px;">
                                    You don't have any active rental currently checked out. Browse our verified Gujarat fleet for your next journey!
                                </p>
                                <a href="{{ route('cars.index') }}" class="btn btn-primary btn-sm rounded-pill px-4 py-2 fw-bold shadow-sm" style="background: linear-gradient(135deg, #ff7a00, #ea580c); border: none;">
                                    <i class="fas fa-search me-2"></i> Explore Available Cars
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Right: Driver Profile & Verification Panel -->
            <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
                
                <!-- Profile & Verification Card -->
                <div class="dashboard-card border-0 shadow-sm rounded-4 bg-white overflow-hidden mb-4" id="profile" style="transition: all 0.3s ease;">
                    <div class="card-header-custom bg-white p-4 border-bottom">
                        <h5 class="fw-bold mb-0 text-dark">
                            <i class="fas fa-shield-alt me-2 text-primary"></i> Verification & Profile
                        </h5>
                    </div>
                    <div class="card-body-custom p-4">
                        @if(auth()->user()->hasApprovedDocuments())
                            <div class="p-3 bg-success bg-opacity-10 border border-success border-opacity-25 rounded-3 mb-3">
                                <div class="d-flex align-items-center gap-2 text-success fw-bold mb-1">
                                    <i class="fas fa-check-circle fs-5"></i> Identity Verified
                                </div>
                                <p class="small text-muted mb-0">Your Driving License and identity documents are fully approved by AutoLux.</p>
                            </div>
                        @else
                            <div class="p-3 bg-warning bg-opacity-10 border border-warning border-opacity-25 rounded-3 mb-3">
                                <div class="d-flex align-items-center gap-2 text-warning fw-bold mb-1">
                                    <i class="fas fa-exclamation-triangle fs-5"></i> Verification Required
                                </div>
                                <p class="small text-muted mb-2">Upload your valid Driving License or Aadhaar card to unlock instant booking.</p>
                                <a href="{{ route('customer.documents.index') }}" class="btn btn-sm btn-warning rounded-pill text-dark fw-bold px-3">
                                    Upload ID Documents <i class="fas fa-upload ms-1"></i>
                                </a>
                            </div>
                        @endif

                        <div class="list-group list-group-flush border-0 small mt-2">
                            <div class="list-group-item px-0 d-flex justify-content-between align-items-center border-0 py-2">
                                <span class="text-muted"><i class="fas fa-user me-2 text-primary"></i> Name</span>
                                <span class="fw-bold text-dark">{{ auth()->user()->name }}</span>
                            </div>
                            <div class="list-group-item px-0 d-flex justify-content-between align-items-center border-0 py-2">
                                <span class="text-muted"><i class="fas fa-phone me-2 text-primary"></i> Phone</span>
                                <span class="fw-bold text-dark">{{ auth()->user()->phone ?? 'Not provided' }}</span>
                            </div>
                            <div class="list-group-item px-0 d-flex justify-content-between align-items-center border-0 py-2">
                                <span class="text-muted"><i class="fas fa-envelope me-2 text-primary"></i> Email</span>
                                <span class="fw-bold text-dark">{{ auth()->user()->email }}</span>
                            </div>
                            <div class="list-group-item px-0 d-flex justify-content-between align-items-center border-0 py-2">
                                <span class="text-muted"><i class="fas fa-location-dot me-2 text-primary"></i> City</span>
                                <span class="fw-bold text-dark">{{ auth()->user()->city ?? 'Ahmedabad' }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 24/7 Roadside Assistance Box -->
                <div class="rounded-4 p-4 text-white shadow-sm" id="assistance" style="background: linear-gradient(135deg, #0a1628, #1e3a5f); transition: all 0.3s ease;">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="d-flex align-items-center gap-3">
                            <div class="p-3 rounded-circle bg-white bg-opacity-10 text-warning">
                                <i class="fas fa-headset fs-3"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold text-white mb-0">24/7 Roadside Assist</h6>
                                <small class="text-white-50">Gujarat Highway Support</small>
                            </div>
                        </div>
                        <span class="d-flex align-items-center gap-1 text-success fs-7 fw-semibold bg-white bg-opacity-10 rounded-pill px-2 py-1">
                            <span class="pulse-online-dot"></span> Live 24/7
                        </span>
                    </div>
                    
                    <p class="small text-white-50 mb-3">
                        Breakdown support, tire change, battery jumpstart, or highway emergency across Gujarat routes.
                    </p>

                    <div class="d-grid gap-2">
                        <a href="tel:+919876543210" class="btn btn-outline-light rounded-pill btn-sm fw-bold">
                            <i class="fas fa-phone-alt me-2 text-warning"></i> Call Helpline: +91 98765 43210
                        </a>
                        <a href="https://wa.me/919876543210?text=Hi%20AutoLux%20Support%2C%20I%20need%20roadside%20assistance" target="_blank" class="btn btn-success bg-opacity-25 border-success text-white rounded-pill btn-sm fw-bold">
                            <i class="fab fa-whatsapp me-2"></i> WhatsApp Emergency Support
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recommended Vehicles Section -->
        @if(isset($recommendedCars) && $recommendedCars->count() > 0)
            <div class="mb-4" data-aos="fade-up">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div>
                        <h5 class="fw-bold text-dark mb-0"><i class="fas fa-fire text-warning me-2"></i> Featured Cars Ready for Rental</h5>
                        <small class="text-muted">Top rated self-drive vehicles available in Ahmedabad</small>
                    </div>
                    <a href="{{ route('cars.index') }}" class="text-primary small fw-semibold text-decoration-none">
                        View Complete Catalog <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>

                <div class="row g-3">
                    @foreach($recommendedCars as $car)
                        <div class="col-md-4">
                            <div class="car-card-hover bg-white rounded-4 overflow-hidden h-100 d-flex flex-column">
                                <div class="position-relative overflow-hidden bg-light" style="height: 170px;">
                                    @if($car->thumbnail)
                                        <img src="{{ asset('storage/' . $car->thumbnail) }}" alt="{{ $car->display_name }}" class="w-100 h-100 object-fit-cover car-img-zoom">
                                    @else
                                        <div class="d-flex align-items-center justify-content-center h-100 text-primary">
                                            <i class="fas fa-car fs-1 opacity-50"></i>
                                        </div>
                                    @endif
                                    <span class="position-absolute top-0 start-0 m-3 badge bg-success rounded-pill px-3 py-1 fs-7">Available</span>
                                    <span class="position-absolute bottom-0 end-0 m-3 badge bg-dark bg-opacity-75 text-white rounded-pill px-2 py-1 fs-7">
                                        <i class="fas fa-gas-pump me-1 text-warning"></i> {{ $car->fuel_type }}
                                    </span>
                                </div>
                                <div class="p-3 d-flex flex-column flex-grow-1 justify-content-between">
                                    <div>
                                        <div class="text-uppercase text-primary small fw-bold tracking-wider mb-1">{{ $car->brand }}</div>
                                        <h6 class="fw-bold text-dark mb-2 fs-6">{{ $car->model }}</h6>
                                        <div class="d-flex align-items-center gap-3 text-muted fs-7 mb-3">
                                            <span><i class="fas fa-user me-1 text-primary"></i> {{ $car->seating_capacity ?? '5' }} Seats</span>
                                            <span><i class="fas fa-cogs me-1 text-primary"></i> {{ $car->transmission ?? 'Manual' }}</span>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between border-top pt-3 mt-2">
                                        <div>
                                            <div class="fw-bold text-dark fs-5">₹{{ number_format($car->rental_price_per_day, 0) }}</div>
                                            <div class="text-muted fs-7">per day</div>
                                        </div>
                                        <a href="{{ route('cars.show', $car->id) }}" class="btn btn-sm btn-primary rounded-pill px-3 fw-bold" style="background: linear-gradient(135deg, #ff7a00, #ea580c); border: none;">
                                            Book Now <i class="fas fa-arrow-right ms-1"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Recent Booking History Table -->
        <div class="row" data-aos="fade-up">
            <div class="col-12">
                <div class="dashboard-card border-0 shadow-sm rounded-4 bg-white overflow-hidden">
                    <div class="card-header-custom bg-white p-4 border-bottom d-flex align-items-center justify-content-between">
                        <div>
                            <h5 class="fw-bold mb-0 text-dark"><i class="fas fa-history me-2 text-primary"></i> Recent Rental History</h5>
                            <small class="text-muted">Summary of your latest vehicle reservations</small>
                        </div>
                        <a href="{{ route('customer.bookings.index') }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3">View All Bookings</a>
                    </div>
                    <div class="card-body-custom p-4">
                        @if($recentBookings->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="ps-3">Booking #</th>
                                            <th>Vehicle</th>
                                            <th>Pickup Date</th>
                                            <th>Return Date</th>
                                            <th>Amount</th>
                                            <th>Status</th>
                                            <th class="text-end pe-3">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($recentBookings as $booking)
                                            <tr>
                                                <td class="ps-3 fw-bold text-primary">{{ $booking->booking_number }}</td>
                                                <td>
                                                    <div class="d-flex align-items-center gap-2">
                                                        <div class="fw-bold text-dark">{{ $booking->car->brand }} {{ $booking->car->model }}</div>
                                                    </div>
                                                </td>
                                                <td><i class="fas fa-calendar-day me-1 text-muted"></i> {{ $booking->pickup_date->format('d M Y') }}</td>
                                                <td><i class="fas fa-calendar-check me-1 text-muted"></i> {{ $booking->return_date->format('d M Y') }}</td>
                                                <td class="fw-bold text-dark">₹{{ number_format($booking->total_amount, 0) }}</td>
                                                <td>
                                                    <span class="badge-status {{ $booking->status_badge }}">
                                                        {{ $booking->status }}
                                                    </span>
                                                </td>
                                                <td class="text-end pe-3">
                                                    <a href="{{ route('bookings.show', $booking->id) }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                                        <i class="fas fa-receipt me-1"></i> Invoice
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-4">
                                <p class="text-muted mb-0">No past rental history found.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

<!-- Active Booking Extension Modals (Interactive Liquid Glass Theme) -->
@if(isset($activeBookings) && $activeBookings->count() > 0)
    @foreach($activeBookings as $booking)
        @php
            $dailyRate = $booking->car->rental_price_per_day;
            $returnTimestamp = $booking->return_date->timestamp * 1000;
            $currentTotal = $booking->total_amount;
        @endphp
        <div class="modal fade" id="extendModal{{ $booking->id }}" tabindex="-1" aria-labelledby="extendModalLabel{{ $booking->id }}" aria-hidden="true" style="z-index: 1060;">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                    
                    <!-- Header -->
                    <div class="modal-header p-4 text-white border-0 position-relative overflow-hidden" style="background: linear-gradient(135deg, #09172c 0%, #0c2547 50%, #143b73 100%);">
                        <div class="d-flex align-items-center gap-3">
                            <div class="rounded-circle p-2 bg-white bg-opacity-10 text-warning">
                                <i class="fas fa-clock-rotate-left fs-4"></i>
                            </div>
                            <div>
                                <h5 class="modal-title fw-bold text-white mb-0" id="extendModalLabel{{ $booking->id }}">
                                    Extend Rental Duration
                                </h5>
                                <small class="text-white-50">{{ $booking->car->brand }} {{ $booking->car->model }} &nbsp;•&nbsp; #{{ $booking->booking_number }}</small>
                            </div>
                        </div>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <form action="{{ route('bookings.extend', $booking->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="extension_days" id="extension_days_input_{{ $booking->id }}" value="1">
                        
                        <div class="modal-body p-4">
                            
                            <!-- Vehicle Info & Rates -->
                            <div class="d-flex align-items-center justify-content-between p-3 rounded-3 bg-light border mb-3">
                                <div>
                                    <div class="text-muted fs-7">Daily Rental Rate</div>
                                    <div class="fw-bold text-dark fs-5">₹{{ number_format($dailyRate, 0) }} <small class="text-muted fs-7">/day</small></div>
                                </div>
                                <div class="text-end">
                                    <div class="text-muted fs-7">Current Return Date</div>
                                    <div class="fw-bold text-primary fs-6">{{ $booking->return_date->format('d M, Y') }}</div>
                                </div>
                            </div>

                            <!-- Duration Quick Selector Pills -->
                            <div class="mb-4">
                                <label class="form-label fw-semibold text-dark small text-uppercase tracking-wider mb-2">Select Extension Days</label>
                                <div class="d-flex flex-wrap gap-2">
                                    @foreach([1 => '+1 Day', 2 => '+2 Days', 3 => '+3 Days', 5 => '+5 Days', 7 => '+7 Days'] as $days => $label)
                                        <button type="button" 
                                                class="btn btn-outline-primary rounded-pill btn-sm px-3 py-2 fw-semibold ext-pill-btn-{{ $booking->id }} {{ $days === 1 ? 'active' : '' }}" 
                                                onclick="selectExtensionDays(event, {{ $booking->id }}, {{ $days }}, {{ $dailyRate }}, {{ $returnTimestamp }}, {{ $currentTotal }})">
                                            {{ $label }}
                                        </button>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Real-time Cost Calculation Box -->
                            <div class="p-3 rounded-4 border bg-primary bg-opacity-10 border-primary border-opacity-25 mb-3">
                                <div class="row g-2 text-dark small">
                                    <div class="col-6">
                                        <span class="text-muted">New Scheduled Return:</span>
                                    </div>
                                    <div class="col-6 text-end fw-bold text-primary" id="calcNewDate_{{ $booking->id }}">
                                        {{ $booking->return_date->copy()->addDays(1)->format('d M, Y') }}
                                    </div>

                                    <div class="col-6">
                                        <span class="text-muted">Extension Charge:</span>
                                    </div>
                                    <div class="col-6 text-end fw-bold text-warning" id="calcExtraAmount_{{ $booking->id }}">
                                        +₹{{ number_format($dailyRate * 1, 0) }}
                                    </div>

                                    <div class="col-12"><hr class="my-1 border-primary opacity-25"></div>

                                    <div class="col-6">
                                        <span class="fw-bold text-dark fs-6">Updated Total Amount:</span>
                                    </div>
                                    <div class="col-6 text-end fw-bold text-success fs-6" id="calcNewTotal_{{ $booking->id }}">
                                        ₹{{ number_format($currentTotal + ($dailyRate * 1), 0) }}
                                    </div>
                                </div>
                            </div>

                            <!-- Payment Preference Options -->
                            <div class="mb-3">
                                <label class="form-label fw-semibold text-dark small text-uppercase tracking-wider mb-2">Payment Preference</label>
                                <div class="row g-2">
                                    <div class="col-6">
                                        <label class="p-3 rounded-3 border bg-white cursor-pointer h-100 d-flex flex-column justify-content-between w-100 text-start shadow-xs">
                                            <div class="d-flex align-items-center justify-content-between mb-1">
                                                <input type="radio" name="payment_method" value="invoice" checked class="form-check-input" onchange="toggleExtensionPaymentMode({{ $booking->id }}, 'invoice')">
                                                <i class="fas fa-file-invoice-dollar text-primary"></i>
                                            </div>
                                            <div class="fw-bold text-dark fs-7">Pay via Invoice</div>
                                            <div class="text-muted fs-7">Added to final bill</div>
                                        </label>
                                    </div>
                                    <div class="col-6">
                                        <label class="p-3 rounded-3 border bg-white cursor-pointer h-100 d-flex flex-column justify-content-between w-100 text-start shadow-xs">
                                            <div class="d-flex align-items-center justify-content-between mb-1">
                                                <input type="radio" name="payment_method" value="upi" class="form-check-input" onchange="toggleExtensionPaymentMode({{ $booking->id }}, 'upi')">
                                                <span class="badge bg-success bg-opacity-10 text-success fs-7">Instant ⚡</span>
                                            </div>
                                            <div class="fw-bold text-dark fs-7">Pay Instant UPI</div>
                                            <div class="text-success fs-7 fw-semibold"><i class="fas fa-shield-alt me-1"></i> Razorpay</div>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="text-muted fs-7">
                                <i class="fas fa-shield-alt text-success me-1"></i> Instant extension with zero booking fees. Charges updated directly on your receipt.
                            </div>
                        </div>

                        <div class="modal-footer bg-light p-3 border-top">
                            <button type="button" class="btn btn-secondary rounded-pill px-3" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" id="btnConfirmExt_{{ $booking->id }}" class="btn btn-primary rounded-pill px-4 py-2 fw-bold shadow-sm" style="background: linear-gradient(135deg, #ff7a00, #ea580c); border: none;">
                                Confirm Extension <i class="fas fa-check ms-1"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
@endif

@push('scripts')
<script>
    // Time-based Greeting Script
    document.addEventListener("DOMContentLoaded", function() {
        const greetingElement = document.getElementById('timeGreeting');
        if (greetingElement) {
            const hour = new Date().getHours();
            if (hour >= 5 && hour < 12) {
                greetingElement.textContent = "Good Morning";
            } else if (hour >= 12 && hour < 17) {
                greetingElement.textContent = "Good Afternoon";
            } else if (hour >= 17 && hour < 22) {
                greetingElement.textContent = "Good Evening";
            } else {
                greetingElement.textContent = "Welcome Night Rider";
            }
        }
    });

    // Real-time Extension Price & Date Calculator
    function selectExtensionDays(event, bookingId, days, dailyRate, returnTimestamp, currentTotal) {
        if (event && event.target) {
            document.querySelectorAll('.ext-pill-btn-' + bookingId).forEach(btn => btn.classList.remove('active'));
            event.target.classList.add('active');
        }

        const inputEl = document.getElementById('extension_days_input_' + bookingId);
        if (inputEl) {
            inputEl.value = days;
        }

        const returnDateObj = new Date(returnTimestamp);
        returnDateObj.setDate(returnDateObj.getDate() + days);
        
        const options = { day: '2-digit', month: 'short', year: 'numeric' };
        const formattedDate = returnDateObj.toLocaleDateString('en-GB', options);

        const extraAmount = dailyRate * days;
        const newTotal = currentTotal + extraAmount;

        const dateEl = document.getElementById('calcNewDate_' + bookingId);
        const extraEl = document.getElementById('calcExtraAmount_' + bookingId);
        const totalEl = document.getElementById('calcNewTotal_' + bookingId);

        if (dateEl) dateEl.textContent = formattedDate;
        if (extraEl) extraEl.textContent = '+₹' + extraAmount.toLocaleString('en-IN');
        if (totalEl) totalEl.textContent = '₹' + newTotal.toLocaleString('en-IN');
    }

    // Toggle Extension Payment Mode UI Button Label
    function toggleExtensionPaymentMode(bookingId, mode) {
        const btn = document.getElementById('btnConfirmExt_' + bookingId);
        if (btn) {
            if (mode === 'upi') {
                btn.innerHTML = '<i class="fab fa-google-pay me-1"></i> Pay Instant UPI & Extend ⚡';
                btn.style.background = 'linear-gradient(135deg, #10b981, #059669)';
            } else {
                btn.innerHTML = 'Confirm Extension <i class="fas fa-check ms-1"></i>';
                btn.style.background = 'linear-gradient(135deg, #ff7a00, #ea580c)';
            }
        }
    }
</script>
@endpush
@endsection
