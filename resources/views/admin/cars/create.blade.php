@extends('layouts.admin')

@section('title', 'Add New Vehicle — Admin')
@section('page_title', 'Add New Vehicle')

@section('content')
<div class="container-fluid px-0">
        
        <!-- Header Banner Card -->
        <div class="mb-4" data-aos="fade-down">
            <div class="p-4 p-md-5 rounded-4 text-white shadow-lg position-relative overflow-hidden" 
                 style="background: linear-gradient(135deg, #0a1628 0%, #153663 50%, #1a4a8a 100%); border: 1px solid rgba(255,255,255,0.1);">
                <div class="row align-items-center position-relative" style="z-index: 2;">
                    <div class="col-lg-8">
                        <span class="badge bg-warning bg-opacity-25 text-warning border border-warning border-opacity-50 rounded-pill px-3 py-1 mb-2 small fw-bold">
                            <i class="fas fa-plus-circle me-1"></i> Fleet Expansion
                        </span>
                        <h1 class="fw-bold text-white font-display fs-2 mb-2">Add New Vehicle</h1>
                        <p class="text-white-50 mb-0 max-w-2xl">
                            Enter vehicle specifications, daily rental pricing, registration number, and upload image thumbnail.
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

        <!-- Add Vehicle Form Card -->
        <div class="dashboard-card border-0 shadow-sm rounded-4 bg-white overflow-hidden" data-aos="fade-up">
            <div class="card-header-custom bg-white p-4 border-bottom">
                <h5 class="fw-bold mb-0 text-dark"><i class="fas fa-car me-2 text-primary"></i> Vehicle Information Form</h5>
            </div>
            <div class="card-body-custom p-4">
                <form action="{{ route('admin.cars.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted">Brand Name *</label>
                            <input type="text" name="brand" class="form-control border-2" placeholder="e.g. Maruti Suzuki, Tata, Hyundai" value="{{ old('brand') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted">Car Model *</label>
                            <input type="text" name="model" class="form-control border-2" placeholder="e.g. Swift, Nexon, Creta" value="{{ old('model') }}" required>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label small fw-bold text-muted">Manufacturing Year *</label>
                            <input type="number" name="year" class="form-control border-2" placeholder="e.g. 2024" value="{{ old('year', date('Y')) }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-bold text-muted">Registration Number *</label>
                            <input type="text" name="registration_number" class="form-control border-2" placeholder="e.g. GJ-01-AB-1234" value="{{ old('registration_number') }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-bold text-muted">Daily Rental Rate (₹/day) *</label>
                            <input type="number" name="rental_price_per_day" class="form-control border-2" placeholder="e.g. 1500" value="{{ old('rental_price_per_day') }}" required>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label small fw-bold text-muted">Fuel Type *</label>
                            <select name="fuel_type" class="form-select border-2" required>
                                <option value="Petrol">Petrol</option>
                                <option value="Diesel">Diesel</option>
                                <option value="Electric">Electric</option>
                                <option value="CNG">CNG</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-bold text-muted">Transmission *</label>
                            <select name="transmission" class="form-select border-2" required>
                                <option value="Manual">Manual</option>
                                <option value="Automatic">Automatic</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-bold text-muted">Seating Capacity *</label>
                            <input type="number" name="seating_capacity" class="form-control border-2" value="{{ old('seating_capacity', 5) }}" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted">Vehicle Image Thumbnail</label>
                            <input type="file" name="thumbnail" class="form-control border-2" accept="image/*">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted">Initial Status *</label>
                            <select name="status" class="form-select border-2" required>
                                <option value="Available">Available</option>
                                <option value="Booked">Booked</option>
                                <option value="Maintenance">Maintenance</option>
                            </select>
                        </div>

                        <div class="col-12">
                            <label class="form-label small fw-bold text-muted">Vehicle Description & Features</label>
                            <textarea name="description" class="form-control border-2" rows="4" placeholder="Mention key features (e.g. Sunroof, Touchscreen Infotainment, Airbags, Reverse Camera)...">{{ old('description') }}</textarea>
                        </div>
                    </div>

                    <div class="mt-4 pt-3 border-top text-end">
                        <a href="{{ route('admin.cars.index') }}" class="btn btn-light rounded-pill px-4 me-2">Cancel</a>
                        <button type="submit" class="btn btn-primary rounded-pill px-5 fw-bold" style="background: linear-gradient(135deg, #ff7a00, #ea580c); border: none;">
                            <i class="fas fa-check me-2"></i> Save & Add Vehicle
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection
