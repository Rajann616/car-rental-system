@extends('layouts.app')

@section('title', 'Browse Rental Vehicles — AutoLux')

@section('content')
<section class="dashboard-section pb-5">
    <div class="container">
        <!-- Header -->
        <div class="dashboard-header text-center mb-4" data-aos="fade-down">
            <span class="section-eyebrow">Gujarat Fleet</span>
            <h1 class="fw-bold mb-2">Find Your Perfect Rental Car</h1>
            <p class="text-muted mx-auto" style="max-width: 600px;">
                Browse our wide collection of hatchbacks, sedans, SUVs, and luxury vehicles available across Ahmedabad.
            </p>
        </div>

        <!-- Find Available Cars Search Bar Card -->
        <div class="search-card mb-5 border-0 shadow-lg rounded-4 p-4 bg-white" data-aos="fade-up">
            <form action="{{ route('cars.index') }}" method="GET">
                <div class="row g-3 align-items-end">
                    <div class="col-lg-3 col-md-6">
                        <label class="form-label small fw-bold text-muted text-uppercase"><i class="fas fa-car me-1 text-primary"></i> Brand / Model</label>
                        <select name="brand" class="form-select">
                            <option value="">All Brands</option>
                            @foreach($brands as $brand)
                                <option value="{{ $brand }}" {{ request('brand') == $brand ? 'selected' : '' }}>{{ $brand }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <label class="form-label small fw-bold text-muted text-uppercase"><i class="fas fa-calendar-alt me-1 text-primary"></i> Pickup Date</label>
                        <input type="date" name="pickup_date" class="form-control" min="{{ date('Y-m-d') }}" value="{{ request('pickup_date') }}">
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <label class="form-label small fw-bold text-muted text-uppercase"><i class="fas fa-calendar-check me-1 text-primary"></i> Return Date</label>
                        <input type="date" name="return_date" class="form-control" min="{{ date('Y-m-d', strtotime('+1 day')) }}" value="{{ request('return_date') }}">
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <button type="submit" class="btn btn-primary w-100 rounded-3 py-2 font-weight-bold" style="background: linear-gradient(135deg, #2563eb, #1d4ed8); border: none; height: 48px;">
                            <i class="fas fa-search me-2"></i> Find Available Cars
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <div class="row g-4">
            <!-- Sidebar Filters -->
            <div class="col-lg-3" data-aos="fade-right">
                <div class="dashboard-card sticky-top" style="top: 100px; z-index: 10;">
                    <div class="card-header-custom d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="fas fa-filter me-2 text-primary"></i> Filters</h5>
                        <a href="{{ route('cars.index') }}" class="small text-muted text-decoration-underline">Reset</a>
                    </div>
                    <div class="card-body-custom">
                        <form action="{{ route('cars.index') }}" method="GET">
                            <!-- Keyword Search -->
                            <div class="mb-3">
                                <label class="form-label small fw-bold">Search</label>
                                <input type="text" name="keyword" class="form-control form-control-sm" placeholder="Model, brand..." value="{{ request('keyword') }}">
                            </div>

                            <!-- Brand Filter -->
                            <div class="mb-3">
                                <label class="form-label small fw-bold">Brand</label>
                                <select name="brand" class="form-select form-select-sm">
                                    <option value="">All Brands</option>
                                    @foreach($brands as $brand)
                                        <option value="{{ $brand }}" {{ request('brand') == $brand ? 'selected' : '' }}>{{ $brand }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Fuel Type -->
                            <div class="mb-3">
                                <label class="form-label small fw-bold">Fuel Type</label>
                                <select name="fuel_type" class="form-select form-select-sm">
                                    <option value="">All Fuel Types</option>
                                    @foreach($fuelTypes as $fuel)
                                        <option value="{{ $fuel }}" {{ request('fuel_type') == $fuel ? 'selected' : '' }}>{{ $fuel }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Transmission -->
                            <div class="mb-3">
                                <label class="form-label small fw-bold">Transmission</label>
                                <select name="transmission" class="form-select form-select-sm">
                                    <option value="">All Transmissions</option>
                                    @foreach($transmissions as $trans)
                                        <option value="{{ $trans }}" {{ request('transmission') == $trans ? 'selected' : '' }}>{{ $trans }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Price Range -->
                            <div class="mb-3">
                                <label class="form-label small fw-bold">Max Price (₹/day)</label>
                                <input type="number" name="max_price" class="form-control form-control-sm" placeholder="e.g. 3000" value="{{ request('max_price') }}">
                            </div>

                            <!-- Sort -->
                            <div class="mb-4">
                                <label class="form-label small fw-bold">Sort By</label>
                                <select name="sort" class="form-select form-select-sm">
                                    <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Newest First</option>
                                    <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                                    <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary btn-sm w-100 rounded-pill">
                                <i class="fas fa-search me-1"></i> Apply Filters
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Vehicle Listing -->
            <div class="col-lg-9" data-aos="fade-left">
                <div class="row g-4">
                    @forelse($cars as $car)
                        <div class="col-md-6 col-lg-4">
                            <div class="car-card">
                                <div class="car-card-img">
                                    @if($car->thumbnail)
                                        <img src="{{ asset('storage/' . $car->thumbnail) }}" alt="{{ $car->display_name }}">
                                    @else
                                        <div class="car-placeholder-icon">
                                            <i class="fas fa-car"></i>
                                        </div>
                                    @endif
                                    <span class="car-badge {{ strtolower($car->status) }}">{{ $car->status }}</span>
                                    <span class="car-fuel-badge"><i class="fas fa-gas-pump me-1"></i> {{ $car->fuel_type }}</span>
                                </div>
                                <div class="car-card-body">
                                    <div class="car-card-brand">{{ $car->brand }}</div>
                                    <h3 class="car-card-title fs-5">{{ $car->model }} <small class="text-muted fs-6">({{ $car->year }})</small></h3>
                                    <div class="car-card-specs">
                                        <div class="car-spec"><i class="fas fa-cog"></i> {{ $car->transmission }}</div>
                                        <div class="car-spec"><i class="fas fa-user-friends"></i> {{ $car->seating_capacity }} Seats</div>
                                    </div>
                                    <div class="car-card-footer">
                                        <div class="car-price">₹{{ number_format($car->rental_price_per_day, 0) }} <span>/ day</span></div>
                                        <a href="{{ route('cars.show', $car->id) }}" class="btn btn-book">
                                            View Details <i class="fas fa-arrow-right ms-1"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center py-5">
                            <i class="fas fa-car-side text-muted opacity-25 fs-1 mb-3"></i>
                            <h4 class="fw-bold">No Vehicles Match Your Search</h4>
                            <p class="text-muted">Try adjusting your filter parameters to see available vehicles.</p>
                            <a href="{{ route('cars.index') }}" class="btn btn-outline-primary rounded-pill btn-sm">Clear All Filters</a>
                        </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-5">
                    {{ $cars->links() }}
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
