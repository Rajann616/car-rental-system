@extends('layouts.admin')

@section('title', 'Vehicle Management — Admin')
@section('page_title', 'Vehicle Fleet')

@section('content')
<div class="container-fluid px-0">
        
        <!-- Header Banner Card -->
        <div class="mb-4" data-aos="fade-down">
            <div class="p-4 p-md-5 rounded-4 text-white shadow-lg position-relative overflow-hidden" 
                 style="background: linear-gradient(135deg, #0a1628 0%, #153663 50%, #1a4a8a 100%); border: 1px solid rgba(255,255,255,0.1);">
                <div class="row align-items-center position-relative" style="z-index: 2;">
                    <div class="col-lg-8">
                        <span class="badge bg-warning bg-opacity-25 text-warning border border-warning border-opacity-50 rounded-pill px-3 py-1 mb-2 small fw-bold">
                            <i class="fas fa-car me-1"></i> Fleet Management
                        </span>
                        <h1 class="fw-bold text-white font-display fs-2 mb-2">Vehicle Management</h1>
                        <p class="text-white-50 mb-0 max-w-2xl">
                            Add new vehicles, update rental pricing, modify specs, and track vehicle availability status.
                        </p>
                    </div>
                    <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                        <a href="{{ route('admin.cars.create') }}" class="btn btn-lg rounded-pill px-4 fw-bold text-white shadow" style="background: linear-gradient(135deg, #ff7a00, #ea580c); border: none;">
                            <i class="fas fa-plus-circle me-1"></i> Add New Vehicle
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Vehicles Master Table Card -->
        <div class="dashboard-card border-0 shadow-sm rounded-4 bg-white overflow-hidden" data-aos="fade-up">
            <div class="card-header-custom bg-white p-4 border-bottom d-flex align-items-center justify-content-between flex-wrap gap-2">
                <h5 class="fw-bold mb-0 text-dark">
                    <i class="fas fa-car me-2 text-primary"></i> All Vehicles ({{ $cars->total() }})
                </h5>
                <form action="{{ route('admin.cars.index') }}" method="GET" class="d-flex gap-2">
                    <input type="text" name="search" class="form-control form-control-sm border-2" placeholder="Search brand, model, reg..." value="{{ request('search') }}">
                    <select name="status" class="form-select form-select-sm border-2" onchange="this.form.submit()">
                        <option value="">All Statuses</option>
                        <option value="Available" {{ request('status') == 'Available' ? 'selected' : '' }}>Available</option>
                        <option value="Booked" {{ request('status') == 'Booked' ? 'selected' : '' }}>Booked</option>
                        <option value="Maintenance" {{ request('status') == 'Maintenance' ? 'selected' : '' }}>Maintenance</option>
                    </select>
                </form>
            </div>
            <div class="card-body-custom p-4">
                <div class="table-responsive">
                    <table class="table table-modern align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Vehicle</th>
                                <th>Reg Number</th>
                                <th>Fuel & Trans</th>
                                <th>Seating</th>
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
                                            <div class="rounded-3 overflow-hidden bg-light border" style="width: 65px; height: 48px; flex-shrink: 0;">
                                                @if($car->thumbnail)
                                                    <img src="{{ asset('storage/' . $car->thumbnail) }}" class="w-100 h-100 object-fit-cover">
                                                @else
                                                    <div class="d-flex align-items-center justify-content-center h-100 text-primary">
                                                        <i class="fas fa-car fs-4"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            <div>
                                                <div class="fw-bold text-dark fs-6">{{ $car->brand }} {{ $car->model }}</div>
                                                <small class="text-muted">{{ $car->year }} Model</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="fw-bold text-dark">{{ $car->registration_number }}</td>
                                    <td>
                                        <span class="badge bg-light text-dark border me-1">{{ $car->fuel_type }}</span>
                                        <span class="badge bg-light text-dark border">{{ $car->transmission }}</span>
                                    </td>
                                    <td class="small fw-semibold text-muted">{{ $car->seating_capacity }} Seater</td>
                                    <td class="fw-bold text-primary fs-6">₹{{ number_format($car->rental_price_per_day, 0) }}</td>
                                    <td>
                                        <span class="badge-status {{ strtolower($car->status) }}">
                                            {{ $car->status }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('cars.show', $car->id) }}" class="btn btn-sm btn-outline-secondary rounded-circle" target="_blank" title="View Details">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.cars.edit', $car->id) }}" class="btn btn-sm btn-outline-primary rounded-circle" title="Edit Vehicle">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.cars.destroy', $car->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this vehicle?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger rounded-circle" title="Delete Vehicle">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5 text-muted">No vehicles found in fleet.</td>
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
@endsection
