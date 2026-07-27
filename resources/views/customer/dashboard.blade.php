@extends('layouts.app')

@section('title', 'Customer Dashboard — AutoLux')

@section('content')
<section class="dashboard-section pb-5">
    <div class="container">
        
        <!-- Welcome Hero Banner Card -->
        <div class="mb-4" data-aos="fade-down">
            <div class="p-4 p-md-5 rounded-4 text-white shadow-lg position-relative overflow-hidden" 
                 style="background: linear-gradient(135deg, #0a1628 0%, #153663 50%, #1a4a8a 100%); border: 1px solid rgba(255,255,255,0.1);">
                
                <!-- Ambient Glow Orbs -->
                <div class="position-absolute rounded-circle" style="width: 250px; height: 250px; background: rgba(255, 122, 0, 0.15); filter: blur(60px); top: -50px; right: -50px;"></div>
                <div class="position-absolute rounded-circle" style="width: 200px; height: 200px; background: rgba(37, 99, 235, 0.2); filter: blur(50px); bottom: -40px; left: 20%;"></div>

                <div class="row align-items-center position-relative" style="z-index: 2;">
                    <div class="col-lg-8 mb-3 mb-lg-0">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div class="user-avatar-large shadow-sm" style="width: 56px; height: 56px; background: linear-gradient(135deg, #ff7a00, #ea580c); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.4rem; font-weight: 800; color: #fff;">
                                {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                            </div>
                            <div>
                                <div class="d-flex align-items-center gap-2">
                                    <h2 class="fw-bold mb-0 text-white font-display fs-3">Welcome, {{ auth()->user()->name }}!</h2>
                                    @if(auth()->user()->hasApprovedDocuments())
                                        <span class="badge bg-success bg-opacity-25 text-success border border-success border-opacity-50 rounded-pill px-3 py-1 small">
                                            <i class="fas fa-check-circle me-1"></i> Verified Driver
                                        </span>
                                    @else
                                        <span class="badge bg-warning bg-opacity-25 text-warning border border-warning border-opacity-50 rounded-pill px-3 py-1 small">
                                            <i class="fas fa-exclamation-triangle me-1"></i> Action Required
                                        </span>
                                    @endif
                                </div>
                                <p class="text-white-50 mb-0 small mt-1">
                                    <i class="fas fa-map-marker-alt me-1 text-warning"></i> Ahmedabad Hub &nbsp;|&nbsp; Member since {{ auth()->user()->created_at->format('M Y') }}
                                </p>
                            </div>
                        </div>
                        <p class="text-white-50 mb-0" style="max-width: 550px;">
                            Manage your active rentals, track reservations, or pick your next luxury ride from our Ahmedabad car.
                        </p>
                    </div>
                    <div class="col-lg-4 text-lg-end">
                        <div class="d-flex flex-wrap gap-2 justify-content-lg-end">
                            <a href="{{ route('cars.index') }}" class="btn btn-lg rounded-pill px-4 fw-bold text-white shadow-lg" style="background: linear-gradient(135deg, #ff7a00, #ea580c); border: none;">
                                <i class="fas fa-car-side me-2"></i> Book New Vehicle
                            </a>
                            <a href="{{ route('customer.documents.index') }}" class="btn btn-lg btn-outline-light rounded-pill px-3 fw-medium">
                                <i class="fas fa-id-card me-1"></i> Documents
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- System Performance Stat Cards -->
        <div class="row g-4 mb-4">
            <div class="col-xl-3 col-sm-6" data-aos="fade-up" data-aos-delay="100">
                <div class="stat-card border-0 shadow-sm p-4 rounded-4 bg-white position-relative overflow-hidden">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <span class="stat-label text-muted fw-bold small text-uppercase">Active Rentals</span>
                        <div class="stat-icon p-3 rounded-3" style="background: rgba(37, 99, 235, 0.1); color: #2563eb;">
                            <i class="fas fa-car-side fs-4"></i>
                        </div>
                    </div>
                    <div class="stat-value font-display fs-2 fw-bold text-dark">{{ $activeBookings->count() }}</div>
                    <div class="small text-muted mt-2">
                        @if($activeBookings->count() > 0)
                            <span class="text-success fw-semibold"><i class="fas fa-key me-1"></i> Vehicle in use</span>
                        @else
                            <span class="text-muted"><i class="fas fa-circle me-1 text-secondary opacity-50"></i> No active drive</span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-sm-6" data-aos="fade-up" data-aos-delay="200">
                <div class="stat-card border-0 shadow-sm p-4 rounded-4 bg-white position-relative overflow-hidden">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <span class="stat-label text-muted fw-bold small text-uppercase">Total Bookings</span>
                        <div class="stat-icon p-3 rounded-3" style="background: rgba(16, 185, 129, 0.1); color: #10b981;">
                            <i class="fas fa-calendar-check fs-4"></i>
                        </div>
                    </div>
                    <div class="stat-value font-display fs-2 fw-bold text-dark">{{ $totalBookings }}</div>
                    <div class="small text-muted mt-2">
                        <a href="{{ route('customer.bookings.index') }}" class="text-primary fw-semibold">View all history <i class="fas fa-arrow-right ms-1"></i></a>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-sm-6" data-aos="fade-up" data-aos-delay="300">
                <div class="stat-card border-0 shadow-sm p-4 rounded-4 bg-white position-relative overflow-hidden">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <span class="stat-label text-muted fw-bold small text-uppercase">Total Amount Spent</span>
                        <div class="stat-icon p-3 rounded-3" style="background: rgba(245, 158, 11, 0.1); color: #f59e0b;">
                            <i class="fas fa-wallet fs-4"></i>
                        </div>
                    </div>
                    <div class="stat-value font-display fs-2 fw-bold text-dark">₹{{ number_format($totalSpent, 0) }}</div>
                    <div class="small text-muted mt-2">
                        <span class="text-success"><i class="fas fa-shield-alt me-1"></i> Instant UPI Secured</span>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-sm-6" data-aos="fade-up" data-aos-delay="400">
                <div class="stat-card border-0 shadow-sm p-4 rounded-4 bg-white position-relative overflow-hidden">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <span class="stat-label text-muted fw-bold small text-uppercase">ID Verification</span>
                        <div class="stat-icon p-3 rounded-3" style="background: {{ auth()->user()->hasApprovedDocuments() ? 'rgba(16, 185, 129, 0.1)' : 'rgba(239, 68, 68, 0.1)' }}; color: {{ auth()->user()->hasApprovedDocuments() ? '#10b981' : '#ef4444' }};">
                            <i class="fas {{ auth()->user()->hasApprovedDocuments() ? 'fa-id-card-clip' : 'fa-id-card' }} fs-4"></i>
                        </div>
                    </div>
                    <div class="stat-value font-display fs-4 fw-bold text-dark">
                        {{ auth()->user()->hasApprovedDocuments() ? 'Verified' : 'Pending' }}
                    </div>
                    <div class="small text-muted mt-2">
                        <a href="{{ route('customer.documents.index') }}" class="text-primary fw-semibold">
                            {{ $documentsCount }} uploaded docs <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Area: Active Rentals & ID Verification Panel -->
        <div class="row g-4 mb-4">
            
            <!-- Left: Current & Upcoming Rentals -->
            <div class="col-lg-8" data-aos="fade-up">
                <div class="dashboard-card border-0 shadow-sm rounded-4 bg-white overflow-hidden h-100">
                    <div class="card-header-custom bg-white p-4 border-bottom d-flex align-items-center justify-content-between">
                        <h5 class="fw-bold mb-0 text-dark">
                            <i class="fas fa-key me-2 text-primary"></i> Current & Upcoming Rentals
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
                                        <div class="p-3 rounded-4 border bg-light d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
                                            <div class="d-flex align-items-center gap-3">
                                                <div class="rounded-3 overflow-hidden bg-white border" style="width: 90px; height: 65px; flex-shrink: 0;">
                                                    @if($booking->car->thumbnail)
                                                        <img src="{{ asset('storage/' . $booking->car->thumbnail) }}" class="w-100 h-100 object-fit-cover">
                                                    @else
                                                        <div class="d-flex align-items-center justify-content-center h-100 text-primary">
                                                            <i class="fas fa-car fs-3"></i>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div>
                                                    <div class="d-flex align-items-center gap-2">
                                                        <h6 class="fw-bold mb-0 text-dark">{{ $booking->car->brand }} {{ $booking->car->model }}</h6>
                                                        <span class="badge-status {{ $booking->status_badge }}">{{ $booking->status }}</span>
                                                    </div>
                                                    <div class="small text-muted mt-1">
                                                        <i class="fas fa-hashtag text-primary me-1"></i> {{ $booking->booking_number }} &nbsp;|&nbsp;
                                                        <i class="fas fa-gas-pump text-primary me-1"></i> {{ $booking->car->fuel_type }}
                                                    </div>
                                                    <div class="small text-dark fw-medium mt-1">
                                                        <i class="fas fa-calendar-alt text-primary me-1"></i> {{ $booking->pickup_date->format('d M') }} — {{ $booking->return_date->format('d M Y') }}
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="text-md-end d-flex flex-md-column justify-content-between align-items-center align-items-md-end gap-2">
                                                <div class="fw-bold fs-5 text-primary">₹{{ number_format($booking->total_amount, 0) }}</div>
                                                <a href="{{ route('bookings.show', $booking->id) }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                                    View Invoice <i class="fas fa-receipt ms-1"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-5">
                                <div class="mb-3">
                                    <div class="d-inline-flex align-items-center justify-content-center rounded-circle p-4" style="background: rgba(37, 99, 235, 0.08); color: #2563eb;">
                                        <i class="fas fa-car-side display-4"></i>
                                    </div>
                                </div>
                                <h5 class="fw-bold text-dark mb-2">No Active Vehicle Rental</h5>
                                <p class="text-muted mx-auto mb-4" style="max-width: 420px;">
                                    You don't have any vehicle checked out currently. Choose a vehicle from our Gujarat Cars for your upcoming trip!
                                </p>
                                <a href="{{ route('cars.index') }}" class="btn btn-primary rounded-pill px-4 py-2 fw-bold" style="background: linear-gradient(135deg, #ff7a00, #ea580c); border: none;">
                                    <i class="fas fa-search me-2"></i> Explore Cars Now
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Right: Driver ID Verification & Assistance Panel -->
            <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
                <div class="dashboard-card border-0 shadow-sm rounded-4 bg-white overflow-hidden mb-4">
                    <div class="card-header-custom bg-white p-4 border-bottom">
                        <h5 class="fw-bold mb-0 text-dark">
                            <i class="fas fa-shield-alt me-2 text-primary"></i> Verification & Profile
                        </h5>
                    </div>
                    <div class="card-body-custom p-4">
                        @if(auth()->user()->hasApprovedDocuments())
                            <div class="p-3 bg-success bg-opacity-10 border border-success border-opacity-25 rounded-3 mb-3">
                                <div class="d-flex align-items-center gap-2 text-success fw-bold mb-1">
                                    <i class="fas fa-check-circle fs-5"></i> 100% Verified Driver
                                </div>
                                <p class="small text-muted mb-0">Your Driving License and identity documents have been approved by AutoLux admin.</p>
                            </div>
                        @else
                            <div class="p-3 bg-warning bg-opacity-10 border border-warning border-opacity-25 rounded-3 mb-3">
                                <div class="d-flex align-items-center gap-2 text-warning fw-bold mb-1">
                                    <i class="fas fa-exclamation-triangle fs-5"></i> Action Needed
                                </div>
                                <p class="small text-muted mb-2">Upload your Driving License or Aadhaar card for instant verification.</p>
                                <a href="{{ route('customer.documents.index') }}" class="btn btn-sm btn-warning rounded-pill text-dark fw-bold px-3">
                                    Upload Documents <i class="fas fa-upload ms-1"></i>
                                </a>
                            </div>
                        @endif

                        <div class="list-group list-group-flush border-0 small mt-3">
                            <div class="list-group-item px-0 d-flex justify-content-between align-items-center border-0 py-2">
                                <span class="text-muted"><i class="fas fa-phone me-2 text-primary"></i> Phone</span>
                                <span class="fw-bold text-dark">{{ auth()->user()->phone ?? '9876543210' }}</span>
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

                <!-- 24/7 Roadside Assistance Support Box -->
                <div class="rounded-4 p-4 text-white shadow-sm" style="background: linear-gradient(135deg, #0a1628, #1e3a5f);">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="p-3 rounded-circle bg-white bg-opacity-10 text-warning">
                            <i class="fas fa-headset fs-3"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold text-white mb-0">24/7 Roadside Assist</h6>
                            <small class="text-white-50">Gujarat Highway Support</small>
                        </div>
                    </div>
                    <p class="small text-white-50 mb-3">
                        Stuck on the road or need help during your rental? Our Ahmedabad team is available 24/7.
                    </p>
                    <a href="tel:+919876543210" class="btn btn-outline-light rounded-pill btn-sm w-100 fw-bold">
                        <i class="fas fa-phone-alt me-2 text-warning"></i> Call +91 98765 43210
                    </a>
                </div>
            </div>
        </div>

        <!-- Recommended Vehicles Section -->
        @if(isset($recommendedCars) && $recommendedCars->count() > 0)
            <div class="mb-4" data-aos="fade-up">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h5 class="fw-bold text-dark mb-0"><i class="fas fa-fire text-warning me-2"></i> Recommended Cars for You</h5>
                    <a href="{{ route('cars.index') }}" class="text-primary small fw-semibold">View car Catalog <i class="fas fa-arrow-right ms-1"></i></a>
                </div>

                <div class="row g-3">
                    @foreach($recommendedCars as $car)
                        <div class="col-md-4">
                            <div class="car-card bg-white border-0 shadow-sm rounded-4 overflow-hidden h-100">
                                <div class="car-card-img" style="height: 160px;">
                                    @if($car->thumbnail)
                                        <img src="{{ asset('storage/' . $car->thumbnail) }}" alt="{{ $car->display_name }}">
                                    @else
                                        <div class="car-placeholder-icon">
                                            <i class="fas fa-car fs-2"></i>
                                        </div>
                                    @endif
                                    <span class="car-badge available">Available</span>
                                    <span class="car-fuel-badge">{{ $car->fuel_type }}</span>
                                </div>
                                <div class="car-card-body p-3">
                                    <div class="car-card-brand text-uppercase text-primary small fw-bold">{{ $car->brand }}</div>
                                    <h6 class="fw-bold text-dark mb-2">{{ $car->model }}</h6>
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="fw-bold text-dark fs-6">₹{{ number_format($car->rental_price_per_day, 0) }} <small class="text-muted fs-7">/day</small></div>
                                        <a href="{{ route('cars.show', $car->id) }}" class="btn btn-sm btn-primary rounded-pill px-3">Book <i class="fas fa-arrow-right ms-1"></i></a>
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
                        <h5 class="fw-bold mb-0 text-dark"><i class="fas fa-history me-2 text-primary"></i> Booking History</h5>
                        <a href="{{ route('customer.bookings.index') }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3">View All</a>
                    </div>
                    <div class="card-body-custom p-4">
                        @if($recentBookings->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-modern align-middle mb-0">
                                    <thead>
                                        <tr>
                                            <th>Booking #</th>
                                            <th>Vehicle</th>
                                            <th>Pickup Date</th>
                                            <th>Return Date</th>
                                            <th>Amount</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($recentBookings as $booking)
                                            <tr>
                                                <td class="fw-bold text-primary">{{ $booking->booking_number }}</td>
                                                <td>
                                                    <div class="fw-bold text-dark">{{ $booking->car->brand }} {{ $booking->car->model }}</div>
                                                </td>
                                                <td>{{ $booking->pickup_date->format('d M Y') }}</td>
                                                <td>{{ $booking->return_date->format('d M Y') }}</td>
                                                <td class="fw-bold text-dark">₹{{ number_format($booking->total_amount, 0) }}</td>
                                                <td>
                                                    <span class="badge-status {{ $booking->status_badge }}">
                                                        {{ $booking->status }}
                                                    </span>
                                                </td>
                                                <td>
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
@endsection
