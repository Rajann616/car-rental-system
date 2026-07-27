@extends('layouts.app')

@section('title', 'Business Reports & Analytics — Admin')

@section('content')
<section class="dashboard-section pb-5">
    <div class="container">
        <!-- Header -->
        <div class="dashboard-header d-flex align-items-center justify-content-between flex-wrap gap-3" data-aos="fade-down">
            <div>
                <h1 class="fw-bold mb-1">Financial & car Reports</h1>
                <p class="text-muted mb-0">Track revenue performance, booking statistics, and vehicle utilization.</p>
            </div>
            <div>
                <button onclick="window.print()" class="btn btn-outline-secondary rounded-pill px-3">
                    <i class="fas fa-print me-1"></i> Print Summary
                </button>
            </div>
        </div>

        <!-- Date Filter Card -->
        <div class="dashboard-card mb-4" data-aos="fade-up">
            <div class="card-body-custom">
                <form action="{{ route('admin.reports.index') }}" method="GET" class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label class="form-label small fw-bold">From Date</label>
                        <input type="date" name="start_date" class="form-control" value="{{ $startDate->format('Y-m-d') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small fw-bold">To Date</label>
                        <input type="date" name="end_date" class="form-control" value="{{ $endDate->format('Y-m-d') }}">
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-primary rounded-pill w-100">
                            <i class="fas fa-filter me-1"></i> Filter Date Range
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Report KPI Cards -->
        <div class="row g-4 mb-4" data-aos="fade-up">
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-icon green"><i class="fas fa-rupee-sign"></i></div>
                    <div class="stat-value">₹{{ number_format($totalRevenue, 0) }}</div>
                    <div class="stat-label">Total Period Revenue</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-icon blue"><i class="fas fa-car-side"></i></div>
                    <div class="stat-value">{{ $totalBookingsCount }}</div>
                    <div class="stat-label">Total Reservations</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-icon amber"><i class="fas fa-check-double"></i></div>
                    <div class="stat-value">{{ $completedBookingsCount }}</div>
                    <div class="stat-label">Completed Trips</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-icon red"><i class="fas fa-ban"></i></div>
                    <div class="stat-value">{{ $cancelledBookingsCount }}</div>
                    <div class="stat-label">Cancelled Bookings</div>
                </div>
            </div>
        </div>

        <!-- Transaction Logs Table -->
        <div class="dashboard-card" data-aos="fade-up">
            <div class="card-header-custom">
                <h5><i class="fas fa-receipt me-2 text-primary"></i> Financial Payment Audit Log</h5>
            </div>
            <div class="card-body-custom">
                <div class="table-responsive">
                    <table class="table table-modern align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Txn ID</th>
                                <th>Booking #</th>
                                <th>Customer</th>
                                <th>Car</th>
                                <th>Method</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($payments as $p)
                                <tr>
                                    <td class="fw-semibold text-secondary">{{ $p->transaction_id }}</td>
                                    <td class="text-primary fw-bold">{{ $p->booking ? $p->booking->booking_number : '—' }}</td>
                                    <td>{{ $p->user->name }}</td>
                                    <td>{{ $p->booking && $p->booking->car ? $p->booking->car->brand . ' ' . $p->booking->car->model : 'N/A' }}</td>
                                    <td><span class="badge bg-light text-dark border">{{ $p->method }}</span></td>
                                    <td class="fw-bold text-success">₹{{ number_format($p->amount, 0) }}</td>
                                    <td>
                                        <span class="badge-status {{ $p->status_badge }}">
                                            {{ $p->status }}
                                        </span>
                                    </td>
                                    <td class="small">{{ $p->created_at->format('d M Y, h:i A') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-4 text-muted">No transactions found for selected date range.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-center mt-4">
                    {{ $payments->links() }}
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
