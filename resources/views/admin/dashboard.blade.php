@extends('layouts.admin')

@section('title', 'Admin Command Center — AutoLux')
@section('page_title', 'Dashboard & Command Center')

@section('content')
<div class="container-fluid px-0">
        
        <!-- Command Center Hero Banner -->
        <div class="mb-4" data-aos="fade-down">
            <div class="p-4 p-md-5 rounded-4 text-white shadow-lg position-relative overflow-hidden" 
                 style="background: linear-gradient(135deg, #0a1628 0%, #153663 50%, #1a4a8a 100%); border: 1px solid rgba(255,255,255,0.1);">
                
                <!-- Ambient Accent Orbs -->
                <div class="position-absolute rounded-circle" style="width: 300px; height: 300px; background: rgba(255, 122, 0, 0.15); filter: blur(70px); top: -60px; right: -50px;"></div>
                <div class="position-absolute rounded-circle" style="width: 220px; height: 220px; background: rgba(37, 99, 235, 0.2); filter: blur(50px); bottom: -40px; left: 15%;"></div>

                <div class="row align-items-center position-relative" style="z-index: 2;">
                    <div class="col-lg-7 mb-3 mb-lg-0">
                        <div class="d-inline-flex align-items-center gap-2 bg-white bg-opacity-10 border border-white border-opacity-15 rounded-pill px-3 py-1 mb-3 small">
                            <span class="d-inline-block rounded-circle bg-success" style="width: 8px; height: 8px; box-shadow: 0 0 8px #10b981;"></span>
                            <span class="text-white-50 fw-semibold fs-7">System Operational &nbsp;•&nbsp; MySQL & Instant UPI Gateway Connected</span>
                        </div>

                        <h1 class="fw-bold text-white font-display fs-2 mb-2">AutoLux Command Center</h1>
                        <p class="text-white-50 mb-0 max-w-2xl">
                            Real-time overview of car availability, customer reservations, driver verification approvals, and monthly revenue.
                        </p>
                    </div>

                    <!-- Quick Command Action Shortcuts -->
                    <div class="col-lg-5 text-lg-end">
                        <div class="d-flex flex-wrap gap-2 justify-content-lg-end">
                            <a href="{{ route('admin.cars.create') }}" class="btn rounded-pill px-3 py-2 fw-bold text-white shadow" style="background: linear-gradient(135deg, #ff7a00, #ea580c); border: none;">
                                <i class="fas fa-plus-circle me-1"></i> Add Vehicle
                            </a>
                            <a href="{{ route('admin.documents.index') }}" class="btn btn-outline-light rounded-pill px-3 py-2 fw-medium position-relative">
                                <i class="fas fa-id-card me-1"></i> Verifications
                                @if($stats['pending_documents'] > 0)
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                        {{ $stats['pending_documents'] }}
                                    </span>
                                @endif
                            </a>
                            <a href="{{ route('admin.reports.index') }}" class="btn btn-outline-light rounded-pill px-3 py-2 fw-medium">
                                <i class="fas fa-chart-line me-1"></i> Reports
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Master KPI Stat Cards -->
        <div class="row g-4 mb-4">
            
            <!-- Customers -->
            <div class="col-xl-3 col-sm-6" data-aos="fade-up" data-aos-delay="100">
                <div class="stat-card border-0 shadow-sm p-4 rounded-4 bg-white position-relative overflow-hidden">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <span class="stat-label text-muted fw-bold small text-uppercase">Registered Customers</span>
                        <div class="stat-icon p-3 rounded-3" style="background: rgba(37, 99, 235, 0.1); color: #2563eb;">
                            <i class="fas fa-users fs-4"></i>
                        </div>
                    </div>
                    <div class="stat-value font-display fs-2 fw-bold text-dark">{{ $stats['total_customers'] }}</div>
                    <div class="small text-muted mt-2">
                        <span class="text-success fw-semibold"><i class="fas fa-user-check me-1"></i> Active Driver Accounts</span>
                    </div>
                </div>
            </div>

            <!-- Total car Count -->
            <div class="col-xl-3 col-sm-6" data-aos="fade-up" data-aos-delay="200">
                <div class="stat-card border-0 shadow-sm p-4 rounded-4 bg-white position-relative overflow-hidden">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <span class="stat-label text-muted fw-bold small text-uppercase">car Vehicles</span>
                        <div class="stat-icon p-3 rounded-3" style="background: rgba(16, 185, 129, 0.1); color: #10b981;">
                            <i class="fas fa-car-side fs-4"></i>
                        </div>
                    </div>
                    <div class="stat-value font-display fs-2 fw-bold text-dark">{{ $stats['total_vehicles'] }}</div>
                    <div class="small text-muted mt-2">
                        <span class="text-primary fw-semibold">{{ $stats['available_vehicles'] }} Available</span> &nbsp;|&nbsp; 
                        <span class="text-danger fw-semibold">{{ $stats['booked_vehicles'] }} Rented</span>
                    </div>
                </div>
            </div>

            <!-- Active Reservations -->
            <div class="col-xl-3 col-sm-6" data-aos="fade-up" data-aos-delay="300">
                <div class="stat-card border-0 shadow-sm p-4 rounded-4 bg-white position-relative overflow-hidden">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <span class="stat-label text-muted fw-bold small text-uppercase">Active Bookings</span>
                        <div class="stat-icon p-3 rounded-3" style="background: rgba(245, 158, 11, 0.1); color: #f59e0b;">
                            <i class="fas fa-calendar-check fs-4"></i>
                        </div>
                    </div>
                    <div class="stat-value font-display fs-2 fw-bold text-dark">{{ $stats['active_bookings'] }}</div>
                    <div class="small text-muted mt-2">
                        @if($stats['pending_bookings'] > 0)
                            <span class="text-warning fw-bold"><i class="fas fa-clock me-1"></i> {{ $stats['pending_bookings'] }} Pending Approval</span>
                        @else
                            <span class="text-success fw-semibold"><i class="fas fa-check-double me-1"></i> All reservations processed</span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Total System Revenue -->
            <div class="col-xl-3 col-sm-6" data-aos="fade-up" data-aos-delay="400">
                <div class="stat-card border-0 shadow-sm p-4 rounded-4 bg-white position-relative overflow-hidden">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <span class="stat-label text-muted fw-bold small text-uppercase">Total System Revenue</span>
                        <div class="stat-icon p-3 rounded-3" style="background: rgba(239, 68, 68, 0.1); color: #ef4444;">
                            <i class="fas fa-wallet fs-4"></i>
                        </div>
                    </div>
                    <div class="stat-value font-display fs-2 fw-bold text-dark">₹{{ number_format($stats['total_revenue'], 0) }}</div>
                    <div class="small text-muted mt-2">
                        <span class="text-dark fw-semibold">₹{{ number_format($stats['monthly_revenue'], 0) }}</span> this month
                    </div>
                </div>
            </div>
        </div>

        <!-- car Breakdown & Driver Verification Queue Row -->
        <div class="row g-4 mb-4">
            
            <!-- car Status Breakdown Widget -->
            <div class="col-lg-4" data-aos="fade-up">
                <div class="dashboard-card border-0 shadow-sm rounded-4 bg-white overflow-hidden h-100">
                    <div class="card-header-custom bg-white p-4 border-bottom d-flex align-items-center justify-content-between">
                        <h5 class="fw-bold mb-0 text-dark"><i class="fas fa-chart-pie me-2 text-primary"></i> car Status Breakdown</h5>
                        <a href="{{ route('admin.cars.index') }}" class="small text-primary fw-semibold text-decoration-none">Manage Cars</a>
                    </div>
                    <div class="card-body-custom p-4">
                        
                        <!-- Visual Occupancy Bar -->
                        @php
                            $totalV = max(1, $stats['total_vehicles']);
                            $availPct = round(($stats['available_vehicles'] / $totalV) * 100);
                            $bookedPct = round(($stats['booked_vehicles'] / $totalV) * 100);
                            $maintPct = round(($stats['maintenance_vehicles'] / $totalV) * 100);
                        @endphp

                        <div class="mb-3">
                            <div class="d-flex justify-content-between small fw-bold mb-1">
                                <span class="text-muted">car Utilization Rate</span>
                                <span class="text-dark">{{ $bookedPct }}% Rented</span>
                            </div>
                            <div class="progress rounded-pill" style="height: 12px; background: #e5e7eb;">
                                <div class="progress-bar bg-success rounded-start-pill" style="width: {{ $availPct }}%" title="Available"></div>
                                <div class="progress-bar bg-danger" style="width: {{ $bookedPct }}%" title="Booked"></div>
                                <div class="progress-bar bg-warning rounded-end-pill" style="width: {{ $maintPct }}%" title="Maintenance"></div>
                            </div>
                        </div>

                        <div class="list-group list-group-flush border-0 mb-3">
                            <div class="list-group-item px-0 d-flex justify-content-between align-items-center border-0 py-2">
                                <span class="text-muted"><i class="fas fa-circle text-success me-2 fs-6"></i> Available for Rent</span>
                                <span class="badge bg-success rounded-pill px-3 py-2 fw-bold fs-7">{{ $stats['available_vehicles'] }}</span>
                            </div>
                            <div class="list-group-item px-0 d-flex justify-content-between align-items-center border-0 py-2">
                                <span class="text-muted"><i class="fas fa-circle text-danger me-2 fs-6"></i> Currently Booked / Rented</span>
                                <span class="badge bg-danger rounded-pill px-3 py-2 fw-bold fs-7">{{ $stats['booked_vehicles'] }}</span>
                            </div>
                            <div class="list-group-item px-0 d-flex justify-content-between align-items-center border-0 py-2">
                                <span class="text-muted"><i class="fas fa-circle text-warning me-2 fs-6"></i> Under Maintenance</span>
                                <span class="badge bg-warning text-dark rounded-pill px-3 py-2 fw-bold fs-7">{{ $stats['maintenance_vehicles'] }}</span>
                            </div>
                        </div>

                        <div class="p-3 bg-light rounded-3">
                            <div class="d-flex align-items-center gap-2 small fw-bold text-dark mb-1">
                                <i class="fas fa-wrench text-warning"></i> Maintenance Control
                            </div>
                            <p class="small text-muted mb-2">Track vehicle servicing schedules and repair logs.</p>
                            <a href="{{ route('admin.maintenance.index') }}" class="btn btn-sm btn-outline-dark rounded-pill px-3">
                                View Maintenance Logs
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Driver ID Verification Queue Widget -->
            <div class="col-lg-8" data-aos="fade-up" data-aos-delay="100">
                <div class="dashboard-card border-0 shadow-sm rounded-4 bg-white overflow-hidden h-100">
                    <div class="card-header-custom bg-white p-4 border-bottom d-flex align-items-center justify-content-between">
                        <h5 class="fw-bold mb-0 text-dark">
                            <i class="fas fa-id-card me-2 text-primary"></i> Driver Verification Approvals Queue
                        </h5>
                        <a href="{{ route('admin.documents.index') }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                            View All Queue ({{ $stats['pending_documents'] }})
                        </a>
                    </div>
                    <div class="card-body-custom p-4">
                        @if(isset($pendingDocumentsList) && $pendingDocumentsList->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-modern align-middle mb-0">
                                    <thead>
                                        <tr>
                                            <th>Customer Name</th>
                                            <th>Doc Type</th>
                                            <th>Submitted</th>
                                            <th>File Preview</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($pendingDocumentsList as $doc)
                                            <tr>
                                                <td>
                                                    <div class="fw-bold text-dark">{{ $doc->user->name }}</div>
                                                    <small class="text-muted">{{ $doc->user->email }}</small>
                                                </td>
                                                <td class="fw-bold text-dark">{{ $doc->type }}</td>
                                                <td class="small text-muted">{{ $doc->created_at->diffForHumans() }}</td>
                                                <td>
                                                    <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank" class="btn btn-sm btn-outline-secondary rounded-pill px-3">
                                                        <i class="fas fa-eye me-1"></i> View Doc
                                                    </a>
                                                </td>
                                                <td>
                                                    <div class="d-flex gap-1">
                                                        <form action="{{ route('admin.documents.approve', $doc->id) }}" method="POST">
                                                            @csrf
                                                            <button type="submit" class="btn btn-sm btn-success rounded-pill px-3">
                                                                Approve
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-4">
                                <div class="d-inline-flex align-items-center justify-content-center rounded-circle p-3 mb-2" style="background: rgba(16, 185, 129, 0.1); color: #10b981;">
                                    <i class="fas fa-check-circle fs-3"></i>
                                </div>
                                <h6 class="fw-bold text-dark mb-1">No Pending ID Approvals</h6>
                                <p class="small text-muted mb-0">All submitted driver licenses and identity proofs have been processed.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Customer Reservations Table -->
        <div class="row g-4 mb-4" data-aos="fade-up">
            <div class="col-12">
                <div class="dashboard-card border-0 shadow-sm rounded-4 bg-white overflow-hidden">
                    <div class="card-header-custom bg-white p-4 border-bottom d-flex align-items-center justify-content-between flex-wrap gap-2">
                        <h5 class="fw-bold mb-0 text-dark">
                            <i class="fas fa-list-check me-2 text-primary"></i> Live Reservations Command Stream
                        </h5>
                        <a href="{{ route('admin.bookings.index') }}" class="btn btn-sm btn-primary rounded-pill px-4" style="background: linear-gradient(135deg, #ff7a00, #ea580c); border: none;">
                            View All Reservations <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                    <div class="card-body-custom p-4">
                        @if($recentBookings->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-modern align-middle mb-0">
                                    <thead>
                                        <tr>
                                            <th>Booking #</th>
                                            <th>Customer Details</th>
                                            <th>Vehicle</th>
                                            <th>Rental Dates</th>
                                            <th>Amount</th>
                                            <th>Status</th>
                                            <th>Update Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($recentBookings as $booking)
                                            <tr>
                                                <td class="fw-bold text-primary">{{ $booking->booking_number }}</td>
                                                <td>
                                                    <div class="fw-bold text-dark">{{ $booking->user->name }}</div>
                                                    <small class="text-muted">{{ $booking->user->phone ?? $booking->user->email }}</small>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center gap-2">
                                                        <div class="rounded-2 overflow-hidden bg-light border" style="width: 50px; height: 35px; flex-shrink: 0;">
                                                            @if($booking->car->thumbnail)
                                                                <img src="{{ asset('storage/' . $booking->car->thumbnail) }}" class="w-100 h-100 object-fit-cover">
                                                            @else
                                                                <div class="d-flex align-items-center justify-content-center h-100 text-primary">
                                                                    <i class="fas fa-car small"></i>
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <div>
                                                            <div class="fw-bold text-dark fs-7">{{ $booking->car->brand }} {{ $booking->car->model }}</div>
                                                            <small class="text-muted fs-7">{{ $booking->car->registration_number }}</small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="small">
                                                    <div class="fw-semibold text-dark">{{ $booking->pickup_date->format('d M') }} - {{ $booking->return_date->format('d M Y') }}</div>
                                                    <div class="text-muted fs-7">{{ $booking->pickup_location }}</div>
                                                </td>
                                                <td class="fw-bold text-dark fs-6">
                                                    ₹{{ number_format($booking->total_amount, 0) }}
                                                </td>
                                                <td>
                                                    <span class="badge-status {{ $booking->status_badge }}">
                                                        {{ $booking->status }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <form action="{{ route('admin.bookings.status', $booking->id) }}" method="POST" class="d-flex align-items-center gap-1">
                                                        @csrf
                                                        <select name="status" class="form-select form-select-sm py-1 px-2 border-2" style="font-size: 0.8rem;">
                                                            @foreach(['Pending', 'Confirmed', 'Active', 'Completed', 'Cancelled'] as $st)
                                                                <option value="{{ $st }}" {{ $booking->status == $st ? 'selected' : '' }}>{{ $st }}</option>
                                                            @endforeach
                                                        </select>
                                                        <button type="submit" class="btn btn-sm btn-primary py-1 px-2" title="Save Status"><i class="fas fa-check"></i></button>
                                                    </form>
                                                </td>
                                                <td>
                                                    <a href="{{ route('bookings.show', $booking->id) }}" class="btn btn-sm btn-outline-secondary rounded-circle" target="_blank" title="View Invoice">
                                                        <i class="fas fa-receipt"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-5">
                                <p class="text-muted mb-0">No bookings recorded in the system yet.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Payments Audit Stream -->
        <div class="row" data-aos="fade-up">
            <div class="col-12">
                <div class="dashboard-card border-0 shadow-sm rounded-4 bg-white overflow-hidden">
                    <div class="card-header-custom bg-white p-4 border-bottom d-flex align-items-center justify-content-between">
                        <h5 class="fw-bold mb-0 text-dark"><i class="fas fa-receipt me-2 text-primary"></i> Real-time Payment Audit Log</h5>
                        <a href="{{ route('admin.reports.index') }}" class="small text-primary fw-semibold text-decoration-none">Full Audit Reports</a>
                    </div>
                    <div class="card-body-custom p-4">
                        @if($recentPayments->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-modern align-middle mb-0">
                                    <thead>
                                        <tr>
                                            <th>Txn ID</th>
                                            <th>Customer</th>
                                            <th>Vehicle</th>
                                            <th>Method</th>
                                            <th>Amount</th>
                                            <th>Status</th>
                                            <th>Timestamp</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($recentPayments as $pay)
                                            <tr>
                                                <td class="fw-bold text-primary">{{ $pay->transaction_id }}</td>
                                                <td>{{ $pay->user->name }}</td>
                                                <td>{{ $pay->booking && $pay->booking->car ? $pay->booking->car->brand . ' ' . $pay->booking->car->model : 'N/A' }}</td>
                                                <td><span class="badge bg-light text-dark border">{{ $pay->method }}</span></td>
                                                <td class="fw-bold text-success">₹{{ number_format($pay->amount, 0) }}</td>
                                                <td><span class="badge bg-success bg-opacity-10 text-success px-3 py-1 rounded-pill">PAID</span></td>
                                                <td class="small text-muted">{{ $pay->created_at->format('d M Y, h:i A') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-4">
                                <p class="text-muted mb-0">No payment transactions recorded yet.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
