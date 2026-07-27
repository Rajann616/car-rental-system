@extends('layouts.app')

@section('title', $car->display_name . ' — AutoLux')

@section('content')
<section class="dashboard-section pb-5">
    <div class="container">
        <!-- Breadcrumb & Back -->
        <div class="mb-4" data-aos="fade-down">
            <a href="{{ auth()->check() && auth()->user()->isAdmin() ? route('admin.cars.index') : route('cars.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill">
                <i class="fas fa-arrow-left me-1"></i> Back to Cars
            </a>
        </div>

        <div class="row g-4 mb-5">
            <!-- Left Column: Gallery & Details -->
            <div class="col-lg-7" data-aos="fade-right">
                <!-- Vehicle Hero Image -->
                <div class="car-detail-hero mb-3 position-relative rounded-4 overflow-hidden shadow-lg bg-light d-flex align-items-center justify-content-center" style="height: 380px;">
                    @if($car->thumbnail)
                        <img src="{{ asset('storage/' . $car->thumbnail) }}" id="mainCarImage" alt="{{ $car->display_name }}" class="w-100 h-100 object-fit-cover">
                    @else
                        <div class="text-center p-5">
                            <i class="fas fa-car text-primary opacity-50 display-1 mb-3"></i>
                            <h4 class="text-muted">{{ $car->brand }} {{ $car->model }}</h4>
                        </div>
                    @endif
                    <span class="position-absolute top-0 start-0 m-3 badge-status {{ strtolower($car->status) }} fs-6">
                        {{ $car->status }}
                    </span>
                </div>

                <!-- Image Gallery Thumbnails -->
                @if($car->images->count() > 0)
                    <div class="d-flex gap-2 mb-4 overflow-auto pb-2">
                        @if($car->thumbnail)
                            <img src="{{ asset('storage/' . $car->thumbnail) }}" onclick="document.getElementById('mainCarImage').src = this.src" class="rounded-3 border border-2 border-primary cursor-pointer object-fit-cover" style="width: 80px; height: 60px;">
                        @endif
                        @foreach($car->images as $image)
                            <img src="{{ asset('storage/' . $image->image_path) }}" onclick="document.getElementById('mainCarImage').src = this.src" class="rounded-3 border border-2 border-light cursor-pointer object-fit-cover" style="width: 80px; height: 60px;">
                        @endforeach
                    </div>
                @endif

                <!-- Vehicle Specifications -->
                <div class="dashboard-card mb-4 border-0 shadow-sm rounded-4 bg-white">
                    <div class="card-header-custom p-4 border-bottom">
                        <h5 class="fw-bold mb-0 text-dark"><i class="fas fa-sliders me-2 text-primary"></i> Vehicle Specifications</h5>
                    </div>
                    <div class="card-body-custom p-4">
                        <div class="row g-3">
                            <div class="col-6 col-md-4">
                                <div class="p-3 bg-light rounded-3 text-center">
                                    <i class="fas fa-building-flag text-primary mb-1 fs-5"></i>
                                    <div class="small text-muted">Brand</div>
                                    <div class="fw-bold text-dark">{{ $car->brand }}</div>
                                </div>
                            </div>
                            <div class="col-6 col-md-4">
                                <div class="p-3 bg-light rounded-3 text-center">
                                    <i class="fas fa-car text-primary mb-1 fs-5"></i>
                                    <div class="small text-muted">Model</div>
                                    <div class="fw-bold text-dark">{{ $car->model }}</div>
                                </div>
                            </div>
                            <div class="col-6 col-md-4">
                                <div class="p-3 bg-light rounded-3 text-center">
                                    <i class="fas fa-calendar text-primary mb-1 fs-5"></i>
                                    <div class="small text-muted">Year</div>
                                    <div class="fw-bold text-dark">{{ $car->year }}</div>
                                </div>
                            </div>
                            <div class="col-6 col-md-4">
                                <div class="p-3 bg-light rounded-3 text-center">
                                    <i class="fas fa-gas-pump text-primary mb-1 fs-5"></i>
                                    <div class="small text-muted">Fuel Type</div>
                                    <div class="fw-bold text-dark">{{ $car->fuel_type }}</div>
                                </div>
                            </div>
                            <div class="col-6 col-md-4">
                                <div class="p-3 bg-light rounded-3 text-center">
                                    <i class="fas fa-gears text-primary mb-1 fs-5"></i>
                                    <div class="small text-muted">Transmission</div>
                                    <div class="fw-bold text-dark">{{ $car->transmission }}</div>
                                </div>
                            </div>
                            <div class="col-6 col-md-4">
                                <div class="p-3 bg-light rounded-3 text-center">
                                    <i class="fas fa-users text-primary mb-1 fs-5"></i>
                                    <div class="small text-muted">Seats</div>
                                    <div class="fw-bold text-dark">{{ $car->seating_capacity }} Persons</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Description & Features -->
                <div class="dashboard-card border-0 shadow-sm rounded-4 bg-white">
                    <div class="card-header-custom p-4 border-bottom">
                        <h5 class="fw-bold mb-0 text-dark"><i class="fas fa-info-circle me-2 text-primary"></i> Description & Features</h5>
                    </div>
                    <div class="card-body-custom p-4">
                        <p class="text-muted leading-relaxed mb-4">{{ $car->description ?? 'No description provided for this vehicle.' }}</p>

                        @if($car->features && count($car->features) > 0)
                            <h6 class="fw-bold text-dark mb-3">Key Features</h6>
                            <div class="row g-2">
                                @foreach($car->features as $feature)
                                    <div class="col-md-6">
                                        <div class="d-flex align-items-center gap-2 small text-dark">
                                            <i class="fas fa-check-circle text-success"></i> {{ $feature }}
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Right Column: Admin Panel vs Customer Booking Card -->
            <div class="col-lg-5" data-aos="fade-left">
                <div class="dashboard-card border-0 shadow-sm rounded-4 bg-white overflow-hidden sticky-top" style="top: 100px; z-index: 10;">
                    
                    @auth
                        @if(auth()->user()->isAdmin())
                            <!-- ADMIN CONTROL PANEL CARD -->
                            <div class="card-header-custom p-4 border-bottom text-white" style="background: linear-gradient(135deg, #0a1628 0%, #1a4a8a 100%);">
                                <div class="d-flex align-items-center justify-content-between">
                                    <h5 class="mb-0 text-white font-display"><i class="fas fa-user-shield me-2 text-warning"></i> Admin Vehicle Controls</h5>
                                    <span class="badge bg-warning text-dark font-weight-bold">{{ $car->status }}</span>
                                </div>
                            </div>

                            <div class="card-body-custom p-4">
                                <div class="p-3 bg-light rounded-3 mb-4">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="text-muted small fw-bold">Daily Rental Rate:</span>
                                        <span class="fw-bold text-primary fs-5">₹{{ number_format($car->rental_price_per_day, 0) }} / day</span>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="text-muted small fw-bold">Registration Number:</span>
                                        <span class="fw-bold text-dark fs-6">{{ $car->registration_number }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="text-muted small fw-bold">Seating Capacity:</span>
                                        <span class="fw-bold text-dark fs-6">{{ $car->seating_capacity }} Seater</span>
                                    </div>
                                </div>

                                <!-- Quick Status Toggle Form -->
                                <form action="{{ route('admin.cars.update', $car->id) }}" method="POST" class="mb-4">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="brand" value="{{ $car->brand }}">
                                    <input type="hidden" name="model" value="{{ $car->model }}">
                                    <input type="hidden" name="year" value="{{ $car->year }}">
                                    <input type="hidden" name="registration_number" value="{{ $car->registration_number }}">
                                    <input type="hidden" name="rental_price_per_day" value="{{ $car->rental_price_per_day }}">
                                    <input type="hidden" name="fuel_type" value="{{ $car->fuel_type }}">
                                    <input type="hidden" name="transmission" value="{{ $car->transmission }}">
                                    <input type="hidden" name="seating_capacity" value="{{ $car->seating_capacity }}">

                                    <label class="form-label small fw-bold text-muted text-uppercase mb-2">Update Vehicle Status</label>
                                    <div class="input-group mb-2">
                                        <select name="status" class="form-select border-2">
                                            <option value="Available" {{ $car->status === 'Available' ? 'selected' : '' }}>Available for Rent</option>
                                            <option value="Booked" {{ $car->status === 'Booked' ? 'selected' : '' }}>Currently Booked</option>
                                            <option value="Maintenance" {{ $car->status === 'Maintenance' ? 'selected' : '' }}>Under Maintenance</option>
                                        </select>
                                        <button type="submit" class="btn btn-primary px-3 fw-bold">Update</button>
                                    </div>
                                </form>

                                <!-- Action Buttons -->
                                <div class="d-grid gap-2">
                                    <a href="{{ route('admin.cars.edit', $car->id) }}" class="btn btn-primary py-2 fw-bold rounded-pill" style="background: linear-gradient(135deg, #ff7a00, #ea580c); border: none;">
                                        <i class="fas fa-edit me-2"></i> Edit Vehicle Specs & Pricing
                                    </a>

                                    <a href="{{ route('admin.bookings.index') }}?search={{ $car->registration_number }}" class="btn btn-outline-secondary py-2 fw-semibold rounded-pill">
                                        <i class="fas fa-list-check me-2"></i> View Booking History for This Car
                                    </a>

                                    <form action="{{ route('admin.cars.destroy', $car->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this vehicle from the system?');" class="mt-2">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger w-100 py-2 fw-semibold rounded-pill">
                                            <i class="fas fa-trash me-2"></i> Delete Vehicle
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @else
                            <!-- CUSTOMER BOOKING CARD -->
                            <div class="card-header-custom bg-primary text-white d-flex justify-content-between align-items-center p-4">
                                <h5 class="mb-0 text-white"><i class="fas fa-calendar-check me-2"></i> Book This Vehicle</h5>
                                <span class="fs-4 fw-bold text-white">₹{{ number_format($car->rental_price_per_day, 0) }} <small class="fs-6 fw-normal">/day</small></span>
                            </div>
                            <div class="card-body-custom p-4">
                                @if($car->status === 'Available')
                                    <form action="{{ route('customer.bookings.create', $car->id) }}" method="GET">
                                        <div class="mb-3">
                                            <label class="form-label small fw-bold text-muted">Pickup Location (Ahmedabad)</label>
                                            <select name="pickup_location" class="form-select border-2">
                                                <option value="SG Highway Hub (Iskcon)">SG Highway Hub (Iskcon)</option>
                                                <option value="Sardar Vallabhbhai Patel Airport (AMD)">Airport Pickup (AMD)</option>
                                                <option value="Ahmedabad Junction Railway Station">Kalupur Railway Station</option>
                                                <option value="CG Road Hub (Navrangpura)">CG Road Hub (Navrangpura)</option>
                                                <option value="Doorstep Delivery (Home)">Doorstep Delivery (Home)</option>
                                            </select>
                                        </div>

                                        <div class="row g-2 mb-3">
                                            <div class="col-6">
                                                <label class="form-label small fw-bold text-muted">Pickup Date</label>
                                                <input type="date" name="pickup_date" class="form-control border-2" min="{{ date('Y-m-d') }}" required id="pickup_date" onchange="calculateTotal()">
                                            </div>
                                            <div class="col-6">
                                                <label class="form-label small fw-bold text-muted">Return Date</label>
                                                <input type="date" name="return_date" class="form-control border-2" min="{{ date('Y-m-d', strtotime('+1 day')) }}" required id="return_date" onchange="calculateTotal()">
                                            </div>
                                        </div>

                                        <!-- Fare Summary Breakdown Box -->
                                        <div class="p-3 bg-light rounded-3 mb-4" id="fareBox">
                                            <div class="d-flex justify-content-between small text-muted mb-1">
                                                <span>Daily Rate</span>
                                                <span>₹{{ number_format($car->rental_price_per_day, 0) }}</span>
                                            </div>
                                            <div class="d-flex justify-content-between small text-muted mb-1">
                                                <span>Estimated Days</span>
                                                <span id="daysCount">1 Day</span>
                                            </div>
                                            <div class="d-flex justify-content-between small text-muted mb-2">
                                                <span>Refundable Security Deposit</span>
                                                <span>₹2,000</span>
                                            </div>
                                            <hr class="my-2">
                                            <div class="d-flex justify-content-between fw-bold text-dark fs-6">
                                                <span>Estimated Total</span>
                                                <span class="text-primary" id="grandTotal">₹{{ number_format($car->rental_price_per_day + 2000, 0) }}</span>
                                            </div>
                                        </div>

                                        <button type="submit" class="btn btn-primary btn-lg w-100 rounded-pill fw-bold" style="background: linear-gradient(135deg, #ff7a00, #ea580c); border: none;">
                                            Proceed to Booking <i class="fas fa-arrow-right ms-2"></i>
                                        </button>
                                    </form>
                                @else
                                    <div class="text-center py-4">
                                        <span class="badge-status {{ strtolower($car->status) }} fs-6 mb-3 d-inline-block">{{ $car->status }}</span>
                                        <p class="text-muted">This vehicle is currently not available for instant online booking.</p>
                                        <a href="{{ route('cars.index') }}" class="btn btn-outline-primary rounded-pill btn-sm">Explore Other Cars</a>
                                    </div>
                                @endif
                            </div>
                        @endif
                    @else
                        <!-- GUEST VISITOR BOOKING CARD -->
                        <div class="card-header-custom bg-primary text-white d-flex justify-content-between align-items-center p-4">
                            <h5 class="mb-0 text-white"><i class="fas fa-calendar-check me-2"></i> Book This Vehicle</h5>
                            <span class="fs-4 fw-bold text-white">₹{{ number_format($car->rental_price_per_day, 0) }} <small class="fs-6 fw-normal">/day</small></span>
                        </div>
                        <div class="card-body-custom p-4">
                            @if($car->status === 'Available')
                                <form action="{{ route('customer.bookings.create', $car->id) }}" method="GET">
                                    <div class="mb-3">
                                        <label class="form-label small fw-bold text-muted">Pickup Location (Ahmedabad)</label>
                                        <select name="pickup_location" class="form-select border-2">
                                            <option value="SG Highway Hub (Iskcon)">SG Highway Hub (Iskcon)</option>
                                            <option value="Sardar Vallabhbhai Patel Airport (AMD)">Airport Pickup (AMD)</option>
                                            <option value="Ahmedabad Junction Railway Station">Kalupur Railway Station</option>
                                            <option value="CG Road Hub (Navrangpura)">CG Road Hub (Navrangpura)</option>
                                            <option value="Doorstep Delivery (Home)">Doorstep Delivery (Home)</option>
                                        </select>
                                    </div>

                                    <div class="row g-2 mb-3">
                                        <div class="col-6">
                                            <label class="form-label small fw-bold text-muted">Pickup Date</label>
                                            <input type="date" name="pickup_date" class="form-control border-2" min="{{ date('Y-m-d') }}" required id="pickup_date" onchange="calculateTotal()">
                                        </div>
                                        <div class="col-6">
                                            <label class="form-label small fw-bold text-muted">Return Date</label>
                                            <input type="date" name="return_date" class="form-control border-2" min="{{ date('Y-m-d', strtotime('+1 day')) }}" required id="return_date" onchange="calculateTotal()">
                                        </div>
                                    </div>

                                    <a href="{{ route('login') }}" class="btn btn-primary btn-lg w-100 rounded-pill fw-bold" style="background: linear-gradient(135deg, #ff7a00, #ea580c); border: none;">
                                        Sign In to Book <i class="fas fa-lock ms-2"></i>
                                    </a>
                                </form>
                            @else
                                <div class="text-center py-4">
                                    <span class="badge-status {{ strtolower($car->status) }} fs-6 mb-3 d-inline-block">{{ $car->status }}</span>
                                    <p class="text-muted">This vehicle is currently not available for instant online booking.</p>
                                    <a href="{{ route('cars.index') }}" class="btn btn-outline-primary rounded-pill btn-sm">Explore Other Cars</a>
                                </div>
                            @endif
                        </div>
                    @endauth

                </div>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
    function calculateTotal() {
        const rate = {{ $car->rental_price_per_day }};
        const pDate = new Date(document.getElementById('pickup_date').value);
        const rDate = new Date(document.getElementById('return_date').value);

        if (pDate && rDate && rDate > pDate) {
            const diffTime = Math.abs(rDate - pDate);
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
            const total = (diffDays * rate) + 2000;

            document.getElementById('daysCount').innerText = diffDays + (diffDays === 1 ? ' Day' : ' Days');
            document.getElementById('grandTotal').innerText = '₹' + total.toLocaleString('en-IN');
        }
    }
</script>
@endpush
@endsection
