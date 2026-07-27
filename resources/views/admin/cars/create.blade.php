@extends('layouts.app')

@section('title', 'Add New Vehicle — Admin')

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
                <h5><i class="fas fa-plus-circle me-2 text-primary"></i> Add New Vehicle to Fleet</h5>
            </div>
            <div class="card-body-custom">
                <form action="{{ route('admin.cars.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Brand / Manufacturer *</label>
                            <input type="text" name="brand" class="form-control" placeholder="e.g. Maruti Suzuki, Tata, Mahindra" value="{{ old('brand') }}" required>
                            @error('brand') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Model Name *</label>
                            <input type="text" name="model" class="form-control" placeholder="e.g. Swift, Nexon, Thar" value="{{ old('model') }}" required>
                            @error('model') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Manufacturing Year *</label>
                            <input type="number" name="year" class="form-control" min="2000" max="{{ date('Y')+1 }}" value="{{ old('year', date('Y')) }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Registration Number (GJ) *</label>
                            <input type="text" name="registration_number" class="form-control" placeholder="e.g. GJ-01-AB-1234" value="{{ old('registration_number') }}" required>
                            @error('registration_number') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Rental Price (₹ / day) *</label>
                            <input type="number" name="rental_price_per_day" class="form-control" step="0.01" placeholder="e.g. 2500" value="{{ old('rental_price_per_day') }}" required>
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Fuel Type *</label>
                            <select name="fuel_type" class="form-select" required>
                                <option value="Petrol">Petrol</option>
                                <option value="Diesel">Diesel</option>
                                <option value="Electric">Electric</option>
                                <option value="Hybrid">Hybrid</option>
                                <option value="CNG">CNG</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Transmission *</label>
                            <select name="transmission" class="form-select" required>
                                <option value="Automatic">Automatic</option>
                                <option value="Manual">Manual</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Seating Capacity *</label>
                            <input type="number" name="seating_capacity" class="form-control" min="2" max="20" value="{{ old('seating_capacity', 5) }}" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Status *</label>
                        <select name="status" class="form-select" required>
                            <option value="Available">Available</option>
                            <option value="Booked">Booked</option>
                            <option value="Maintenance">Maintenance</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Thumbnail Image</label>
                        <input type="file" name="thumbnail" class="form-control" accept="image/*">
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Vehicle Description</label>
                        <textarea name="description" class="form-control" rows="3" placeholder="Overview of vehicle condition, features and ideal use cases...">{{ old('description') }}</textarea>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.cars.index') }}" class="btn btn-light px-4">Cancel</a>
                        <button type="submit" class="btn btn-primary px-4 rounded-pill">Save Vehicle</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
