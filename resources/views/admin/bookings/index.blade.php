@extends('layouts.app')

@section('title', 'Manage Bookings — Admin')

@section('content')
<section class="dashboard-section pb-5">
    <div class="container">
        <!-- Header -->
        <div class="dashboard-header d-flex align-items-center justify-content-between flex-wrap gap-3" data-aos="fade-down">
            <div>
                <h1 class="fw-bold mb-1">Reservation Management</h1>
                <p class="text-muted mb-0">Monitor customer bookings, verify payments, and update rental statuses.</p>
            </div>
        </div>

        <div class="dashboard-card" data-aos="fade-up">
            <div class="card-header-custom d-flex align-items-center justify-content-between flex-wrap gap-2">
                <h5 class="mb-0"><i class="fas fa-list-check me-2 text-primary"></i> All Reservations ({{ $bookings->total() }})</h5>
                <form action="{{ route('admin.bookings.index') }}" method="GET" class="d-flex gap-2">
                    <input type="text" name="search" class="form-control form-control-sm" placeholder="Search number, user..." value="{{ request('search') }}">
                    <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                        <option value="">All Statuses</option>
                        <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                        <option value="Confirmed" {{ request('status') == 'Confirmed' ? 'selected' : '' }}>Confirmed</option>
                        <option value="Active" {{ request('status') == 'Active' ? 'selected' : '' }}>Active</option>
                        <option value="Completed" {{ request('status') == 'Completed' ? 'selected' : '' }}>Completed</option>
                        <option value="Cancelled" {{ request('status') == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </form>
            </div>
            <div class="card-body-custom">
                <div class="table-responsive">
                    <table class="table table-modern align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Booking #</th>
                                <th>Customer</th>
                                <th>Vehicle</th>
                                <th>Rental Period</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Update Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($bookings as $booking)
                                <tr>
                                    <td class="fw-semibold text-primary">{{ $booking->booking_number }}</td>
                                    <td>
                                        <div class="fw-bold">{{ $booking->user->name }}</div>
                                        <small class="text-muted">{{ $booking->user->email }}</small>
                                    </td>
                                    <td>
                                        <div class="fw-bold">{{ $booking->car->brand }} {{ $booking->car->model }}</div>
                                        <small class="text-muted">{{ $booking->car->registration_number }}</small>
                                    </td>
                                    <td class="small">
                                        <div><strong>Pickup:</strong> {{ $booking->pickup_date->format('d M Y') }}</div>
                                        <div><strong>Return:</strong> {{ $booking->return_date->format('d M Y') }}</div>
                                    </td>
                                    <td class="fw-bold text-success">
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
                                            <select name="status" class="form-select form-select-sm py-1 px-2">
                                                @foreach(['Pending', 'Confirmed', 'Active', 'Completed', 'Cancelled'] as $st)
                                                    <option value="{{ $st }}" {{ $booking->status == $st ? 'selected' : '' }}>{{ $st }}</option>
                                                @endforeach
                                            </select>
                                            <button type="submit" class="btn btn-sm btn-primary py-1 px-2" title="Save Status"><i class="fas fa-check"></i></button>
                                        </form>
                                    </td>
                                    <td>
                                        <a href="{{ route('bookings.show', $booking->id) }}" class="btn btn-sm btn-outline-secondary" target="_blank" title="View Invoice">
                                            <i class="fas fa-receipt"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-4 text-muted">No reservations found.</td>
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
