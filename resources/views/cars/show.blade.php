@extends('layouts.app')

@section('title', $car->display_name . ' — DriveEase')

@section('content')
<section class="dashboard-section pb-5">
    <div class="container">
        <!-- Breadcrumb & Back -->
        <div class="mb-4" data-aos="fade-down">
            <a href="{{ route('cars.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill">
                <i class="fas fa-arrow-left me-1"></i> Back to Fleet
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
                <div class="dashboard-card mb-4">
                    <div class="card-header-custom">
                        <h5><i class="fas fa-sliders me-2 text-primary"></i> Vehicle Specifications</h5>
                    </div>
                    <div class="card-body-custom">
                        <div class="row g-3">
                            <div class="col-6 col-md-4">
                                <div class="p-3 bg-light rounded-3 text-center">
                                    <i class="fas fa-building-flag text-primary mb-1 fs-5"></i>
                                    <div class="small text-muted">Brand</div>
                                    <div class="fw-bold">{{ $car->brand }}</div>
                                </div>
                            </div>
                            <div class="col-6 col-md-4">
                                <div class="p-3 bg-light rounded-3 text-center">
                                    <i class="fas fa-car text-primary mb-1 fs-5"></i>
                                    <div class="small text-muted">Model</div>
                                    <div class="fw-bold">{{ $car->model }}</div>
                                </div>
                            </div>
                            <div class="col-6 col-md-4">
                                <div class="p-3 bg-light rounded-3 text-center">
                                    <i class="fas fa-calendar text-primary mb-1 fs-5"></i>
                                    <div class="small text-muted">Year</div>
                                    <div class="fw-bold">{{ $car->year }}</div>
                                </div>
                            </div>
                            <div class="col-6 col-md-4">
                                <div class="p-3 bg-light rounded-3 text-center">
                                    <i class="fas fa-gas-pump text-primary mb-1 fs-5"></i>
                                    <div class="small text-muted">Fuel Type</div>
                                    <div class="fw-bold">{{ $car->fuel_type }}</div>
                                </div>
                            </div>
                            <div class="col-6 col-md-4">
                                <div class="p-3 bg-light rounded-3 text-center">
                                    <i class="fas fa-gears text-primary mb-1 fs-5"></i>
                                    <div class="small text-muted">Transmission</div>
                                    <div class="fw-bold">{{ $car->transmission }}</div>
                                </div>
                            </div>
                            <div class="col-6 col-md-4">
                                <div class="p-3 bg-light rounded-3 text-center">
                                    <i class="fas fa-users text-primary mb-1 fs-5"></i>
                                    <div class="small text-muted">Seats</div>
                                    <div class="fw-bold">{{ $car->seating_capacity }} Persons</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Description & Features -->
                <div class="dashboard-card">
                    <div class="card-header-custom">
                        <h5><i class="fas fa-info-circle me-2 text-primary"></i> Description & Features</h5>
                    </div>
                    <div class="card-body-custom">
                        <p class="text-muted leading-relaxed mb-4">{{ $car->description ?? 'No description provided for this vehicle.' }}</p>

                        @if($car->features && count($car->features) > 0)
                            <h6 class="fw-bold mb-3">Key Features</h6>
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

            <!-- Right Column: Booking Card -->
            <div class="col-lg-5" data-aos="fade-left">
                <div class="dashboard-card sticky-top" style="top: 100px; z-index: 10;">
                    <div class="card-header-custom bg-primary text-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 text-white"><i class="fas fa-calendar-check me-2"></i> Book This Vehicle</h5>
                        <span class="fs-4 fw-bold">₹{{ number_format($car->rental_price_per_day, 0) }} <small class="fs-6 fw-normal">/day</small></span>
                    </div>
                    <div class="card-body-custom">
                        @if($car->status === 'Available')
                            <form action="{{ route('customer.bookings.create', $car->id) }}" method="GET">
                                <div class="mb-3">
                                    <label class="form-label small fw-bold">Pickup Location (Ahmedabad)</label>
                                    <select name="pickup_location" class="form-select">
                                        <option value="SG Highway Hub (Iskcon)">SG Highway Hub (Iskcon)</option>
                                        <option value="Sardar Vallabhbhai Patel Airport (AMD)">Airport Pickup (AMD)</option>
                                        <option value="Ahmedabad Junction Railway Station">Kalupur Railway Station</option>
                                        <option value="CG Road Hub (Navrangpura)">CG Road Hub (Navrangpura)</option>
                                        <option value="Doorstep Delivery (Home)">Doorstep Delivery (Home)</option>
                                    </select>
                                </div>

                                <div class="row g-2 mb-3">
                                    <div class="col-6">
                                        <label class="form-label small fw-bold">Pickup Date</label>
                                        <input type="date" name="pickup_date" class="form-control" min="{{ date('Y-m-d') }}" required id="pickup_date" onchange="calculateTotal()">
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label small fw-bold">Return Date</label>
                                        <input type="date" name="return_date" class="form-control" min="{{ date('Y-m-d', strtotime('+1 day')) }}" required id="return_date" onchange="calculateTotal()">
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

                                @auth
                                    <button type="submit" class="btn btn-primary btn-lg w-100 rounded-pill fw-bold">
                                        Proceed to Booking <i class="fas fa-arrow-right ms-2"></i>
                                    </button>
                                @else
                                    <a href="{{ route('login') }}" class="btn btn-primary btn-lg w-100 rounded-pill fw-bold">
                                        Sign In to Book <i class="fas fa-lock ms-2"></i>
                                    </a>
                                @endauth
                            </form>
                        @else
                            <div class="text-center py-4">
                                <span class="badge-status {{ strtolower($car->status) }} fs-6 mb-3 d-inline-block">{{ $car->status }}</span>
                                <p class="text-muted">This vehicle is currently not available for instant online booking.</p>
                                <a href="{{ route('cars.index') }}" class="btn btn-outline-primary rounded-pill btn-sm">Explore Other Cars</a>
                            </div>
                        @endif
                    </div>
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
