@extends('layouts.app')

@section('title', 'Business Reports & Financial Audit — Admin')

@section('content')
<section class="dashboard-section pb-5">
    <div class="container">
        
        <!-- Header Banner Card -->
        <div class="mb-4" data-aos="fade-down">
            <div class="p-4 p-md-5 rounded-4 text-white shadow-lg position-relative overflow-hidden" 
                 style="background: linear-gradient(135deg, #0a1628 0%, #153663 50%, #1a4a8a 100%); border: 1px solid rgba(255,255,255,0.1);">
                <div class="row align-items-center position-relative" style="z-index: 2;">
                    <div class="col-lg-8">
                        <span class="badge bg-warning bg-opacity-25 text-warning border border-warning border-opacity-50 rounded-pill px-3 py-1 mb-2 small fw-bold">
                            <i class="fas fa-chart-pie me-1"></i> Business Intelligence
                        </span>
                        <h1 class="fw-bold text-white font-display fs-2 mb-2">Reports & Financial Analytics</h1>
                        <p class="text-white-50 mb-0 max-w-2xl">
                            Filter revenue stream audit logs, check trip performance metrics, and track completed payment transactions.
                        </p>
                    </div>
                    <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-light rounded-pill px-4 fw-medium">
                            <i class="fas fa-arrow-left me-2"></i> Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Date Range Filter Bar -->
        <div class="search-card mb-4 border-0 shadow-sm rounded-4 p-4 bg-white" data-aos="fade-up">
            <form action="{{ route('admin.reports.index') }}" method="GET">
                <div class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label class="form-label small fw-bold text-muted text-uppercase mb-1"><i class="fas fa-calendar-alt me-1 text-primary"></i> From Date</label>
                        <input type="date" name="from_date" class="form-control border-2" value="{{ $fromDate }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small fw-bold text-muted text-uppercase mb-1"><i class="fas fa-calendar-check me-1 text-primary"></i> To Date</label>
                        <input type="date" name="to_date" class="form-control border-2" value="{{ $toDate }}">
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-primary w-100 rounded-3 py-2 fw-bold shadow-sm" style="background: linear-gradient(135deg, #ff7a00, #ea580c); border: none; height: 46px;">
                            <i class="fas fa-filter me-2"></i> Filter Date Range
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Metric Stat Cards Row -->
        <div class="row g-4 mb-4">
            
            <!-- Total Revenue -->
            <div class="col-xl-3 col-sm-6" data-aos="fade-up" data-aos-delay="100">
                <div class="stat-card border-0 shadow-sm p-4 rounded-4 bg-white">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <span class="stat-label text-muted fw-bold small text-uppercase">Period Revenue</span>
                        <div class="stat-icon p-3 rounded-3" style="background: rgba(16, 185, 129, 0.1); color: #10b981;">
                            <i class="fas fa-indian-rupee-sign fs-4"></i>
                        </div>
                    </div>
                    <div class="stat-value font-display fs-2 fw-bold text-dark">₹{{ number_format($totalPeriodRevenue, 0) }}</div>
                    <div class="small text-muted mt-2">
                        <span class="text-success fw-semibold"><i class="fas fa-circle-check me-1"></i> Paid via Instant UPI</span>
                    </div>
                </div>
            </div>

            <!-- Total Reservations -->
            <div class="col-xl-3 col-sm-6" data-aos="fade-up" data-aos-delay="200">
                <div class="stat-card border-0 shadow-sm p-4 rounded-4 bg-white">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <span class="stat-label text-muted fw-bold small text-uppercase">Total Reservations</span>
                        <div class="stat-icon p-3 rounded-3" style="background: rgba(37, 99, 235, 0.1); color: #2563eb;">
                            <i class="fas fa-calendar-check fs-4"></i>
                        </div>
                    </div>
                    <div class="stat-value font-display fs-2 fw-bold text-dark">{{ $totalPeriodBookings }}</div>
                    <div class="small text-muted mt-2">
                        <span class="text-primary fw-semibold">In selected date range</span>
                    </div>
                </div>
            </div>

            <!-- Completed Trips -->
            <div class="col-xl-3 col-sm-6" data-aos="fade-up" data-aos-delay="300">
                <div class="stat-card border-0 shadow-sm p-4 rounded-4 bg-white">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <span class="stat-label text-muted fw-bold small text-uppercase">Completed Trips</span>
                        <div class="stat-icon p-3 rounded-3" style="background: rgba(245, 158, 11, 0.1); color: #f59e0b;">
                            <i class="fas fa-route fs-4"></i>
                        </div>
                    </div>
                    <div class="stat-value font-display fs-2 fw-bold text-dark">{{ $completedBookings }}</div>
                    <div class="small text-muted mt-2">
                        <span class="text-success fw-semibold"><i class="fas fa-flag-checkered me-1"></i> Returned & Inspected</span>
                    </div>
                </div>
            </div>

            <!-- Cancelled Bookings -->
            <div class="col-xl-3 col-sm-6" data-aos="fade-up" data-aos-delay="400">
                <div class="stat-card border-0 shadow-sm p-4 rounded-4 bg-white">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <span class="stat-label text-muted fw-bold small text-uppercase">Cancelled Bookings</span>
                        <div class="stat-icon p-3 rounded-3" style="background: rgba(239, 68, 68, 0.1); color: #ef4444;">
                            <i class="fas fa-ban fs-4"></i>
                        </div>
                    </div>
                    <div class="stat-value font-display fs-2 fw-bold text-dark">{{ $cancelledBookings }}</div>
                    <div class="small text-muted mt-2">
                        <span class="text-danger fw-semibold">Refunds processed</span>
                    </div>
                </div>
            </div>

        </div>

        <!-- Audit Payment Table -->
        <div class="dashboard-card border-0 shadow-sm rounded-4 bg-white overflow-hidden" data-aos="fade-up">
            <div class="card-header-custom bg-white p-4 border-bottom d-flex align-items-center justify-content-between">
                <h5 class="fw-bold mb-0 text-dark">
                    <i class="fas fa-receipt me-2 text-primary"></i> Financial Payment Audit Stream
                </h5>
                <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3">{{ $payments->count() }} Transactions</span>
            </div>
            <div class="card-body-custom p-4">
                @if($payments->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-modern align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>Txn ID</th>
                                    <th>Booking #</th>
                                    <th>Customer</th>
                                    <th>Vehicle</th>
                                    <th>Payment Method</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Date & Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($payments as $pay)
                                    <tr>
                                        <td class="fw-bold text-primary">{{ $pay->transaction_id }}</td>
                                        <td class="fw-bold text-dark">{{ $pay->booking ? $pay->booking->booking_number : 'N/A' }}</td>
                                        <td>
                                            <div class="fw-bold text-dark">{{ $pay->user->name }}</div>
                                            <small class="text-muted">{{ $pay->user->email }}</small>
                                        </td>
                                        <td>{{ $pay->booking && $pay->booking->car ? $pay->booking->car->brand . ' ' . $pay->booking->car->model : 'N/A' }}</td>
                                        <td><span class="badge bg-light text-dark border">{{ $pay->method }}</span></td>
                                        <td class="fw-bold text-success fs-6">₹{{ number_format($pay->amount, 0) }}</td>
                                        <td>
                                            <span class="badge bg-success bg-opacity-10 text-success px-3 py-1 rounded-pill fw-semibold">
                                                SUCCESS
                                            </span>
                                        </td>
                                        <td class="small text-muted">{{ $pay->created_at->format('d M Y, h:i A') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-5 text-muted">
                        <i class="fas fa-receipt display-4 opacity-25 mb-3 text-primary d-block"></i>
                        <h6 class="fw-bold text-dark mb-1">No Transactions Found</h6>
                        <p class="small text-muted mb-0">No completed payment transactions logged for the selected date range.</p>
                    </div>
                @endif
            </div>
        </div>

    </div>
</section>
@endsection
