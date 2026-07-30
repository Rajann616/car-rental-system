@extends('layouts.app')

@section('title', 'Reservation Management — Admin')

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
                            <i class="fas fa-list-check me-1"></i> Reservations Command Stream
                        </span>
                        <h1 class="fw-bold text-white font-display fs-2 mb-2">Reservation Management</h1>
                        <p class="text-white-50 mb-0 max-w-2xl">
                            Monitor customer reservations, verify payment transactions, and update booking statuses in real time.
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

        <!-- Reservations Master Table Card -->
        <div class="dashboard-card border-0 shadow-sm rounded-4 bg-white overflow-hidden" data-aos="fade-up">
            <div class="card-header-custom bg-white p-4 border-bottom d-flex align-items-center justify-content-between flex-wrap gap-2">
                <h5 class="fw-bold mb-0 text-dark">
                    <i class="fas fa-calendar-check me-2 text-primary"></i> All Customer Reservations ({{ $bookings->total() }})
                </h5>
                <form action="{{ route('admin.bookings.index') }}" method="GET" class="d-flex gap-2">
                    <input type="text" name="search" class="form-control form-control-sm border-2" placeholder="Search number, user..." value="{{ request('search') }}">
                    <select name="status" class="form-select form-select-sm border-2" onchange="this.form.submit()">
                        <option value="">All Statuses</option>
                        <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                        <option value="Confirmed" {{ request('status') == 'Confirmed' ? 'selected' : '' }}>Confirmed</option>
                        <option value="Active" {{ request('status') == 'Active' ? 'selected' : '' }}>Active</option>
                        <option value="Completed" {{ request('status') == 'Completed' ? 'selected' : '' }}>Completed</option>
                        <option value="Cancelled" {{ request('status') == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </form>
            </div>
            <div class="card-body-custom p-4">
                <div class="table-responsive">
                    <table class="table table-modern align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Booking #</th>
                                <th>Customer</th>
                                <th>Vehicle</th>
                                <th>Rental Period</th>
                                <th>Total Amount</th>
                                <th>Status</th>
                                <th style="min-width: 175px;">Update Status</th>
                                <th class="text-end pe-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($bookings as $booking)
                                <tr>
                                    <td class="fw-bold text-primary fs-6">{{ $booking->booking_number }}</td>
                                    <td>
                                        <div class="fw-bold text-dark">{{ $booking->user->name }}</div>
                                        <small class="text-muted">{{ $booking->user->email }}</small>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="rounded-2 overflow-hidden bg-light border" style="width: 55px; height: 40px; flex-shrink: 0;">
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
                                        <div class="fw-semibold text-dark"><i class="fas fa-calendar-alt text-primary me-1"></i> {{ $booking->pickup_date->format('d M') }} — {{ $booking->return_date->format('d M Y') }}</div>
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
                                        <form action="{{ route('admin.bookings.status', $booking->id) }}" method="POST" class="d-flex align-items-center gap-2" style="min-width: 170px;">
                                            @csrf
                                            <select name="status" class="form-select form-select-sm border-2 rounded-3 fw-semibold text-dark shadow-sm flex-grow-1" style="font-size: 0.82rem; min-width: 125px;" onchange="this.form.submit()">
                                                @foreach(['Pending', 'Confirmed', 'Active', 'Completed', 'Cancelled'] as $st)
                                                    <option value="{{ $st }}" {{ $booking->status == $st ? 'selected' : '' }}>{{ $st }}</option>
                                                @endforeach
                                            </select>
                                            <button type="submit" class="btn btn-sm btn-primary rounded-3 px-2 py-1 flex-shrink-0 shadow-sm" title="Save Status">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </form>
                                    </td>
                                    <td>
                                        <a href="{{ route('bookings.show', $booking->id) }}" class="btn btn-sm btn-outline-secondary rounded-circle" target="_blank" title="View Invoice">
                                            <i class="fas fa-receipt"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-5 text-muted">No customer reservations found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-center mt-4">
                    {{ $bookings->links() }}
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
