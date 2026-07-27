@extends('layouts.app')

@section('title', 'Booking History — AutoLux')

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
                            <i class="fas fa-history me-1"></i> Rental Records
                        </span>
                        <h1 class="fw-bold text-white font-display fs-2 mb-2">Booking History & Reservations</h1>
                        <p class="text-white-50 mb-0 max-w-2xl">
                            Track your active vehicle checkouts, download PDF rental invoices, or manage upcoming bookings.
                        </p>
                    </div>
                    <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                        <a href="{{ route('cars.index') }}" class="btn btn-lg rounded-pill px-4 fw-bold text-white shadow-lg" style="background: linear-gradient(135deg, #ff7a00, #ea580c); border: none;">
                            <i class="fas fa-plus-circle me-2"></i> Book New Vehicle
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bookings History Card -->
        <div class="dashboard-card border-0 shadow-sm rounded-4 bg-white overflow-hidden" data-aos="fade-up">
            <div class="card-header-custom bg-white p-4 border-bottom d-flex align-items-center justify-content-between flex-wrap gap-2">
                <h5 class="fw-bold mb-0 text-dark">
                    <i class="fas fa-list-check me-2 text-primary"></i> All Rental Reservations ({{ $bookings->total() }})
                </h5>
                <div class="d-flex align-items-center gap-2">
                    <a href="{{ route('customer.dashboard') }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3">
                        <i class="fas fa-arrow-left me-1"></i> Dashboard
                    </a>
                </div>
            </div>
            
            <div class="card-body-custom p-4">
                @if($bookings->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-modern align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>Booking #</th>
                                    <th>Vehicle Details</th>
                                    <th>Pickup Date</th>
                                    <th>Return Date</th>
                                    <th>Total Amount</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($bookings as $booking)
                                    <tr>
                                        <td>
                                            <span class="fw-bold text-primary fs-6">{{ $booking->booking_number }}</span>
                                            <div class="small text-muted">{{ $booking->created_at->format('d M Y') }}</div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center gap-3">
                                                <div class="rounded-3 overflow-hidden bg-light border" style="width: 70px; height: 50px; flex-shrink: 0;">
                                                    @if($booking->car->thumbnail)
                                                        <img src="{{ asset('storage/' . $booking->car->thumbnail) }}" class="w-100 h-100 object-fit-cover">
                                                    @else
                                                        <div class="d-flex align-items-center justify-content-center h-100 text-primary">
                                                            <i class="fas fa-car fs-4"></i>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div>
                                                    <div class="fw-bold text-dark fs-6">{{ $booking->car->brand }} {{ $booking->car->model }}</div>
                                                    <small class="text-muted">{{ $booking->car->fuel_type }} | Reg: {{ $booking->car->registration_number }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="fw-semibold text-dark"><i class="fas fa-calendar-alt text-primary me-1"></i> {{ $booking->pickup_date->format('d M Y') }}</div>
                                            <small class="text-muted">{{ $booking->pickup_location }}</small>
                                        </td>
                                        <td>
                                            <div class="fw-semibold text-dark"><i class="fas fa-calendar-check text-primary me-1"></i> {{ $booking->return_date->format('d M Y') }}</div>
                                            <small class="text-muted">{{ $booking->rental_days }} Days Total</small>
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
                                            <div class="d-flex gap-2">
                                                <a href="{{ route('bookings.show', $booking->id) }}" class="btn btn-sm btn-outline-primary rounded-pill px-3" title="View & Print Invoice">
                                                    <i class="fas fa-receipt me-1"></i> Invoice
                                                </a>
                                                @if($booking->canBeCancelled())
                                                    <form action="{{ route('bookings.cancel', $booking->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel this booking reservation?');">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3">Cancel</button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Clean Centered Bootstrap 5 Pagination -->
                    <div class="d-flex justify-content-center mt-4">
                        {{ $bookings->links() }}
                    </div>
                @else
                    <div class="text-center py-5">
                        <div class="mb-3">
                            <div class="d-inline-flex align-items-center justify-content-center rounded-circle p-4" style="background: rgba(37, 99, 235, 0.08); color: #2563eb;">
                                <i class="fas fa-history display-4"></i>
                            </div>
                        </div>
                        <h5 class="fw-bold text-dark mb-2">No Rental History Found</h5>
                        <p class="text-muted mx-auto mb-4" style="max-width: 420px;">
                            You haven't made any vehicle reservations yet. Choose from our luxury fleet to experience self-drive rental in Gujarat!
                        </p>
                        <a href="{{ route('cars.index') }}" class="btn btn-primary rounded-pill px-4 py-2 fw-bold" style="background: linear-gradient(135deg, #ff7a00, #ea580c); border: none;">
                            <i class="fas fa-search me-2"></i> Browse Vehicles & Book Now
                        </a>
                    </div>
                @endif
            </div>
        </div>

    </div>
</section>
@endsection
