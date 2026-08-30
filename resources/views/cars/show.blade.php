@extends(auth()->check() ? 'layouts.customer' : 'layouts.app')

@section('title', $car->display_name . ' — AutoLux')
@section('page_title', $car->display_name)

@php
    $galleryList = [];
    if ($car->thumbnail) {
        $galleryList[] = [
            'src' => asset('storage/' . $car->thumbnail),
            'title' => $car->brand . ' ' . $car->model . ' - Hero Profile',
            'category' => 'exterior'
        ];
    }
    foreach ($car->images as $idx => $img) {
        $galleryList[] = [
            'src' => asset('storage/' . $img->image_path),
            'title' => $car->brand . ' ' . $car->model . ' - View ' . ($idx + 2),
            'category' => ($idx % 2 === 0) ? 'exterior' : 'interior'
        ];
    }
    $bookedRanges = $car->bookings->map(function($b) {
        return [
            'from' => \Carbon\Carbon::parse($b->pickup_date)->format('Y-m-d'),
            'to' => \Carbon\Carbon::parse($b->return_date)->format('Y-m-d')
        ];
    })->values();
@endphp

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<style>
    /* Modern Flatpickr Custom Theme */
    .flatpickr-calendar {
        border-radius: 16px !important;
        box-shadow: 0 20px 45px rgba(15, 23, 42, 0.18) !important;
        border: 1px solid rgba(226, 232, 240, 0.9) !important;
        font-family: inherit !important;
        overflow: hidden;
    }
    .flatpickr-months {
        background: linear-gradient(135deg, #0f172a, #1e293b);
        color: #ffffff;
        padding-top: 6px;
    }
    .flatpickr-month, .flatpickr-current-month, .flatpickr-current-month .cur-month {
        color: #ffffff !important;
        font-weight: 700;
    }
    .flatpickr-months .flatpickr-prev-month, .flatpickr-months .flatpickr-next-month {
        color: #ffffff !important;
        fill: #ffffff !important;
    }
    .flatpickr-day.selected, .flatpickr-day.startRange, .flatpickr-day.endRange {
        background: linear-gradient(135deg, #ff7a00, #ea580c) !important;
        border-color: transparent !important;
        font-weight: 700;
        box-shadow: 0 4px 12px rgba(234, 88, 12, 0.4);
    }
    .flatpickr-day.inRange {
        background: rgba(255, 122, 0, 0.14) !important;
        border-color: transparent !important;
    }
    .flatpickr-day.flatpickr-disabled, .flatpickr-day.flatpickr-disabled:hover {
        color: #94a3b8 !important;
        background: repeating-linear-gradient(45deg, #f8fafc, #f8fafc 5px, #f1f5f9 5px, #f1f5f9 10px) !important;
        text-decoration: line-through;
        opacity: 0.65;
    }
    /* Full-Screen Lightbox Animations */
    .lightbox-thumb {
        opacity: 0.55;
        transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
        cursor: pointer;
    }
    .lightbox-thumb:hover, .lightbox-thumb.active {
        opacity: 1;
        border-color: #ff7a00 !important;
        transform: scale(1.08);
    }
    .hover-lift {
        transition: transform 0.25s ease, box-shadow 0.25s ease;
    }
    .hover-lift:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.12) !important;
    }
</style>
@endpush

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
                <!-- Vehicle Hero Image with Zoom & Lightbox Trigger -->
                <div class="car-detail-hero mb-3 position-relative rounded-4 overflow-hidden shadow-lg bg-light d-flex align-items-center justify-content-center cursor-pointer" style="height: 390px; cursor: zoom-in;" onclick="openLightbox(0)" title="Click to view full screen">
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
                    <button type="button" class="btn btn-dark bg-opacity-75 text-white position-absolute bottom-0 end-0 m-3 rounded-pill px-3 py-1.5 fs-7 fw-semibold shadow-sm border-0" onclick="event.stopPropagation(); openLightbox(0)">
                        <i class="fas fa-images me-1 text-warning"></i> View Gallery ({{ count($galleryList) }})
                    </button>
                </div>

                <!-- Image Gallery Thumbnails -->
                @if(count($galleryList) > 1)
                    <div class="d-flex gap-2 mb-4 overflow-auto pb-2">
                        @foreach($galleryList as $gIdx => $gItem)
                            <img src="{{ $gItem['src'] }}" onclick="openLightbox({{ $gIdx }})" class="rounded-3 border border-2 {{ $gIdx === 0 ? 'border-primary' : 'border-light' }} cursor-pointer object-fit-cover shadow-xs hover-lift" style="width: 86px; height: 62px;" title="View photo {{ $gIdx + 1 }} in lightbox">
                        @endforeach
                    </div>
                @endif

                <!-- Vehicle Specifications -->
                <div class="dashboard-card mb-4 border-0 shadow-sm rounded-4 bg-white">
                    <div class="card-header-custom p-4 border-bottom d-flex justify-content-between align-items-center">
                        <h5 class="fw-bold mb-0 text-dark"><i class="fas fa-sliders me-2 text-primary"></i> Vehicle Specifications</h5>
                        <span class="badge bg-primary-subtle text-primary fw-semibold px-3 py-1 rounded-pill">Verified Specs</span>
                    </div>
                    <div class="card-body-custom p-4">
                        <div class="row g-3">
                            <div class="col-6 col-md-4">
                                <div class="spec-card-modern">
                                    <div class="spec-icon-badge"><i class="fas fa-car-side"></i></div>
                                    <div class="small text-muted">Brand & Model</div>
                                    <div class="fw-bold text-dark fs-6">{{ $car->brand }} {{ $car->model }}</div>
                                </div>
                            </div>
                            <div class="col-6 col-md-4">
                                <div class="spec-card-modern">
                                    <div class="spec-icon-badge"><i class="fas fa-gas-pump"></i></div>
                                    <div class="small text-muted">Fuel & Mileage</div>
                                    <div class="fw-bold text-dark fs-6">{{ $car->fuel_type }} (21.5 km/l)</div>
                                </div>
                            </div>
                            <div class="col-6 col-md-4">
                                <div class="spec-card-modern">
                                    <div class="spec-icon-badge"><i class="fas fa-gears"></i></div>
                                    <div class="small text-muted">Transmission</div>
                                    <div class="fw-bold text-dark fs-6">{{ $car->transmission }}</div>
                                </div>
                            </div>
                            <div class="col-6 col-md-4">
                                <div class="spec-card-modern">
                                    <div class="spec-icon-badge"><i class="fas fa-users"></i></div>
                                    <div class="small text-muted">Seating Capacity</div>
                                    <div class="fw-bold text-dark fs-6">{{ $car->seating_capacity }} Seats</div>
                                </div>
                            </div>
                            <div class="col-6 col-md-4">
                                <div class="spec-card-modern">
                                    <div class="spec-icon-badge"><i class="fas fa-suitcase"></i></div>
                                    <div class="small text-muted">Luggage Boot</div>
                                    <div class="fw-bold text-dark fs-6">318 Litres (2 Bags)</div>
                                </div>
                            </div>
                            <div class="col-6 col-md-4">
                                <div class="spec-card-modern">
                                    <div class="spec-icon-badge"><i class="fas fa-shield-halved"></i></div>
                                    <div class="small text-muted">Safety Specs</div>
                                    <div class="fw-bold text-dark fs-6">6 Airbags + ABS</div>
                                </div>
                            </div>
                        </div>

                        <!-- Included Rental Perks & Trust Badges -->
                        <div class="mt-4 pt-3 border-top">
                            <h6 class="fw-bold text-dark mb-3 small text-uppercase">Included With This Vehicle</h6>
                            <div class="d-flex flex-wrap gap-2">
                                <span class="perk-badge-pill"><i class="fas fa-infinity text-primary"></i> Unlimited KMs Included</span>
                                <span class="perk-badge-pill"><i class="fas fa-bolt text-warning"></i> Active FASTag Equipped</span>
                                <span class="perk-badge-pill"><i class="fas fa-shield-check text-success"></i> Zero-Dep Insurance</span>
                                <span class="perk-badge-pill"><i class="fas fa-spray-can text-info"></i> Sanitized Handover</span>
                                <span class="perk-badge-pill"><i class="fas fa-headset text-danger"></i> 24/7 Roadside Assist</span>
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
                                    <form action="{{ route('customer.bookings.create', $car->id) }}" method="GET" id="bookingForm" onsubmit="preparePickupLocation(event)">
                                        <input type="hidden" name="pickup_location" id="final_pickup_location">

                                        <!-- Delivery Address Section -->
                                        <label class="form-label small fw-bold text-muted text-uppercase mb-2">Delivery Address</label>
                                        <div class="mb-3">
                                            <div class="p-3 border rounded-3 bg-light">
                                                <div class="d-flex align-items-center justify-content-between mb-2">
                                                    <span class="text-primary small fw-bold"><i class="fas fa-location-dot me-1"></i> Your Delivery Location</span>
                                                    <button type="button" class="btn btn-sm btn-outline-primary py-0 px-2 rounded-pill fw-bold" onclick="detectGPSLocation(event)" style="font-size: 0.75rem;" id="gpsBtn">
                                                        <i class="fas fa-location-crosshairs me-1"></i> 📍 Use Current Location
                                                    </button>
                                                </div>

                                                <!-- Google Places Autocomplete Search -->
                                                <div class="input-group input-group-sm mb-2">
                                                    <span class="input-group-text bg-white border-end-0"><i class="fas fa-search text-muted"></i></span>
                                                    <input type="text" id="places_search" class="form-control border-start-0 fw-medium" placeholder="🔍 Search Delivery Address..." autocomplete="off">
                                                </div>

                                                <!-- Google Maps -->
                                                <div id="pickupMap" class="w-100 rounded-3 mb-2 border shadow-sm" style="height: 200px; z-index: 1;"></div>

                                                <small class="text-muted d-block mb-2 text-center" style="font-size: 0.72rem;">
                                                    <i class="fas fa-hand-pointer me-1 text-primary"></i> You can also drag pin or click map to set delivery location
                                                </small>

                                                <input type="text" id="pickup_flat" class="form-control form-control-sm mb-2 border-1 fw-semibold text-dark" placeholder="Flat / House / Office Name & No *" required>
                                                <input type="text" id="pickup_landmark" class="form-control form-control-sm mb-2 border-1" placeholder="Landmark *" required>
                                                <div class="row g-2">
                                                    <div class="col-7">
                                                        <input type="text" id="pickup_city" class="form-control form-control-sm border-1" placeholder="City *" required>
                                                    </div>
                                                    <div class="col-5">
                                                        <input type="text" id="pickup_pincode" class="form-control form-control-sm border-1" placeholder="Pincode *" pattern="[0-9]{6}" maxlength="6" required>
                                                    </div>
                                                </div>
                                                <small class="text-muted d-block mt-2" style="font-size: 0.73rem;">
                                                    <i class="fas fa-shield-alt text-success me-1"></i> Vehicle will be delivered to your selected address.
                                                </small>
                                            </div>
                                        </div>

                                        <!-- Interactive Rental Dates Range Picker -->
                                        <div class="mb-3">
                                            <label class="form-label small fw-bold text-muted text-uppercase mb-1">
                                                <i class="fas fa-calendar-alt text-primary me-1"></i> Rental Period (Pickup & Return)
                                            </label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-white border-2 border-end-0 text-primary"><i class="fas fa-calendar-days"></i></span>
                                                <input type="text" id="desktop_date_range_picker" class="form-control border-2 border-start-0 fw-semibold bg-white cursor-pointer py-2" placeholder="Select Pickup & Return Dates" readonly required>
                                            </div>
                                            <input type="hidden" name="pickup_date" id="pickup_date" value="{{ date('Y-m-d') }}">
                                            <input type="hidden" name="return_date" id="return_date" value="{{ date('Y-m-d', strtotime('+1 day')) }}">
                                            <small class="text-muted d-block mt-1 fs-7">
                                                <i class="fas fa-circle-info text-primary me-1"></i> Crossed-out dates are already booked for this car.
                                            </small>
                                        </div>

                                        <!-- Fare Summary Breakdown Box with Duration Discounts -->
                                        <div class="p-3 bg-light rounded-3 mb-4 border" id="fareBox">
                                            <div class="d-flex justify-content-between small text-muted mb-1">
                                                <span>Rental Base Rate</span>
                                                <span id="rentalCharge">₹{{ number_format($car->rental_price_per_day, 0) }} × <span id="daysCount">1</span> day</span>
                                            </div>
                                            <div class="d-flex justify-content-between small text-success mb-1" id="discountRow" style="display: none;">
                                                <span><i class="fas fa-tag me-1"></i> Duration Discount (<span id="discountPercent">0%</span>)</span>
                                                <span id="discountAmount" class="fw-bold">-₹0</span>
                                            </div>
                                            <div class="d-flex justify-content-between small text-muted mb-1">
                                                <span>Doorstep Vehicle Delivery</span>
                                                <span class="badge bg-success-subtle text-success">FREE</span>
                                            </div>
                                            <div class="d-flex justify-content-between small text-muted mb-2">
                                                <span>Security Deposit</span>
                                                <span>₹2,000 <small class="text-success fw-medium">(100% Refundable)</small></span>
                                            </div>
                                            <hr class="my-2">
                                            <div class="d-flex justify-content-between fw-bold text-dark fs-6">
                                                <span>Estimated Total</span>
                                                <span class="text-primary fs-5" id="grandTotal">₹{{ number_format($car->rental_price_per_day + 2000, 0) }}</span>
                                            </div>
                                        </div>

                                        <button type="submit" class="btn btn-liquid-primary btn-lg w-100 rounded-pill fw-bold shadow-sm">
                                            Proceed to Booking <i class="fas fa-arrow-right ms-2"></i>
                                        </button>

                                        <!-- 4 High-Trust Micro-Badges -->
                                        <div class="mt-4 pt-3 border-top">
                                            <div class="row g-2 text-muted">
                                                <div class="col-6">
                                                    <div class="d-flex align-items-center gap-2 p-2 rounded-3 bg-white border shadow-2xs">
                                                        <i class="fas fa-rotate-left text-success fs-5"></i>
                                                        <div>
                                                            <strong class="d-block text-dark" style="font-size: 0.75rem;">Free Cancellation</strong>
                                                            <span class="text-muted" style="font-size: 0.68rem;">100% refund up to 24h</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="d-flex align-items-center gap-2 p-2 rounded-3 bg-white border shadow-2xs">
                                                        <i class="fas fa-shield-check text-primary fs-5"></i>
                                                        <div>
                                                            <strong class="d-block text-dark" style="font-size: 0.75rem;">Zero Hidden Charges</strong>
                                                            <span class="text-muted" style="font-size: 0.68rem;">Taxes & insurance incl.</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="d-flex align-items-center gap-2 p-2 rounded-3 bg-white border shadow-2xs">
                                                        <i class="fas fa-bolt text-warning fs-5"></i>
                                                        <div>
                                                            <strong class="d-block text-dark" style="font-size: 0.75rem;">Instant Booking</strong>
                                                            <span class="text-muted" style="font-size: 0.68rem;">Guaranteed reservation</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="d-flex align-items-center gap-2 p-2 rounded-3 bg-white border shadow-2xs">
                                                        <i class="fas fa-lock text-info fs-5"></i>
                                                        <div>
                                                            <strong class="d-block text-dark" style="font-size: 0.75rem;">Deposit Safe</strong>
                                                            <span class="text-muted" style="font-size: 0.68rem;">Fast 48h auto-refund</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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
                                        <label class="form-label small fw-bold text-muted">Delivery Address</label>
                                        <input type="text" name="pickup_location" class="form-control border-2" placeholder="Enter your delivery address" required>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label small fw-bold text-muted">Rental Dates</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-white border-2 border-end-0 text-primary"><i class="fas fa-calendar-days"></i></span>
                                            <input type="text" id="guest_date_range_picker" class="form-control border-2 border-start-0 fw-semibold bg-white cursor-pointer" placeholder="Select Pickup & Return Dates" readonly required>
                                        </div>
                                        <input type="hidden" name="pickup_date" id="guest_pickup_date" value="{{ date('Y-m-d') }}">
                                        <input type="hidden" name="return_date" id="guest_return_date" value="{{ date('Y-m-d', strtotime('+1 day')) }}">
                                    </div>

                                    <a href="{{ route('login') }}" class="btn btn-liquid-primary btn-lg w-100 rounded-pill fw-bold shadow-sm">
                                        Sign In to Book <i class="fas fa-lock ms-2"></i>
                                    </a>

                                    <!-- 4 High-Trust Micro-Badges -->
                                    <div class="mt-4 pt-3 border-top">
                                        <div class="row g-2 text-muted">
                                            <div class="col-6">
                                                <div class="p-2 rounded-3 bg-white border text-center">
                                                    <i class="fas fa-rotate-left text-success mb-1"></i>
                                                    <div class="fw-bold text-dark" style="font-size: 0.72rem;">Free Cancellation</div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="p-2 rounded-3 bg-white border text-center">
                                                    <i class="fas fa-shield-check text-primary mb-1"></i>
                                                    <div class="fw-bold text-dark" style="font-size: 0.72rem;">Zero Hidden Charges</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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

    <!-- Mobile Sticky Booking Bar (Docked Bottom on Viewports < 768px) -->
    <div class="d-md-none fixed-bottom bg-white border-top shadow-lg px-3 py-2.5 d-flex justify-content-between align-items-center" style="z-index: 1040;">
        <div>
            <div class="fw-bold text-dark fs-5 mb-0">
                ₹{{ number_format($car->rental_price_per_day, 0) }} <small class="text-muted fs-7 fw-normal">/day</small>
            </div>
            <div class="text-muted" style="font-size: 0.73rem;">
                <i class="fas fa-shield-check text-success me-1"></i> Verified Self-Drive Fleet
            </div>
        </div>
        @if($car->status === 'Available')
            <button type="button" class="btn btn-liquid-primary rounded-pill px-4 py-2 fw-bold shadow-sm" data-bs-toggle="offcanvas" data-bs-target="#mobileBookingDrawer">
                Rent Now <i class="fas fa-arrow-right ms-1"></i>
            </button>
        @else
            <button class="btn btn-secondary rounded-pill px-3 py-2 fw-semibold fs-7" disabled>
                {{ $car->status }}
            </button>
        @endif
    </div>

    <!-- Mobile Offcanvas Booking Drawer -->
    <div class="offcanvas offcanvas-bottom rounded-top-4 border-0 shadow-2xl" tabindex="-1" id="mobileBookingDrawer" style="height: 88vh; z-index: 1050;" aria-labelledby="mobileBookingDrawerLabel">
        <div class="offcanvas-header border-bottom py-3 px-4 bg-light">
            <div>
                <h6 class="offcanvas-title fw-bold text-dark mb-0" id="mobileBookingDrawerLabel">
                    <i class="fas fa-calendar-check me-2 text-primary"></i> Reserve {{ $car->brand }} {{ $car->model }}
                </h6>
                <small class="text-muted">₹{{ number_format($car->rental_price_per_day, 0) }} / day · Free Doorstep Delivery</small>
            </div>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body p-4">
            @auth
                @if(auth()->user()->isCustomer())
                    <form action="{{ route('customer.bookings.create', $car->id) }}" method="GET" id="mobileBookingForm" onsubmit="prepareMobilePickupLocation(event)">
                        <input type="hidden" name="pickup_location" id="mobile_final_pickup_location">
                        
                        <!-- Date Selector with Range Picker -->
                        <label class="form-label small fw-bold text-muted text-uppercase mb-2">Trip Rental Dates</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text bg-white border-2 border-end-0 text-primary"><i class="fas fa-calendar-days"></i></span>
                            <input type="text" id="mobile_date_range_picker" class="form-control border-2 border-start-0 fw-semibold" placeholder="Select Pickup & Return Dates" required readonly>
                        </div>
                        <input type="hidden" name="pickup_date" id="mobile_pickup_date" value="{{ date('Y-m-d') }}">
                        <input type="hidden" name="return_date" id="mobile_return_date" value="{{ date('Y-m-d', strtotime('+1 day')) }}">

                        <!-- Delivery Address Input -->
                        <label class="form-label small fw-bold text-muted text-uppercase mb-2">Delivery Address in Ahmedabad</label>
                        <div class="mb-3">
                            <textarea class="form-control mb-2 border-2" id="mobile_pickup_address" rows="2" placeholder="House / Flat No, Street, Area, Landmark *" required></textarea>
                            <div class="row g-2">
                                <div class="col-7">
                                    <input type="text" id="mobile_pickup_city" class="form-control form-control-sm border-2" placeholder="City" value="Ahmedabad" required>
                                </div>
                                <div class="col-5">
                                    <input type="text" id="mobile_pickup_pincode" class="form-control form-control-sm border-2" placeholder="Pincode *" pattern="[0-9]{6}" maxlength="6" required>
                                </div>
                            </div>
                        </div>

                        <!-- Dynamic Live Price Breakdown -->
                        <div class="p-3 bg-light rounded-3 mb-3 border">
                            <div class="d-flex justify-content-between small text-muted mb-1">
                                <span>Base Rate (<span id="mobileDaysCount">1</span> Day)</span>
                                <span id="mobileBaseRent">₹{{ number_format($car->rental_price_per_day, 0) }}</span>
                            </div>
                            <div class="d-flex justify-content-between small text-success mb-1" id="mobileDiscountRow" style="display: none;">
                                <span>Duration Discount</span>
                                <span id="mobileDiscountAmount" class="fw-bold">-₹0</span>
                            </div>
                            <div class="d-flex justify-content-between small text-muted mb-1">
                                <span>Security Deposit (100% Refundable)</span>
                                <span>₹2,000</span>
                            </div>
                            <div class="d-flex justify-content-between small text-muted mb-2">
                                <span>Doorstep Delivery</span>
                                <span class="badge bg-success-subtle text-success">FREE</span>
                            </div>
                            <hr class="my-2">
                            <div class="d-flex justify-content-between fw-bold text-dark fs-6">
                                <span>Estimated Total</span>
                                <span class="text-primary fs-5" id="mobileGrandTotal">₹{{ number_format($car->rental_price_per_day + 2000, 0) }}</span>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-liquid-primary btn-lg w-100 rounded-pill fw-bold mb-3 shadow-sm">
                            Proceed to Booking <i class="fas fa-arrow-right ms-2"></i>
                        </button>
                    </form>
                @endif
            @else
                <div class="text-center py-4">
                    <i class="fas fa-user-lock text-primary display-4 mb-3"></i>
                    <h5 class="fw-bold">Sign In to Reserve</h5>
                    <p class="text-muted small mb-4">Please log in to your AutoLux account to verify driving credentials and book this vehicle.</p>
                    <a href="{{ route('login') }}" class="btn btn-liquid-primary rounded-pill px-4 py-2 fw-bold w-100 shadow-sm">
                        Sign In to Book <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            @endauth
        </div>
    </div>

    <!-- Full-Screen Interactive Gallery Lightbox Modal -->
    <div class="modal fade" id="carGalleryLightbox" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content bg-dark text-white border-0">
                <div class="modal-header border-0 pb-0 d-flex justify-content-between align-items-center px-4 pt-3">
                    <div class="d-flex align-items-center gap-3">
                        <h5 class="modal-title fw-bold text-white mb-0 font-display">{{ $car->brand }} {{ $car->model }}</h5>
                        <span class="badge bg-white bg-opacity-10 text-white rounded-pill px-3 py-1" id="lightboxCounter">1 / {{ count($galleryList) }}</span>
                    </div>
                    <!-- Category Tabs -->
                    <div class="d-none d-md-flex gap-2">
                        <button type="button" class="btn btn-sm btn-outline-light rounded-pill px-3 active lightbox-tab" onclick="filterLightbox('all', this)">All ({{ count($galleryList) }})</button>
                        <button type="button" class="btn btn-sm btn-outline-light rounded-pill px-3 lightbox-tab" onclick="filterLightbox('exterior', this)">Exterior</button>
                        <button type="button" class="btn btn-sm btn-outline-light rounded-pill px-3 lightbox-tab" onclick="filterLightbox('interior', this)">Cabin & Specs</button>
                    </div>
                    <button type="button" class="btn btn-outline-light btn-sm rounded-circle d-flex align-items-center justify-content-center" data-bs-dismiss="modal" aria-label="Close" style="width: 40px; height: 40px;">
                        <i class="fas fa-times fs-5"></i>
                    </button>
                </div>
                <div class="modal-body d-flex flex-column align-items-center justify-content-center position-relative p-0 overflow-hidden">
                    <!-- Prev Button -->
                    <button type="button" class="btn btn-dark bg-opacity-60 text-white position-absolute start-0 top-50 translate-middle-y ms-3 rounded-circle shadow-lg z-3 border-0 d-flex align-items-center justify-content-center" onclick="prevLightboxImage()" style="width: 52px; height: 52px;" aria-label="Previous image">
                        <i class="fas fa-chevron-left fs-5"></i>
                    </button>
                    <!-- Main Lightbox Image -->
                    <div class="w-100 h-100 d-flex align-items-center justify-content-center p-3">
                        <img id="lightboxMainImage" src="{{ count($galleryList) > 0 ? $galleryList[0]['src'] : '' }}" alt="{{ $car->display_name }}" class="img-fluid rounded-3 shadow-2xl object-fit-contain" style="max-height: 75vh; max-width: 90vw; transition: opacity 0.2s ease;">
                    </div>
                    <!-- Next Button -->
                    <button type="button" class="btn btn-dark bg-opacity-60 text-white position-absolute end-0 top-50 translate-middle-y me-3 rounded-circle shadow-lg z-3 border-0 d-flex align-items-center justify-content-center" onclick="nextLightboxImage()" style="width: 52px; height: 52px;" aria-label="Next image">
                        <i class="fas fa-chevron-right fs-5"></i>
                    </button>
                </div>
                <!-- Bottom Thumbnail Strip -->
                <div class="modal-footer border-0 justify-content-center py-3 bg-black bg-opacity-50 overflow-x-auto">
                    <div class="d-flex gap-2" id="lightboxThumbStrip">
                        @foreach($galleryList as $idx => $item)
                            <img src="{{ $item['src'] }}" data-category="{{ $item['category'] }}" onclick="setLightboxIndex({{ $idx }})" class="rounded-2 border border-2 {{ $idx === 0 ? 'border-primary' : 'border-transparent' }} lightbox-thumb" style="width: 72px; height: 50px; object-fit: cover;">
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
    let pickupMap, pickupMarker, geocoder;
    const DEFAULT_LAT = 23.0225; // Ahmedabad Center
    const DEFAULT_LNG = 72.5714;

    function initPickupMap() {
        if (pickupMap) return;

        const mapContainer = document.getElementById('pickupMap');
        if (!mapContainer || typeof google === 'undefined') return;

        geocoder = new google.maps.Geocoder();

        const defaultPos = { lat: DEFAULT_LAT, lng: DEFAULT_LNG };

        pickupMap = new google.maps.Map(mapContainer, {
            center: defaultPos,
            zoom: 14,
            mapTypeControl: false,
            streetViewControl: false,
            fullscreenControl: false,
            zoomControl: true,
            styles: [
                { featureType: "poi", stylers: [{ visibility: "off" }] },
                { featureType: "transit", stylers: [{ visibility: "off" }] }
            ]
        });

        pickupMarker = new google.maps.Marker({
            position: defaultPos,
            map: pickupMap,
            draggable: true,
            animation: google.maps.Animation.DROP,
            title: 'Delivery Location'
        });

        const infoWindow = new google.maps.InfoWindow({
            content: '<b>📍 Delivery Location</b><br>Drag pin or click map to move'
        });
        infoWindow.open(pickupMap, pickupMarker);

        // Map click event
        pickupMap.addListener('click', function(e) {
            pickupMarker.setPosition(e.latLng);
            reverseGeocode(e.latLng.lat(), e.latLng.lng());
            infoWindow.close();
        });

        // Marker drag event
        pickupMarker.addListener('dragend', function() {
            const pos = pickupMarker.getPosition();
            reverseGeocode(pos.lat(), pos.lng());
            infoWindow.close();
        });

        // Google Places Autocomplete
        const searchInput = document.getElementById('places_search');
        if (searchInput) {
            const autocomplete = new google.maps.places.Autocomplete(searchInput, {
                types: ['geocode', 'establishment'],
                componentRestrictions: { country: 'in' }
            });
            autocomplete.bindTo('bounds', pickupMap);

            autocomplete.addListener('place_changed', function() {
                const place = autocomplete.getPlace();
                if (!place.geometry || !place.geometry.location) return;

                pickupMap.setCenter(place.geometry.location);
                pickupMap.setZoom(16);
                pickupMarker.setPosition(place.geometry.location);

                // Extract address components
                if (place.address_components) {
                    fillAddressFromComponents(place.address_components);
                }
            });
        }

        // Initial reverse geocode
        reverseGeocode(DEFAULT_LAT, DEFAULT_LNG);
    }

    function reverseGeocode(lat, lng) {
        if (!geocoder) return;

        geocoder.geocode({ location: { lat: lat, lng: lng } }, function(results, status) {
            if (status === 'OK' && results[0]) {
                fillAddressFromComponents(results[0].address_components);
            }
        });
    }

    function fillAddressFromComponents(addressComponents) {
        let city = '', pincode = '', landmark = '';

        addressComponents.forEach(function(component) {
            const types = component.types;
            if (types.includes('locality')) {
                city = component.long_name;
            }
            if (types.includes('postal_code')) {
                pincode = component.long_name;
            }
            if (types.includes('sublocality_level_1') || types.includes('sublocality')) {
                landmark = component.long_name;
            }
            if (!landmark && (types.includes('neighborhood') || types.includes('route'))) {
                landmark = component.long_name;
            }
        });

        const cityInput = document.getElementById('pickup_city');
        if (cityInput && city) cityInput.value = city;

        const pincodeInput = document.getElementById('pickup_pincode');
        if (pincodeInput && pincode) pincodeInput.value = pincode;

        const landmarkInput = document.getElementById('pickup_landmark');
        if (landmarkInput && landmark) landmarkInput.value = landmark;
    }

    function detectGPSLocation(e) {
        if (!navigator.geolocation) {
            alert('Geolocation is not supported by your browser.');
            return;
        }

        const btn = e ? e.currentTarget : null;
        if (btn) btn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Locating...';

        navigator.geolocation.getCurrentPosition(
            position => {
                const lat = position.coords.latitude;
                const lng = position.coords.longitude;
                const pos = { lat: lat, lng: lng };

                if (pickupMap && pickupMarker) {
                    pickupMap.setCenter(pos);
                    pickupMap.setZoom(16);
                    pickupMarker.setPosition(pos);

                    const infoWindow = new google.maps.InfoWindow({
                        content: '<b>🎯 Your Current Location</b>'
                    });
                    infoWindow.open(pickupMap, pickupMarker);

                    reverseGeocode(lat, lng);
                }

                if (btn) {
                    btn.innerHTML = '<i class="fas fa-check text-success me-1"></i> Located';
                    setTimeout(() => { btn.innerHTML = '<i class="fas fa-location-crosshairs me-1"></i> 📍 Use Current Location'; }, 3000);
                }
            },
            error => {
                alert('Unable to retrieve location. Please drag the pin on the map or search for your address.');
                if (btn) btn.innerHTML = '<i class="fas fa-location-crosshairs me-1"></i> 📍 Use Current Location';
            },
            { enableHighAccuracy: true, timeout: 10000 }
        );
    }

    function preparePickupLocation(e) {
        const flat = document.getElementById('pickup_flat') ? document.getElementById('pickup_flat').value.trim() : '';
        const landmark = document.getElementById('pickup_landmark') ? document.getElementById('pickup_landmark').value.trim() : '';
        const city = document.getElementById('pickup_city') ? document.getElementById('pickup_city').value.trim() : '';
        const pincode = document.getElementById('pickup_pincode') ? document.getElementById('pickup_pincode').value.trim() : '';

        let finalLocation = '';
        if (flat) finalLocation += flat;
        if (landmark) finalLocation += ', ' + landmark;
        if (city) finalLocation += ', ' + city;
        if (pincode) finalLocation += ' - ' + pincode;

        document.getElementById('final_pickup_location').value = finalLocation;
    }

    function prepareMobilePickupLocation(e) {
        const addr = document.getElementById('mobile_pickup_address') ? document.getElementById('mobile_pickup_address').value.trim() : '';
        const city = document.getElementById('mobile_pickup_city') ? document.getElementById('mobile_pickup_city').value.trim() : '';
        const pincode = document.getElementById('mobile_pickup_pincode') ? document.getElementById('mobile_pickup_pincode').value.trim() : '';

        let finalLocation = addr;
        if (city) finalLocation += ', ' + city;
        if (pincode) finalLocation += ' - ' + pincode;

        document.getElementById('mobile_final_pickup_location').value = finalLocation;
    }

    /* Dynamic Pricing Engine with Duration Discounts */
    function calculateTotal(startDate, endDate) {
        const rate = {{ $car->rental_price_per_day }};
        const pInput = document.getElementById('pickup_date');
        const rInput = document.getElementById('return_date');

        let pDate = startDate || (pInput ? new Date(pInput.value) : null);
        let rDate = endDate || (rInput ? new Date(rInput.value) : null);

        if (pDate && rDate && rDate > pDate) {
            const diffTime = Math.abs(rDate - pDate);
            const diffDays = Math.max(1, Math.ceil(diffTime / (1000 * 60 * 60 * 24)));
            
            // Duration Discount: 10% for 7+ days, 5% for 3+ days
            let discountRate = 0;
            if (diffDays >= 7) {
                discountRate = 0.10;
            } else if (diffDays >= 3) {
                discountRate = 0.05;
            }

            const baseRental = diffDays * rate;
            const discountAmount = Math.round(baseRental * discountRate);
            const total = (baseRental - discountAmount) + 2000;

            // Update Desktop Card
            const daysCountEl = document.getElementById('daysCount');
            const rentalChargeEl = document.getElementById('rentalCharge');
            const grandTotalEl = document.getElementById('grandTotal');
            const discountRow = document.getElementById('discountRow');
            const discountAmountEl = document.getElementById('discountAmount');
            const discountPercentEl = document.getElementById('discountPercent');

            if (daysCountEl) daysCountEl.innerText = diffDays;
            if (rentalChargeEl) rentalChargeEl.innerText = '₹' + baseRental.toLocaleString('en-IN') + ' × ' + diffDays + ' ' + (diffDays === 1 ? 'day' : 'days');
            
            if (discountRow) {
                if (discountAmount > 0) {
                    discountRow.style.display = 'flex';
                    if (discountPercentEl) discountPercentEl.innerText = (discountRate * 100) + '% OFF';
                    if (discountAmountEl) discountAmountEl.innerText = '-₹' + discountAmount.toLocaleString('en-IN');
                } else {
                    discountRow.style.display = 'none';
                }
            }

            if (grandTotalEl) grandTotalEl.innerText = '₹' + total.toLocaleString('en-IN');

            // Update Mobile Drawer
            const mDays = document.getElementById('mobileDaysCount');
            const mBase = document.getElementById('mobileBaseRent');
            const mDiscRow = document.getElementById('mobileDiscountRow');
            const mDisc = document.getElementById('mobileDiscountAmount');
            const mTotal = document.getElementById('mobileGrandTotal');

            if (mDays) mDays.innerText = diffDays;
            if (mBase) mBase.innerText = '₹' + baseRental.toLocaleString('en-IN');
            if (mDiscRow) {
                if (discountAmount > 0) {
                    mDiscRow.style.display = 'flex';
                    if (mDisc) mDisc.innerText = '-₹' + discountAmount.toLocaleString('en-IN') + ' (' + (discountRate * 100) + '%)';
                } else {
                    mDiscRow.style.display = 'none';
                }
            }
            if (mTotal) mTotal.innerText = '₹' + total.toLocaleString('en-IN');
        }
    }

    /* Full-Screen Gallery Lightbox Controller */
    const galleryItems = @json($galleryList);
    let currentLightboxIdx = 0;
    let activeFilter = 'all';

    function openLightbox(index) {
        setLightboxIndex(index || 0);
        const modalEl = document.getElementById('carGalleryLightbox');
        if (modalEl && typeof bootstrap !== 'undefined') {
            const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
            modal.show();
        }
    }

    function setLightboxIndex(index) {
        if (!galleryItems || galleryItems.length === 0) return;
        if (index < 0) index = galleryItems.length - 1;
        if (index >= galleryItems.length) index = 0;

        currentLightboxIdx = index;
        const item = galleryItems[index];

        const mainImg = document.getElementById('lightboxMainImage');
        const counter = document.getElementById('lightboxCounter');

        if (mainImg) {
            mainImg.style.opacity = '0.3';
            setTimeout(() => {
                mainImg.src = item.src;
                mainImg.style.opacity = '1';
            }, 100);
        }

        if (counter) {
            counter.innerText = (index + 1) + ' / ' + galleryItems.length;
        }

        // Highlight active thumbnail in strip
        document.querySelectorAll('#lightboxThumbStrip .lightbox-thumb').forEach((thumb, idx) => {
            if (idx === index) {
                thumb.classList.add('border-primary');
                thumb.classList.remove('border-transparent');
                thumb.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });
            } else {
                thumb.classList.remove('border-primary');
                thumb.classList.add('border-transparent');
            }
        });
    }

    function nextLightboxImage() {
        setLightboxIndex(currentLightboxIdx + 1);
    }

    function prevLightboxImage() {
        setLightboxIndex(currentLightboxIdx - 1);
    }

    function filterLightbox(category, tabBtn) {
        activeFilter = category;
        document.querySelectorAll('.lightbox-tab').forEach(b => b.classList.remove('active'));
        if (tabBtn) tabBtn.classList.add('active');

        document.querySelectorAll('#lightboxThumbStrip .lightbox-thumb').forEach(thumb => {
            const thumbCat = thumb.getAttribute('data-category');
            if (category === 'all' || thumbCat === category) {
                thumb.style.display = 'block';
            } else {
                thumb.style.display = 'none';
            }
        });
    }

    // Keyboard navigation in lightbox
    document.addEventListener('keydown', function(e) {
        const modalEl = document.getElementById('carGalleryLightbox');
        if (modalEl && modalEl.classList.contains('show')) {
            if (e.key === 'ArrowRight') nextLightboxImage();
            if (e.key === 'ArrowLeft') prevLightboxImage();
        }
    });

    // Wait for Google Maps API to be ready
    function waitForGoogleMaps() {
        if (typeof google !== 'undefined' && typeof google.maps !== 'undefined') {
            initPickupMap();
        } else {
            setTimeout(waitForGoogleMaps, 100);
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        waitForGoogleMaps();

        // Initialize Flatpickr with Booked-Dates Disabling & Range Mode
        const bookedRanges = @json($bookedRanges);
        const tomorrow = new Date();
        tomorrow.setDate(tomorrow.getDate() + 1);

        const flatpickrConfig = {
            mode: 'range',
            minDate: 'today',
            dateFormat: 'Y-m-d',
            altInput: true,
            altFormat: 'M j, Y',
            disable: bookedRanges,
            defaultDate: [new Date(), tomorrow],
            locale: {
                rangeSeparator: '  ⟶  '
            },
            onChange: function(selectedDates) {
                if (selectedDates.length === 2) {
                    const start = selectedDates[0];
                    const end = selectedDates[1];
                    const startStr = start.toISOString().split('T')[0];
                    const endStr = end.toISOString().split('T')[0];

                    // Sync desktop hidden inputs
                    const pInput = document.getElementById('pickup_date');
                    const rInput = document.getElementById('return_date');
                    if (pInput) pInput.value = startStr;
                    if (rInput) rInput.value = endStr;

                    // Sync mobile hidden inputs
                    const mpInput = document.getElementById('mobile_pickup_date');
                    const mrInput = document.getElementById('mobile_return_date');
                    if (mpInput) mpInput.value = startStr;
                    if (mrInput) mrInput.value = endStr;

                    calculateTotal(start, end);
                }
            }
        };

        // Desktop Date Range Picker
        const desktopPickerEl = document.getElementById('desktop_date_range_picker');
        if (desktopPickerEl && typeof flatpickr !== 'undefined') {
            flatpickr(desktopPickerEl, flatpickrConfig);
        }

        // Guest Date Range Picker
        const guestPickerEl = document.getElementById('guest_date_range_picker');
        if (guestPickerEl && typeof flatpickr !== 'undefined') {
            flatpickr(guestPickerEl, flatpickrConfig);
        }

        // Mobile Date Range Picker
        const mobilePickerEl = document.getElementById('mobile_date_range_picker');
        if (mobilePickerEl && typeof flatpickr !== 'undefined') {
            flatpickr(mobilePickerEl, flatpickrConfig);
        }

        // Initial total calculation
        calculateTotal(new Date(), tomorrow);
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
@endpush
@endsection
