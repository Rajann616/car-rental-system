@extends('layouts.app')

@section('title', 'Customer Dashboard — DriveEase')

@section('content')
<section class="dashboard-section pb-5">
    <div class="container">
        <!-- Header -->
        <div class="dashboard-header d-flex align-items-center justify-content-between flex-wrap gap-3" data-aos="fade-down">
            <div>
                <h1 class="fw-bold mb-1">Hello, {{ auth()->user()->name }}! 👋</h1>
                <p class="text-muted mb-0">Manage your active rentals, view booking history, and update documents.</p>
            </div>
            <div>
                <a href="{{ route('home') }}#fleet" class="btn btn-primary rounded-pill px-4 py-2">
                    <i class="fas fa-plus me-2"></i> Book New Vehicle
                </a>
            </div>
        </div>

        <!-- Stats Overview -->
        <div class="row g-4 mb-4">
            <div class="col-lg-3 col-sm-6" data-aos="fade-up" data-aos-delay="100">
                <div class="stat-card">
                    <div class="stat-icon blue"><i class="fas fa-car"></i></div>
                    <div class="stat-value">{{ $activeBookings->count() }}</div>
                    <div class="stat-label">Active Rentals</div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6" data-aos="fade-up" data-aos-delay="200">
                <div class="stat-card">
                    <div class="stat-icon green"><i class="fas fa-history"></i></div>
                    <div class="stat-value">{{ $totalBookings }}</div>
                    <div class="stat-label">Total Bookings</div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6" data-aos="fade-up" data-aos-delay="300">
                <div class="stat-card">
                    <div class="stat-icon amber"><i class="fas fa-rupee-sign"></i></div>
                    <div class="stat-value">₹{{ number_format($totalSpent, 0) }}</div>
                    <div class="stat-label">Total Spent</div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6" data-aos="fade-up" data-aos-delay="400">
                <div class="stat-card">
                    <div class="stat-icon red"><i class="fas fa-id-card"></i></div>
                    <div class="stat-value">{{ $documentsCount }}</div>
                    <div class="stat-label">Uploaded Docs</div>
                </div>
            </div>
        </div>

        <!-- Active Bookings & Document Alert -->
        <div class="row g-4 mb-4">
            <div class="col-lg-8" data-aos="fade-up">
                <div class="dashboard-card">
                    <div class="card-header-custom">
                        <h5><i class="fas fa-car-side me-2 text-primary"></i> Current & Upcoming Rentals</h5>
                    </div>
                    <div class="card-body-custom">
                        @if($activeBookings->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-modern align-middle mb-0">
                                    <thead>
                                        <tr>
                                            <th>Booking #</th>
                                            <th>Vehicle</th>
                                            <th>Pickup</th>
                                            <th>Return</th>
                                            <th>Total</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($activeBookings as $booking)
                                            <tr>
                                                <td class="fw-semibold text-primary">{{ $booking->booking_number }}</td>
                                                <td>
                                                    <div class="d-flex align-items-center gap-2">
                                                        <div class="fw-bold">{{ $booking->car->brand }} {{ $booking->car->model }}</div>
                                                    </div>
                                                </td>
                                                <td>{{ $booking->pickup_date->format('d M Y') }}</td>
                                                <td>{{ $booking->return_date->format('d M Y') }}</td>
                                                <td class="fw-bold">₹{{ number_format($booking->total_amount, 0) }}</td>
                                                <td>
                                                    <span class="badge-status {{ $booking->status_badge }}">
                                                        {{ $booking->status }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="fas fa-car text-muted opacity-25 fs-1 mb-2"></i>
                                <p class="text-muted mb-3">You don't have any active vehicle rentals right now.</p>
                                <a href="{{ route('home') }}#fleet" class="btn btn-outline-primary rounded-pill btn-sm">Explore Fleet</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
                <div class="dashboard-card h-100">
                    <div class="card-header-custom">
                        <h5><i class="fas fa-user-shield me-2 text-primary"></i> ID Verification</h5>
                    </div>
                    <div class="card-body-custom">
                        @if(auth()->user()->hasApprovedDocuments())
                            <div class="p-3 bg-success bg-opacity-10 border border-success border-opacity-25 rounded-3 mb-3">
                                <div class="d-flex align-items-center gap-2 text-success fw-bold mb-1">
                                    <i class="fas fa-check-circle fs-5"></i> Verified Driver
                                </div>
                                <p class="small text-muted mb-0">Your Driving License and identity documents have been verified.</p>
                            </div>
                        @else
                            <div class="p-3 bg-warning bg-opacity-10 border border-warning border-opacity-25 rounded-3 mb-3">
                                <div class="d-flex align-items-center gap-2 text-warning fw-bold mb-1">
                                    <i class="fas fa-exclamation-triangle fs-5"></i> Verification Required
                                </div>
                                <p class="small text-muted mb-0">Upload your Driving License or Aadhaar card to unlock seamless vehicle pickup.</p>
                            </div>
                        @endif

                        <div class="list-group list-group-flush border-0">
                            <div class="list-group-item px-0 d-flex justify-content-between align-items-center border-0 py-2">
                                <span class="small text-muted"><i class="fas fa-phone me-2 text-primary"></i> Phone</span>
                                <span class="fw-medium small">{{ auth()->user()->phone ?? 'Not provided' }}</span>
                            </div>
                            <div class="list-group-item px-0 d-flex justify-content-between align-items-center border-0 py-2">
                                <span class="small text-muted"><i class="fas fa-envelope me-2 text-primary"></i> Email</span>
                                <span class="fw-medium small">{{ auth()->user()->email }}</span>
                            </div>
                            <div class="list-group-item px-0 d-flex justify-content-between align-items-center border-0 py-2">
                                <span class="small text-muted"><i class="fas fa-map-marker-alt me-2 text-primary"></i> City</span>
                                <span class="fw-medium small">{{ auth()->user()->city ?? 'Ahmedabad' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Booking History -->
        <div class="row" data-aos="fade-up">
            <div class="col-12">
                <div class="dashboard-card">
                    <div class="card-header-custom">
                        <h5><i class="fas fa-history me-2 text-primary"></i> Booking History</h5>
                    </div>
                    <div class="card-body-custom">
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
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($recentBookings as $booking)
                                            <tr>
                                                <td class="fw-semibold text-primary">{{ $booking->booking_number }}</td>
                                                <td>{{ $booking->car->brand }} {{ $booking->car->model }}</td>
                                                <td>{{ $booking->pickup_date->format('d M Y') }}</td>
                                                <td>{{ $booking->return_date->format('d M Y') }}</td>
                                                <td class="fw-bold">₹{{ number_format($booking->total_amount, 0) }}</td>
                                                <td>
                                                    <span class="badge-status {{ $booking->status_badge }}">
                                                        {{ $booking->status }}
                                                    </span>
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
