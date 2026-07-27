@extends('layouts.app')

@section('title', 'Admin Dashboard — AutoLux')

@section('content')
<section class="dashboard-section pb-5">
    <div class="container">
        <!-- Header -->
        <div class="dashboard-header d-flex align-items-center justify-content-between flex-wrap gap-3" data-aos="fade-down">
            <div>
                <h1 class="fw-bold mb-1">Admin Command Center 🛠️</h1>
                <p class="text-muted mb-0">System performance, vehicle availability, booking tracking & revenue analytics.</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('home') }}#fleet" class="btn btn-outline-primary rounded-pill px-3">
                    <i class="fas fa-eye me-1"></i> View Live Fleet
                </a>
            </div>
        </div>

        <!-- System Stats Cards -->
        <div class="row g-4 mb-4">
            <div class="col-xl-3 col-sm-6" data-aos="fade-up" data-aos-delay="100">
                <div class="stat-card">
                    <div class="stat-icon blue"><i class="fas fa-users"></i></div>
                    <div class="stat-value">{{ $stats['total_customers'] }}</div>
                    <div class="stat-label">Registered Customers</div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6" data-aos="fade-up" data-aos-delay="200">
                <div class="stat-card">
                    <div class="stat-icon green"><i class="fas fa-car-side"></i></div>
                    <div class="stat-value">{{ $stats['total_vehicles'] }}</div>
                    <div class="stat-label">Total Fleet Count</div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6" data-aos="fade-up" data-aos-delay="300">
                <div class="stat-card">
                    <div class="stat-icon amber"><i class="fas fa-calendar-check"></i></div>
                    <div class="stat-value">{{ $stats['active_bookings'] }}</div>
                    <div class="stat-label">Active Bookings</div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6" data-aos="fade-up" data-aos-delay="400">
                <div class="stat-card">
                    <div class="stat-icon red"><i class="fas fa-wallet"></i></div>
                    <div class="stat-value">₹{{ number_format($stats['total_revenue'], 0) }}</div>
                    <div class="stat-label">Total System Revenue</div>
                </div>
            </div>
        </div>

        <!-- Fleet Distribution & Recent Bookings -->
        <div class="row g-4 mb-4">
            <div class="col-lg-4" data-aos="fade-up">
                <div class="dashboard-card h-100">
                    <div class="card-header-custom">
                        <h5><i class="fas fa-chart-pie me-2 text-primary"></i> Fleet Status Breakdown</h5>
                    </div>
                    <div class="card-body-custom">
                        <div class="list-group list-group-flush border-0">
                            <div class="list-group-item px-0 d-flex justify-content-between align-items-center border-0 py-2">
                                <span class="text-muted"><i class="fas fa-circle text-success me-2 fs-6"></i> Available for Rent</span>
                                <span class="badge bg-success rounded-pill px-3">{{ $stats['available_vehicles'] }}</span>
                            </div>
                            <div class="list-group-item px-0 d-flex justify-content-between align-items-center border-0 py-2">
                                <span class="text-muted"><i class="fas fa-circle text-danger me-2 fs-6"></i> Currently Booked</span>
                                <span class="badge bg-danger rounded-pill px-3">{{ $stats['booked_vehicles'] }}</span>
                            </div>
                            <div class="list-group-item px-0 d-flex justify-content-between align-items-center border-0 py-2">
                                <span class="text-muted"><i class="fas fa-circle text-warning me-2 fs-6"></i> Under Maintenance</span>
                                <span class="badge bg-warning text-dark rounded-pill px-3">{{ $stats['maintenance_vehicles'] }}</span>
                            </div>
                        </div>
                        <hr>
                        <div class="p-3 bg-light rounded-3">
                            <div class="small fw-bold text-dark mb-1">Quick Action</div>
                            <p class="small text-muted mb-0">System status: All services operational. MySQL database connected.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-8" data-aos="fade-up" data-aos-delay="100">
                <div class="dashboard-card">
                    <div class="card-header-custom">
                        <h5><i class="fas fa-list-check me-2 text-primary"></i> Recent Reservations</h5>
                    </div>
                    <div class="card-body-custom">
                        @if($recentBookings->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-modern align-middle mb-0">
                                    <thead>
                                        <tr>
                                            <th>Booking #</th>
                                            <th>Customer</th>
                                            <th>Car</th>
                                            <th>Dates</th>
                                            <th>Amount</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($recentBookings as $booking)
                                            <tr>
                                                <td class="fw-semibold text-primary">{{ $booking->booking_number }}</td>
                                                <td>{{ $booking->user->name }}</td>
                                                <td>{{ $booking->car->brand }} {{ $booking->car->model }}</td>
                                                <td class="small">{{ $booking->pickup_date->format('d/m') }} - {{ $booking->return_date->format('d/m/Y') }}</td>
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
                                <p class="text-muted mb-0">No bookings recorded yet.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
