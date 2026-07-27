@extends('layouts.app')

@section('title', 'Manage Vehicles — Admin')

@section('content')
<section class="dashboard-section pb-5">
    <div class="container">
        <!-- Header -->
        <div class="dashboard-header d-flex align-items-center justify-content-between flex-wrap gap-3" data-aos="fade-down">
            <div>
                <h1 class="fw-bold mb-1">Vehicle car Management</h1>
                <p class="text-muted mb-0">Add, edit, monitor and update vehicle statuses in your car.</p>
            </div>
            <div>
                <a href="{{ route('admin.cars.create') }}" class="btn btn-primary rounded-pill px-4">
                    <i class="fas fa-plus me-2"></i> Add New Vehicle
                </a>
            </div>
        </div>

        <div class="dashboard-card" data-aos="fade-up">
            <div class="card-header-custom d-flex align-items-center justify-content-between flex-wrap gap-2">
                <h5 class="mb-0"><i class="fas fa-car me-2 text-primary"></i> All Vehicles ({{ $cars->total() }})</h5>
                <form action="{{ route('admin.cars.index') }}" method="GET" class="d-flex gap-2">
                    <input type="text" name="search" class="form-control form-control-sm" placeholder="Search brand, model, reg..." value="{{ request('search') }}">
                    <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                        <option value="">All Statuses</option>
                        <option value="Available" {{ request('status') == 'Available' ? 'selected' : '' }}>Available</option>
                        <option value="Booked" {{ request('status') == 'Booked' ? 'selected' : '' }}>Booked</option>
                        <option value="Maintenance" {{ request('status') == 'Maintenance' ? 'selected' : '' }}>Maintenance</option>
                    </select>
                </form>
            </div>
            <div class="card-body-custom">
                <div class="table-responsive">
                    <table class="table table-modern align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Vehicle</th>
                                <th>Reg Number</th>
                                <th>Fuel & Trans</th>
                                <th>Seats</th>
                                <th>Daily Rate</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($cars as $car)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="rounded-3 overflow-hidden bg-light border" style="width: 50px; height: 40px;">
                                                @if($car->thumbnail)
                                                    <img src="{{ asset('storage/' . $car->thumbnail) }}" class="w-100 h-100 object-fit-cover">
                                                @else
                                                    <div class="d-flex align-items-center justify-content-center h-100 text-primary">
                                                        <i class="fas fa-car small"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            <div>
                                                <div class="fw-bold">{{ $car->brand }} {{ $car->model }}</div>
                                                <small class="text-muted">{{ $car->year }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="fw-semibold text-secondary">{{ $car->registration_number }}</td>
                                    <td>
                                        <span class="badge bg-light text-dark border">{{ $car->fuel_type }}</span>
                                        <span class="badge bg-light text-dark border">{{ $car->transmission }}</span>
                                    </td>
                                    <td>{{ $car->seating_capacity }} Seater</td>
                                    <td class="fw-bold text-primary">₹{{ number_format($car->rental_price_per_day, 0) }}</td>
                                    <td>
                                        <span class="badge-status {{ strtolower($car->status) }}">
                                            {{ $car->status }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('cars.show', $car->id) }}" class="btn btn-sm btn-outline-secondary" target="_blank" title="View Public Page">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.cars.edit', $car->id) }}" class="btn btn-sm btn-outline-primary" title="Edit Vehicle">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.cars.destroy', $car->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this vehicle?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete Vehicle">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4 text-muted">No vehicles found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-center mt-4">
                    {{ $cars->links() }}
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
