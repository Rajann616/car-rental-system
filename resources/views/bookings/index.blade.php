@extends('layouts.app')

@section('title', 'My Booking History — DriveEase')

@section('content')
<section class="dashboard-section pb-5">
    <div class="container">
        <!-- Header -->
        <div class="dashboard-header d-flex align-items-center justify-content-between flex-wrap gap-3" data-aos="fade-down">
            <div>
                <h1 class="fw-bold mb-1">My Booking History</h1>
                <p class="text-muted mb-0">Track all your past, present, and cancelled vehicle rentals.</p>
            </div>
            <div>
                <a href="{{ route('cars.index') }}" class="btn btn-primary rounded-pill px-4">
                    <i class="fas fa-plus me-2"></i> Book New Car
                </a>
            </div>
        </div>

        <div class="dashboard-card" data-aos="fade-up">
            <div class="card-header-custom">
                <h5><i class="fas fa-history me-2 text-primary"></i> All Rentals ({{ $bookings->total() }})</h5>
            </div>
            <div class="card-body-custom">
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
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($bookings as $booking)
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
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('bookings.show', $booking->id) }}" class="btn btn-sm btn-outline-primary" title="View Invoice">
                                                <i class="fas fa-receipt"></i> Invoice
                                            </a>
                                            @if($booking->canBeCancelled())
                                                <form action="{{ route('bookings.cancel', $booking->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel this booking?');">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-outline-danger">Cancel</button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4 text-muted">No rental bookings found.</td>
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
