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

                                        <div class="row g-2 mb-3">
                                            <div class="col-6">
                                                <label class="form-label small fw-bold text-muted">Delivery Date</label>
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
                                                <span>Rental Charge</span>
                                                <span id="rentalCharge">₹{{ number_format($car->rental_price_per_day, 0) }} × <span id="daysCount">1</span> day</span>
                                            </div>
                                            <div class="d-flex justify-content-between small text-muted mb-1">
                                                <span>Delivery Charge</span>
                                                <span class="text-success fw-semibold">Free</span>
                                            </div>
                                            <div class="d-flex justify-content-between small text-muted mb-2">
                                                <span>Security Deposit</span>
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
                                        <label class="form-label small fw-bold text-muted">Delivery Address</label>
                                        <input type="text" name="pickup_location" class="form-control border-2" placeholder="Enter your delivery address" required>
                                    </div>

                                    <div class="row g-2 mb-3">
                                        <div class="col-6">
                                            <label class="form-label small fw-bold text-muted">Delivery Date</label>
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

    function calculateTotal() {
        const rate = {{ $car->rental_price_per_day }};
        const pDateInput = document.getElementById('pickup_date');
        const rDateInput = document.getElementById('return_date');

        if (!pDateInput || !rDateInput) return;

        const pDate = new Date(pDateInput.value);
        const rDate = new Date(rDateInput.value);

        if (pDate && rDate && rDate > pDate) {
            const diffTime = Math.abs(rDate - pDate);
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
            const total = (diffDays * rate) + 2000;

            const daysCountEl = document.getElementById('daysCount');
            const grandTotalEl = document.getElementById('grandTotal');

            if (daysCountEl) daysCountEl.innerText = diffDays;
            if (grandTotalEl) grandTotalEl.innerText = '₹' + total.toLocaleString('en-IN');
        }
    }

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
    });
</script>
@endpush
@endsection
