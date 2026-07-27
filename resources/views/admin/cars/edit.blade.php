@extends('layouts.app')

@section('title', 'Edit Vehicle — Admin')

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
                            <i class="fas fa-edit me-1"></i> Update Specs
                        </span>
                        <h1 class="fw-bold text-white font-display fs-2 mb-2">Edit Vehicle: {{ $car->brand }} {{ $car->model }}</h1>
                        <p class="text-white-50 mb-0 max-w-2xl">
                            Update daily rates, change availability status, or update vehicle image thumbnail.
                        </p>
                    </div>
                    <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                        <a href="{{ route('admin.cars.index') }}" class="btn btn-outline-light rounded-pill px-4 fw-medium">
                            <i class="fas fa-arrow-left me-2"></i> Back to Vehicles
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Vehicle Form Card -->
        <div class="dashboard-card border-0 shadow-sm rounded-4 bg-white overflow-hidden" data-aos="fade-up">
            <div class="card-header-custom bg-white p-4 border-bottom">
                <h5 class="fw-bold mb-0 text-dark"><i class="fas fa-car me-2 text-primary"></i> Vehicle Specifications & Status</h5>
            </div>
            <div class="card-body-custom p-4">
                <form action="{{ route('admin.cars.update', $car->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted">Brand Name *</label>
                            <input type="text" name="brand" class="form-control border-2" value="{{ old('brand', $car->brand) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted">Car Model *</label>
                            <input type="text" name="model" class="form-control border-2" value="{{ old('model', $car->model) }}" required>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label small fw-bold text-muted">Manufacturing Year *</label>
                            <input type="number" name="year" class="form-control border-2" value="{{ old('year', $car->year) }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-bold text-muted">Registration Number *</label>
                            <input type="text" name="registration_number" class="form-control border-2" value="{{ old('registration_number', $car->registration_number) }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-bold text-muted">Daily Rental Rate (₹/day) *</label>
                            <input type="number" name="rental_price_per_day" class="form-control border-2" value="{{ old('rental_price_per_day', $car->rental_price_per_day) }}" required>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label small fw-bold text-muted">Fuel Type *</label>
                            <select name="fuel_type" class="form-select border-2" required>
                                @foreach(['Petrol', 'Diesel', 'Electric', 'CNG'] as $f)
                                    <option value="{{ $f }}" {{ $car->fuel_type == $f ? 'selected' : '' }}>{{ $f }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-bold text-muted">Transmission *</label>
                            <select name="transmission" class="form-select border-2" required>
                                @foreach(['Manual', 'Automatic'] as $t)
                                    <option value="{{ $t }}" {{ $car->transmission == $t ? 'selected' : '' }}>{{ $t }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-bold text-muted">Seating Capacity *</label>
                            <input type="number" name="seating_capacity" class="form-control border-2" value="{{ old('seating_capacity', $car->seating_capacity) }}" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted">Vehicle Image Thumbnail</label>
                            <input type="file" name="thumbnail" class="form-control border-2" accept="image/*">
                            @if($car->thumbnail)
                                <div class="mt-2 small text-muted">Current: {{ $car->thumbnail }}</div>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted">Status *</label>
                            <select name="status" class="form-select border-2" required>
                                @foreach(['Available', 'Booked', 'Maintenance'] as $st)
                                    <option value="{{ $st }}" {{ $car->status == $st ? 'selected' : '' }}>{{ $st }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-12">
                            <label class="form-label small fw-bold text-muted">Vehicle Description & Features</label>
                            <textarea name="description" class="form-control border-2" rows="4">{{ old('description', $car->description) }}</textarea>
                        </div>
                    </div>

                    <div class="mt-4 pt-3 border-top text-end">
                        <a href="{{ route('admin.cars.index') }}" class="btn btn-light rounded-pill px-4 me-2">Cancel</a>
                        <button type="submit" class="btn btn-primary rounded-pill px-5 fw-bold" style="background: linear-gradient(135deg, #ff7a00, #ea580c); border: none;">
                            <i class="fas fa-check me-2"></i> Update Vehicle
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</section>
@endsection
