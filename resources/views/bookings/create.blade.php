@extends('layouts.app')

@section('title', 'Booking Checkout — AutoLux')

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
<style>
    #checkoutPickupMap {
        height: 320px;
        border-radius: 16px;
        z-index: 5;
    }
    .custom-leaflet-pin {
        background: transparent;
        border: none;
    }
    .step-pill {
        cursor: pointer;
        transition: all 0.25s ease;
    }
    .preset-pill {
        cursor: pointer;
        transition: all 0.2s ease;
        font-size: 0.8rem;
    }
    .preset-pill:hover, .preset-pill.active {
        background: linear-gradient(135deg, #ff7a00, #ea580c) !important;
        color: #ffffff !important;
        border-color: transparent !important;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(234, 88, 12, 0.35);
    }
    .stepper-circle {
        width: 44px;
        height: 44px;
        font-size: 1.1rem;
        transition: all 0.3s ease;
    }
    .search-suggestion-item {
        cursor: pointer;
    }
    .search-suggestion-item:hover {
        background-color: #f8fafc;
    }
    /* Liquid Primary Button Theme */
    .btn-liquid-primary {
        background: linear-gradient(135deg, #ff7a00, #ea580c) !important;
        color: #ffffff !important;
        border: none !important;
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1) !important;
        box-shadow: 0 4px 15px rgba(234, 88, 12, 0.35) !important;
        font-weight: 700 !important;
    }
    .btn-liquid-primary:hover {
        background: linear-gradient(135deg, #ea580c, #c2410c) !important;
        color: #ffffff !important;
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(234, 88, 12, 0.45) !important;
    }
</style>
@endpush

@section('content')
<section class="dashboard-section pb-5">
    <div class="container">
        <!-- Header -->
        <div class="dashboard-header mb-4" data-aos="fade-down">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                <div>
                    <h1 class="fw-bold mb-1 font-display">Complete Your Reservation</h1>
                    <p class="text-muted mb-0">Step-by-step booking for your {{ $car->brand }} {{ $car->model }}.</p>
                </div>
                <a href="{{ route('cars.show', $car->id) }}" class="btn btn-outline-secondary btn-sm rounded-pill">
                    <i class="fas fa-arrow-left me-1"></i> Back to Vehicle Details
                </a>
            </div>
        </div>

        <!-- 2-Step Modern Booking Stepper Bar -->
        <div class="mb-4" data-aos="fade-down">
            <div class="card border-0 shadow-sm rounded-4 bg-white p-3 p-md-4">
                <div class="d-flex align-items-center justify-content-center position-relative">
                    
                    <!-- Step 1 Indicator -->
                    <div class="d-flex align-items-center gap-3 step-pill" id="stepperTab1" onclick="goToStep(1)">
                        <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center shadow-sm flex-shrink-0 stepper-circle" id="stepperCircle1">
                            <i class="fas fa-map-marker-alt" id="stepperIcon1"></i>
                        </div>
                        <div>
                            <span class="badge bg-primary text-white fw-bold rounded-pill mb-1" style="font-size: 0.65rem;" id="stepperBadge1">STEP 1 • ACTIVE</span>
                            <div class="fw-bold text-dark small">1. Choose Delivery Address</div>
                        </div>
                    </div>

                    <!-- Connecting Line -->
                    <div class="flex-grow-1 mx-3 mx-md-4 border-top border-2 border-primary-subtle" style="max-width: 140px;" id="stepperDivider"></div>

                    <!-- Step 2 Indicator -->
                    <div class="d-flex align-items-center gap-3 opacity-60 step-pill" id="stepperTab2" onclick="validateAndGoToStep(2)">
                        <div class="rounded-circle bg-light border text-muted d-flex align-items-center justify-content-center flex-shrink-0 stepper-circle" id="stepperCircle2">
                            <i class="fas fa-credit-card" id="stepperIcon2"></i>
                        </div>
                        <div>
                            <span class="badge bg-light text-muted fw-bold rounded-pill mb-1" style="font-size: 0.65rem;" id="stepperBadge2">STEP 2</span>
                            <div class="fw-bold text-muted small">2. Review & Payment</div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- STEP 1: CHOOSE DELIVERY ADDRESS CONTAINER -->
        <div id="step1Container">
            <div class="row g-4">
                <!-- Left Column: Map & Address Form -->
                <div class="col-lg-7" data-aos="fade-right">
                    <div class="dashboard-card border-0 shadow-sm rounded-4 bg-white p-4 mb-4">
                        <div class="d-flex align-items-center justify-content-between mb-3 border-bottom pb-3">
                            <h5 class="fw-bold mb-0 text-dark font-display">
                                <i class="fas fa-location-dot text-primary me-2"></i> Where should we deliver your car?
                            </h5>
                            <span class="badge bg-success-subtle text-success fw-semibold px-3 py-1 rounded-pill">
                                <i class="fas fa-truck-fast me-1"></i> Free Doorstep Delivery
                            </span>
                        </div>

                        <!-- One-Tap Location Presets -->
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted text-uppercase mb-2">Quick Popular Hubs in Ahmedabad</label>
                            <div class="d-flex gap-2 flex-wrap">
                                <button type="button" class="btn btn-sm btn-white border rounded-pill px-3 py-1.5 preset-pill fw-medium" onclick="applyLocationPreset(23.0734, 72.6266, 'Terminal 2 Arrivals, Sardar Vallabhbhai Patel International Airport', 'Hansol', 'Ahmedabad', '380004', this)">
                                    ✈️ Ahmedabad Airport
                                </button>
                                <button type="button" class="btn btn-sm btn-white border rounded-pill px-3 py-1.5 preset-pill fw-medium" onclick="applyLocationPreset(23.0238, 72.6006, 'Platform 1 Main Gate, Kalupur Railway Station', 'Kalupur', 'Ahmedabad', '380002', this)">
                                    🚆 Railway Station
                                </button>
                                <button type="button" class="btn btn-sm btn-white border rounded-pill px-3 py-1.5 preset-pill fw-medium" onclick="applyLocationPreset(23.0304, 72.5074, 'Iskcon Mega Mall, SG Highway', 'Bodakdev', 'Ahmedabad', '380054', this)">
                                    🏢 SG Highway / Bodakdev
                                </button>
                                <button type="button" class="btn btn-sm btn-white border rounded-pill px-3 py-1.5 preset-pill fw-medium" onclick="detectCheckoutGPS(event)">
                                    📍 My Current Location
                                </button>
                            </div>
                        </div>

                        <!-- Interactive Address Search with Auto-Suggestions -->
                        <div class="position-relative mb-3">
                            <label class="form-label small fw-bold text-muted text-uppercase mb-1">Search Address / Area</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0 text-muted"><i class="fas fa-search"></i></span>
                                <input type="text" id="checkout_places_search" class="form-control border-start-0 fw-medium py-2" placeholder="Search address, hotel, society, or landmark in Ahmedabad..." autocomplete="off">
                                <button type="button" class="btn btn-light border border-start-0" id="checkoutClearSearchBtn" style="display: none;" onclick="clearCheckoutLocationSearch()"><i class="fas fa-times text-muted"></i></button>
                            </div>
                            <div id="checkoutSearchResultsDropdown" class="list-group position-absolute w-100 shadow-lg border rounded-3 overflow-hidden d-none" style="z-index: 1060; max-height: 220px; overflow-y: auto;"></div>
                        </div>

                        <!-- Interactive Leaflet Delivery Map -->
                        <div class="mb-3">
                            <div id="checkoutPickupMap" class="w-100 border shadow-xs"></div>
                            <small class="text-muted d-block mt-2 text-center fs-7">
                                <i class="fas fa-hand-pointer text-primary me-1"></i> You can also drag the orange pin or click anywhere on the map to place your delivery spot.
                            </small>
                        </div>

                        <!-- Address Form Fields -->
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label small fw-bold text-muted">Flat / House / Hotel / Office Name & Unit Number <span class="text-danger">*</span></label>
                                <input type="text" id="addr_flat" class="form-control border-2 fw-semibold" placeholder="e.g. Flat 402, Shivalik Highstreet or Hotel Hyatt" required>
                                <div class="invalid-feedback">Please enter your house, building, or hotel name.</div>
                            </div>
                            <div class="col-12">
                                <label class="form-label small fw-bold text-muted">Street / Area / Landmark <span class="text-danger">*</span></label>
                                <input type="text" id="addr_landmark" class="form-control border-2" placeholder="e.g. Near Judges Bungalow Cross Roads, Bodakdev" required>
                                <div class="invalid-feedback">Please enter your street or landmark.</div>
                            </div>
                            <div class="col-md-7">
                                <label class="form-label small fw-bold text-muted">City <span class="text-danger">*</span></label>
                                <input type="text" id="addr_city" class="form-control border-2" value="Ahmedabad" required>
                            </div>
                            <div class="col-md-5">
                                <label class="form-label small fw-bold text-muted">Pincode <span class="text-danger">*</span></label>
                                <input type="text" id="addr_pincode" class="form-control border-2" placeholder="e.g. 380054" maxlength="6" pattern="[0-9]{6}" required>
                                <div class="invalid-feedback">Please enter a valid 6-digit pincode.</div>
                            </div>
                        </div>

                        <!-- Action Button to Step 2 -->
                        <div class="mt-4 pt-3 border-top d-flex justify-content-end">
                            <button type="button" class="btn btn-liquid-primary btn-lg rounded-pill px-5 fw-bold shadow-sm" onclick="validateAndGoToStep(2)">
                                Confirm Address & Proceed to Payment <i class="fas fa-arrow-right ms-2"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Itinerary Overview & Fare Preview -->
                <div class="col-lg-5" data-aos="fade-left">
                    <div class="dashboard-card border-0 shadow-sm rounded-4 bg-white overflow-hidden sticky-top" style="top: 100px;">
                        <div class="p-4 border-bottom bg-light d-flex align-items-center gap-3">
                            <div class="rounded-3 overflow-hidden bg-white border" style="width: 75px; height: 55px; flex-shrink: 0;">
                                @if($car->thumbnail)
                                    <img src="{{ asset('storage/' . $car->thumbnail) }}" class="w-100 h-100 object-fit-cover">
                                @else
                                    <div class="d-flex align-items-center justify-content-center h-100 text-primary"><i class="fas fa-car fs-4"></i></div>
                                @endif
                            </div>
                            <div>
                                <h6 class="fw-bold text-dark mb-0 font-display">{{ $car->brand }} {{ $car->model }}</h6>
                                <div class="small text-muted">{{ $car->year }} · {{ $car->fuel_type }} · {{ $car->transmission }}</div>
                            </div>
                        </div>
                        <div class="p-4">
                            <div class="row g-2 mb-3">
                                <div class="col-6">
                                    <div class="p-2.5 rounded-3 bg-light border">
                                        <small class="text-muted d-block fs-7"><i class="fas fa-calendar-alt text-primary me-1"></i> Delivery Date</small>
                                        <strong class="text-dark">{{ $pickupDate->format('d M Y') }}</strong>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="p-2.5 rounded-3 bg-light border">
                                        <small class="text-muted d-block fs-7"><i class="fas fa-calendar-check text-primary me-1"></i> Return Date</small>
                                        <strong class="text-dark">{{ $returnDate->format('d M Y') }}</strong>
                                    </div>
                                </div>
                            </div>

                            <div class="p-3 bg-light rounded-3 mb-3 border">
                                <div class="d-flex justify-content-between small text-muted mb-1">
                                    <span>Rental Rate ({{ $days }} {{ $days === 1 ? 'day' : 'days' }})</span>
                                    <span class="text-dark fw-semibold">₹{{ number_format($rentalCost, 0) }}</span>
                                </div>
                                <div class="d-flex justify-content-between small text-muted mb-1">
                                    <span>Doorstep Delivery</span>
                                    <span class="badge bg-success-subtle text-success">FREE</span>
                                </div>
                                <div class="d-flex justify-content-between small text-muted mb-2">
                                    <span>Refundable Security Deposit</span>
                                    <span class="text-dark fw-semibold">₹{{ number_format($securityDeposit, 0) }}</span>
                                </div>
                                <hr class="my-2">
                                <div class="d-flex justify-content-between fw-bold text-dark fs-6">
                                    <span>Estimated Total</span>
                                    <span class="text-primary fs-5">₹{{ number_format($totalAmount, 0) }}</span>
                                </div>
                            </div>

                            <button type="button" class="btn btn-liquid-primary w-100 rounded-pill fw-bold py-2.5 shadow-sm" onclick="validateAndGoToStep(2)">
                                Continue to Payment <i class="fas fa-arrow-right ms-1"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- STEP 2: REVIEW & SECURE PAYMENT CONTAINER (Initially Hidden) -->
        <div id="step2Container" style="display: none;">
            <div class="row g-4">
                <!-- Left Column: Confirmed Details & Verification Cards -->
                <div class="col-lg-7" data-aos="fade-right">
                    
                    <!-- Confirmed Delivery Location Card -->
                    <div class="dashboard-card mb-4 border-0 shadow-sm rounded-4 bg-white p-4">
                        <div class="d-flex align-items-center justify-content-between border-bottom pb-3 mb-3">
                            <div class="d-flex align-items-center gap-2">
                                <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                    <i class="fas fa-check fs-7"></i>
                                </div>
                                <h6 class="fw-bold mb-0 text-dark font-display">Confirmed Delivery Location</h6>
                            </div>
                            <button type="button" class="btn btn-sm btn-outline-primary rounded-pill px-3 fw-bold" onclick="goToStep(1)">
                                <i class="fas fa-pen me-1"></i> Change Address
                            </button>
                        </div>
                        <div class="p-3 bg-light rounded-3 border d-flex align-items-start gap-3">
                            <i class="fas fa-location-dot text-primary fs-4 mt-1"></i>
                            <div class="flex-grow-1">
                                <div class="fw-bold text-dark fs-6" id="confirmed_delivery_title">Ahmedabad Delivery Location</div>
                                <div class="text-muted small" id="confirmed_delivery_full">Please set address in Step 1.</div>
                                <small class="text-success fw-semibold mt-1 d-block"><i class="fas fa-shield-check me-1"></i> Delivery agent will call before arrival.</small>
                            </div>
                        </div>
                    </div>

                    <!-- Rental Summary Card -->
                    <div class="dashboard-card mb-4 border-0 shadow-sm rounded-4 bg-white">
                        <div class="card-header-custom p-4 border-bottom">
                            <h5 class="fw-bold mb-0 text-dark"><i class="fas fa-route me-2 text-primary"></i> Itinerary Summary</h5>
                        </div>
                        <div class="card-body-custom p-4">
                            <div class="d-flex align-items-center gap-3 mb-4 p-3 bg-light rounded-3">
                                <div class="rounded-3 overflow-hidden bg-white border" style="width: 80px; height: 60px; flex-shrink: 0;">
                                    @if($car->thumbnail)
                                        <img src="{{ asset('storage/' . $car->thumbnail) }}" class="w-100 h-100 object-fit-cover">
                                    @else
                                        <div class="d-flex align-items-center justify-content-center h-100 text-primary">
                                            <i class="fas fa-car fs-4"></i>
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <h5 class="fw-bold mb-1 text-dark">{{ $car->brand }} {{ $car->model }}</h5>
                                    <div class="small text-muted">Reg No: {{ $car->registration_number }} | {{ $car->fuel_type }} | {{ $car->transmission }}</div>
                                </div>
                            </div>

                            <div class="row g-3">
                                <div class="col-6">
                                    <div class="p-3 border rounded-3 bg-white">
                                        <div class="small text-muted"><i class="fas fa-calendar-alt me-1 text-primary"></i> Pickup Date</div>
                                        <div class="fw-bold text-dark fs-6">{{ $pickupDate->format('d M Y') }}</div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="p-3 border rounded-3 bg-white">
                                        <div class="small text-muted"><i class="fas fa-calendar-check me-1 text-primary"></i> Return Date</div>
                                        <div class="fw-bold text-dark fs-6">{{ $returnDate->format('d M Y') }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Driver Contact & Verification Summary -->
                    <div class="dashboard-card border-0 shadow-sm rounded-4 bg-white mb-4">
                        <div class="card-header-custom p-4 border-bottom">
                            <h5 class="fw-bold mb-0 text-dark"><i class="fas fa-user-check me-2 text-primary"></i> Driver Information</h5>
                        </div>
                        <div class="card-body-custom p-4">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="small text-muted">Full Name</label>
                                    <div class="fw-bold text-dark">{{ auth()->user()->name }}</div>
                                </div>
                                <div class="col-md-6">
                                    <label class="small text-muted">Email</label>
                                    <div class="fw-bold text-dark">{{ auth()->user()->email }}</div>
                                </div>
                                <div class="col-md-6">
                                    <label class="small text-muted">Phone Number</label>
                                    <div class="fw-bold text-dark">{{ auth()->user()->phone ?? 'N/A' }}</div>
                                </div>
                                <div class="col-md-6">
                                    <label class="small text-muted">ID Verification Status</label>
                                    <div>
                                        <span class="badge bg-success"><i class="fas fa-shield-alt me-1"></i> Ready for Driving</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Final Fare Breakdown & Razorpay Checkout -->
                <div class="col-lg-5" data-aos="fade-left">
                    <div class="dashboard-card border-0 shadow-sm rounded-4 bg-white overflow-hidden sticky-top" style="top: 100px;">
                        <div class="card-header-custom p-4 text-white" style="background: linear-gradient(135deg, #0a1628 0%, #1a4a8a 100%);">
                            <h5 class="mb-0 text-white font-display"><i class="fas fa-receipt me-2 text-warning"></i> Payment Details</h5>
                        </div>
                        <div class="card-body-custom p-4">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Rental Charge (₹{{ number_format($car->rental_price_per_day, 0) }} × {{ $days }} days)</span>
                                <span class="fw-semibold text-dark">₹{{ number_format($rentalCost, 0) }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Delivery Charge</span>
                                <span class="fw-semibold text-success">Free</span>
                            </div>
                            <div class="d-flex justify-content-between mb-3">
                                <span class="text-muted">Security Deposit (100% Refundable)</span>
                                <span class="fw-semibold text-dark">₹{{ number_format($securityDeposit, 0) }}</span>
                            </div>

                            <hr>

                            <div class="d-flex justify-content-between mb-4">
                                <span class="fw-bold fs-5 text-dark">Total Payable</span>
                                <span class="fw-bold fs-4 text-primary">₹{{ number_format($totalAmount, 0) }}</span>
                            </div>

                            <!-- Hidden Form for Payment Callback Verification -->
                            <form action="{{ route('customer.bookings.store') }}" method="POST" id="upiPaymentForm">
                                @csrf
                                <input type="hidden" name="booking_id" value="{{ $booking->id }}">
                                <input type="hidden" name="car_id" value="{{ $car->id }}">
                                <input type="hidden" name="pickup_date" value="{{ $pickupDate->toDateString() }}">
                                <input type="hidden" name="return_date" value="{{ $returnDate->toDateString() }}">
                                <input type="hidden" name="pickup_location" id="final_pickup_location_input" value="{{ $request->pickup_location ?: 'Ahmedabad' }}">
                                
                                <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id">
                                <input type="hidden" name="razorpay_order_id" id="razorpay_order_id" value="{{ $razorpayOrder['id'] }}">
                                <input type="hidden" name="razorpay_signature" id="razorpay_signature">

                                <button type="button" id="payBtn" onclick="startRazorpayPayment()" class="btn btn-success btn-lg w-100 rounded-pill fw-bold py-3 shadow-lg" style="background: linear-gradient(135deg, #ff7a00, #ea580c); border: none;">
                                    <i class="fas fa-lock me-2"></i> Pay ₹{{ number_format($totalAmount, 0) }} via Razorpay — Proceed to Secure Payment
                                </button>
                            </form>

                            <div class="mt-4 p-3 bg-light rounded-4 border d-flex align-items-center justify-content-around text-muted small flex-wrap gap-2 text-center">
                                <div><i class="fas fa-lock text-success me-1 fs-6"></i> <strong>256-Bit SSL</strong> Encrypted</div>
                                <div class="vr d-none d-md-block opacity-25"></div>
                                <div><i class="fas fa-shield-check text-primary me-1 fs-6"></i> <strong>Razorpay</strong> Certified Gateway</div>
                                <div class="vr d-none d-md-block opacity-25"></div>
                                <div><i class="fas fa-rotate-left text-info me-1 fs-6"></i> <strong>₹2,000 Deposit</strong> 100% Refundable</div>
                            </div>

                            <div class="text-center mt-3">
                                <button type="button" class="btn btn-link btn-sm text-decoration-none text-muted" onclick="goToStep(1)">
                                    <i class="fas fa-arrow-left me-1"></i> Edit Delivery Address
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

<!-- Leaflet & Razorpay Standard Checkout JS SDK -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
    let checkoutMap, checkoutMarker;
    const DEFAULT_LAT = 23.0225; // Ahmedabad
    const DEFAULT_LNG = 72.5714;
    let currentStep = 1;

    function initCheckoutMap() {
        if (checkoutMap) return;
        const container = document.getElementById('checkoutPickupMap');
        if (!container || typeof L === 'undefined') return;

        checkoutMap = L.map('checkoutPickupMap', {
            zoomControl: true,
            attributionControl: false
        }).setView([DEFAULT_LAT, DEFAULT_LNG], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19
        }).addTo(checkoutMap);

        const customPin = L.divIcon({
            className: 'custom-leaflet-pin',
            html: '<div style="background: linear-gradient(135deg, #ff7a00, #ea580c); width: 34px; height: 34px; border-radius: 50% 50% 50% 0; transform: rotate(-45deg); border: 3px solid #ffffff; box-shadow: 0 4px 15px rgba(234, 88, 12, 0.5); display: flex; align-items: center; justify-content: center;"><i class="fas fa-car" style="transform: rotate(45deg); font-size: 14px; color: #ffffff;"></i></div>',
            iconSize: [34, 34],
            iconAnchor: [17, 34],
            popupAnchor: [0, -34]
        });

        checkoutMarker = L.marker([DEFAULT_LAT, DEFAULT_LNG], {
            draggable: true,
            icon: customPin
        }).addTo(checkoutMap);

        checkoutMarker.bindPopup('<b>📍 Delivery Spot</b><br><small>Drag to adjust exact address</small>').openPopup();

        checkoutMap.on('click', function(e) {
            checkoutMarker.setLatLng(e.latlng);
            checkoutMap.panTo(e.latlng);
            reverseGeocodeCheckout(e.latlng.lat, e.latlng.lng);
        });

        checkoutMarker.on('dragend', function() {
            const pos = checkoutMarker.getLatLng();
            reverseGeocodeCheckout(pos.lat, pos.lng);
        });

        // If pre-filled from previous page
        const existingLocation = @json($request->pickup_location ?? '');
        if (existingLocation && existingLocation !== 'Ahmedabad') {
            document.getElementById('addr_flat').value = existingLocation;
        } else {
            reverseGeocodeCheckout(DEFAULT_LAT, DEFAULT_LNG);
        }

        setupCheckoutAddressSearch();
        setTimeout(() => { checkoutMap.invalidateSize(); }, 400);
    }

    let geocodeAbort;
    function reverseGeocodeCheckout(lat, lng) {
        if (geocodeAbort) geocodeAbort.abort();
        geocodeAbort = new AbortController();

        fetch(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${lat}&lon=${lng}&addressdetails=1`, {
            signal: geocodeAbort.signal,
            headers: { 'Accept-Language': 'en' }
        })
        .then(res => res.json())
        .then(data => {
            if (data && data.address) {
                const addr = data.address;
                const flat = addr.house_number || addr.building || addr.office || addr.residential || '';
                const landmark = addr.road || addr.suburb || addr.neighbourhood || addr.commercial || '';
                const city = addr.city || addr.town || addr.village || 'Ahmedabad';
                const pincode = addr.postcode || '';

                const flatInput = document.getElementById('addr_flat');
                const landmarkInput = document.getElementById('addr_landmark');
                const cityInput = document.getElementById('addr_city');
                const pincodeInput = document.getElementById('addr_pincode');

                if (flatInput && !flatInput.value) flatInput.value = flat || data.display_name.split(',')[0];
                if (landmarkInput) landmarkInput.value = landmark;
                if (cityInput) cityInput.value = city;
                if (pincodeInput && pincode) pincodeInput.value = pincode;
            }
        })
        .catch(err => {
            if (err.name !== 'AbortError') console.warn(err);
        });
    }

    function applyLocationPreset(lat, lng, flat, landmark, city, pincode, btn) {
        document.querySelectorAll('.preset-pill').forEach(b => b.classList.remove('active'));
        if (btn) btn.classList.add('active');

        document.getElementById('addr_flat').value = flat;
        document.getElementById('addr_landmark').value = landmark;
        document.getElementById('addr_city').value = city;
        document.getElementById('addr_pincode').value = pincode;

        if (checkoutMap && checkoutMarker) {
            checkoutMap.setView([lat, lng], 16);
            checkoutMarker.setLatLng([lat, lng]);
            checkoutMarker.bindPopup(`<b>📍 ${flat.split(',')[0]}</b>`).openPopup();
        }
    }

    let searchTimer;
    function setupCheckoutAddressSearch() {
        const input = document.getElementById('checkout_places_search');
        const dropdown = document.getElementById('checkoutSearchResultsDropdown');
        const clearBtn = document.getElementById('checkoutClearSearchBtn');
        if (!input || !dropdown) return;

        input.addEventListener('input', function() {
            const q = this.value.trim();
            if (clearBtn) clearBtn.style.display = q ? 'block' : 'none';

            if (q.length < 3) {
                dropdown.classList.add('d-none');
                return;
            }

            clearTimeout(searchTimer);
            searchTimer = setTimeout(() => {
                dropdown.innerHTML = '<div class="list-group-item small text-muted"><i class="fas fa-spinner fa-spin me-2 text-primary"></i>Searching locations in Ahmedabad...</div>';
                dropdown.classList.remove('d-none');

                fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(q + ', Gujarat, India')}&addressdetails=1&limit=5`, {
                    headers: { 'Accept-Language': 'en' }
                })
                .then(res => res.json())
                .then(results => {
                    dropdown.innerHTML = '';
                    if (!results || results.length === 0) {
                        dropdown.innerHTML = '<div class="list-group-item small text-muted">No matching places found.</div>';
                        return;
                    }
                    results.forEach(res => {
                        const item = document.createElement('button');
                        item.type = 'button';
                        item.className = 'list-group-item list-group-item-action small py-2 d-flex align-items-center gap-2 text-start search-suggestion-item';
                        item.innerHTML = `<i class="fas fa-location-dot text-primary flex-shrink-0"></i> <div><strong class="d-block text-dark">${res.display_name.split(',')[0]}</strong><span class="text-muted fs-7">${res.display_name}</span></div>`;
                        item.onclick = function() {
                            const lat = parseFloat(res.lat);
                            const lon = parseFloat(res.lon);
                            if (checkoutMap && checkoutMarker) {
                                checkoutMap.setView([lat, lon], 16);
                                checkoutMarker.setLatLng([lat, lon]);
                                checkoutMarker.bindPopup(`<b>📍 ${res.display_name.split(',')[0]}</b>`).openPopup();
                                reverseGeocodeCheckout(lat, lon);
                            }
                            input.value = res.display_name.split(',')[0];
                            dropdown.classList.add('d-none');
                        };
                        dropdown.appendChild(item);
                    });
                })
                .catch(() => {
                    dropdown.innerHTML = '<div class="list-group-item small text-muted">Search error. Please use map pin.</div>';
                });
            }, 300);
        });

        document.addEventListener('click', function(e) {
            if (!input.contains(e.target) && !dropdown.contains(e.target)) {
                dropdown.classList.add('d-none');
            }
        });
    }

    function clearCheckoutLocationSearch() {
        const input = document.getElementById('checkout_places_search');
        const clearBtn = document.getElementById('checkoutClearSearchBtn');
        const dropdown = document.getElementById('checkoutSearchResultsDropdown');
        if (input) input.value = '';
        if (clearBtn) clearBtn.style.display = 'none';
        if (dropdown) dropdown.classList.add('d-none');
    }

    function detectCheckoutGPS(e) {
        if (!navigator.geolocation) {
            alert('Geolocation not supported by your browser.');
            return;
        }

        const btn = e ? e.currentTarget : null;
        if (btn) btn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Locating...';

        navigator.geolocation.getCurrentPosition(
            pos => {
                const lat = pos.coords.latitude;
                const lng = pos.coords.longitude;
                if (checkoutMap && checkoutMarker) {
                    checkoutMap.setView([lat, lng], 16);
                    checkoutMarker.setLatLng([lat, lng]);
                    checkoutMarker.bindPopup('<b>🎯 Your Current Location</b>').openPopup();
                    reverseGeocodeCheckout(lat, lng);
                }
                if (btn) {
                    btn.innerHTML = '<i class="fas fa-check text-success me-1"></i> Located';
                    setTimeout(() => { btn.innerHTML = '📍 My Current Location'; }, 3000);
                }
            },
            () => {
                alert('Could not determine your GPS location. Please drag map pin.');
                if (btn) btn.innerHTML = '📍 My Current Location';
            }
        );
    }

    /* 2-Step Stepper Controller */
    function validateAndGoToStep(targetStep) {
        if (targetStep === 2) {
            const flat = document.getElementById('addr_flat').value.trim();
            const landmark = document.getElementById('addr_landmark').value.trim();
            const city = document.getElementById('addr_city').value.trim();
            const pincode = document.getElementById('addr_pincode').value.trim();

            let hasError = false;
            if (!flat) {
                document.getElementById('addr_flat').classList.add('is-invalid');
                hasError = true;
            } else {
                document.getElementById('addr_flat').classList.remove('is-invalid');
            }

            if (!landmark) {
                document.getElementById('addr_landmark').classList.add('is-invalid');
                hasError = true;
            } else {
                document.getElementById('addr_landmark').classList.remove('is-invalid');
            }

            if (!pincode || pincode.length !== 6) {
                document.getElementById('addr_pincode').classList.add('is-invalid');
                hasError = true;
            } else {
                document.getElementById('addr_pincode').classList.remove('is-invalid');
            }

            if (hasError) {
                window.scrollTo({ top: 200, behavior: 'smooth' });
                return;
            }

            const formattedAddress = `${flat}, ${landmark}, ${city} - ${pincode}`;
            document.getElementById('final_pickup_location_input').value = formattedAddress;
            document.getElementById('confirmed_delivery_title').innerText = flat;
            document.getElementById('confirmed_delivery_full').innerText = `${landmark}, ${city} - ${pincode}`;

            goToStep(2);
        } else {
            goToStep(targetStep);
        }
    }

    function goToStep(step) {
        currentStep = step;
        const step1 = document.getElementById('step1Container');
        const step2 = document.getElementById('step2Container');

        const circle1 = document.getElementById('stepperCircle1');
        const badge1 = document.getElementById('stepperBadge1');
        const icon1 = document.getElementById('stepperIcon1');
        const tab1 = document.getElementById('stepperTab1');

        const circle2 = document.getElementById('stepperCircle2');
        const badge2 = document.getElementById('stepperBadge2');
        const tab2 = document.getElementById('stepperTab2');

        if (step === 1) {
            step1.style.display = 'block';
            step2.style.display = 'none';

            circle1.className = 'rounded-circle bg-primary text-white d-flex align-items-center justify-content-center shadow-sm flex-shrink-0 stepper-circle';
            badge1.className = 'badge bg-primary text-white fw-bold rounded-pill mb-1';
            badge1.innerText = 'STEP 1 • ACTIVE';
            icon1.className = 'fas fa-map-marker-alt';
            tab1.classList.remove('opacity-60');

            circle2.className = 'rounded-circle bg-light border text-muted d-flex align-items-center justify-content-center flex-shrink-0 stepper-circle';
            badge2.className = 'badge bg-light text-muted fw-bold rounded-pill mb-1';
            badge2.innerText = 'STEP 2';
            tab2.classList.add('opacity-60');

            if (checkoutMap) setTimeout(() => { checkoutMap.invalidateSize(); }, 200);
        } else if (step === 2) {
            step1.style.display = 'none';
            step2.style.display = 'block';

            circle1.className = 'rounded-circle bg-success text-white d-flex align-items-center justify-content-center shadow-sm flex-shrink-0 stepper-circle';
            badge1.className = 'badge bg-success bg-opacity-10 text-success fw-bold rounded-pill mb-1';
            badge1.innerText = 'STEP 1 • COMPLETED';
            icon1.className = 'fas fa-check';
            tab1.classList.add('opacity-60');

            circle2.className = 'rounded-circle bg-primary text-white d-flex align-items-center justify-content-center shadow-sm flex-shrink-0 stepper-circle';
            badge2.className = 'badge bg-primary text-white fw-bold rounded-pill mb-1';
            badge2.innerText = 'STEP 2 • ACTIVE';
            tab2.classList.remove('opacity-60');
        }

        window.scrollTo({ top: 120, behavior: 'smooth' });
    }

    /* Razorpay Payment Handler */
    function startRazorpayPayment() {
        const payBtn = document.getElementById('payBtn');
        payBtn.disabled = true;
        payBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Opening Razorpay...';

        const options = {
            "key": @json($razorpayKey),
            "amount": "{{ (int) round($totalAmount * 100) }}",
            "currency": "INR",
            "name": "AutoLux Car Rental",
            "description": "Rental Booking for {{ $car->brand }} {{ $car->model }} ({{ $booking->booking_number }})",
            "image": "https://cdn-icons-png.flaticon.com/512/3202/3202926.png",
            "order_id": @json($razorpayOrder['id']),
            "handler": function (response) {
                payBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Verifying Signature...';
                document.getElementById('razorpay_payment_id').value = response.razorpay_payment_id;
                document.getElementById('razorpay_order_id').value = response.razorpay_order_id;
                document.getElementById('razorpay_signature').value = response.razorpay_signature || '';
                document.getElementById('upiPaymentForm').submit();
            },
            "prefill": {
                "name": @json(auth()->user()->name),
                "email": @json(auth()->user()->email),
                "contact": @json(auth()->user()->phone ?? '')
            },
            "modal": {
                "ondismiss": function() {
                    payBtn.disabled = false;
                    payBtn.innerHTML = '<i class="fas fa-lock me-2"></i> Pay ₹{{ number_format($totalAmount, 0) }} via Razorpay';
                }
            },
            "theme": {
                "color": "#2563eb"
            }
        };

        try {
            const rzp = new Razorpay(options);
            rzp.on('payment.failed', function (response) {
                alert("Payment Failed: " + (response.error.description || "Transaction was declined."));
                payBtn.disabled = false;
                payBtn.innerHTML = '<i class="fas fa-lock me-2"></i> Pay ₹{{ number_format($totalAmount, 0) }} via Razorpay';
            });
            rzp.open();
        } catch (e) {
            console.error('Razorpay error:', e);
            alert('Razorpay Checkout failed to initialize. Please check your connection.');
            payBtn.disabled = false;
            payBtn.innerHTML = '<i class="fas fa-lock me-2"></i> Pay ₹{{ number_format($totalAmount, 0) }} via Razorpay';
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        initCheckoutMap();
    });
</script>
@endsection
