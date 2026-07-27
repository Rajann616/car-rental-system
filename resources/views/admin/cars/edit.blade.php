@extends('layouts.app')

@section('title', 'Edit Vehicle — Admin')

@section('content')
<section class="dashboard-section pb-5">
    <div class="container">
        <div class="mb-4" data-aos="fade-down">
            <a href="{{ route('admin.cars.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill">
                <i class="fas fa-arrow-left me-1"></i> Back to Fleet List
            </a>
        </div>

        <div class="dashboard-card max-w-3xl mx-auto" data-aos="fade-up">
            <div class="card-header-custom">
                <h5><i class="fas fa-edit me-2 text-primary"></i> Edit Vehicle: {{ $car->brand }} {{ $car->model }}</h5>
            </div>
            <div class="card-body-custom">
                <form action="{{ route('admin.cars.update', $car->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Brand / Manufacturer *</label>
                            <input type="text" name="brand" class="form-control" value="{{ old('brand', $car->brand) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Model Name *</label>
                            <input type="text" name="model" class="form-control" value="{{ old('model', $car->model) }}" required>
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Manufacturing Year *</label>
                            <input type="number" name="year" class="form-control" min="2000" max="{{ date('Y')+1 }}" value="{{ old('year', $car->year) }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Registration Number *</label>
                            <input type="text" name="registration_number" class="form-control" value="{{ old('registration_number', $car->registration_number) }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Rental Price (₹ / day) *</label>
                            <input type="number" name="rental_price_per_day" class="form-control" step="0.01" value="{{ old('rental_price_per_day', $car->rental_price_per_day) }}" required>
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Fuel Type *</label>
                            <select name="fuel_type" class="form-select" required>
                                @foreach(['Petrol', 'Diesel', 'Electric', 'Hybrid', 'CNG'] as $fuel)
                                    <option value="{{ $fuel }}" {{ $car->fuel_type == $fuel ? 'selected' : '' }}>{{ $fuel }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Transmission *</label>
                            <select name="transmission" class="form-select" required>
                                <option value="Automatic" {{ $car->transmission == 'Automatic' ? 'selected' : '' }}>Automatic</option>
                                <option value="Manual" {{ $car->transmission == 'Manual' ? 'selected' : '' }}>Manual</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Seating Capacity *</label>
                            <input type="number" name="seating_capacity" class="form-control" min="2" max="20" value="{{ old('seating_capacity', $car->seating_capacity) }}" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Status *</label>
                        <select name="status" class="form-select" required>
                            @foreach(['Available', 'Booked', 'Rented', 'Maintenance'] as $st)
                                <option value="{{ $st }}" {{ $car->status == $st ? 'selected' : '' }}>{{ $st }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Update Thumbnail Image</label>
                        <input type="file" name="thumbnail" class="form-control" accept="image/*">
                        @if($car->thumbnail)
                            <div class="mt-2">
                                <img src="{{ asset('storage/' . $car->thumbnail) }}" class="rounded border" style="height: 60px;">
                            </div>
                        @endif
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Vehicle Description</label>
                        <textarea name="description" class="form-control" rows="3">{{ old('description', $car->description) }}</textarea>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.cars.index') }}" class="btn btn-light px-4">Cancel</a>
                        <button type="submit" class="btn btn-primary px-4 rounded-pill">Update Vehicle</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
