@extends('layouts.app')

@section('title', 'Browse Luxury Cars — AutoLux')

@section('content')
<section class="dashboard-section pb-5">
    <div class="container">
        
        <!-- Header Banner -->
        <div class="mb-4" data-aos="fade-down">
            <div class="p-3 p-md-4 rounded-4 text-white shadow-sm position-relative overflow-hidden" 
                 style="background: linear-gradient(135deg, #0a1628 0%, #153663 50%, #1a4a8a 100%); border: 1px solid rgba(255,255,255,0.1);">
                <div class="row align-items-center position-relative" style="z-index: 2;">
                    <div class="col-lg-8">
                        <span class="badge bg-warning bg-opacity-25 text-warning border border-warning border-opacity-50 rounded-pill px-3 py-1 mb-2 small fw-bold">
                            <i class="fas fa-car-side me-1"></i> Gujarat Cars Collection
                        </span>
                        <h1 class="fw-bold text-white font-display fs-2 mb-2">Find Your Ideal Rental Car</h1>
                        <p class="text-white-50 mb-0 max-w-2xl">
                            Explore Ahmedabad's finest self-drive and chauffeur vehicles. Filter by brand, fuel type, transmission, or budget.
                        </p>
                    </div>
                    <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                        <div class="d-inline-flex align-items-center gap-2 bg-white bg-opacity-10 backdrop-blur p-3 rounded-3 border border-white border-opacity-10 text-white">
                            <i class="fas fa-circle-check text-success fs-4"></i>
                            <div class="text-start">
                                <div class="fw-bold fs-5 mb-0 leading-none">{{ $cars->total() }} Vehicles</div>
                                <small class="text-white-50 fs-7">Ready for Instant Delivery</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Top Search Bar & Filter Card -->
        <div class="search-card mb-4 border-0 shadow-sm rounded-4 p-4 bg-white" data-aos="fade-up">
            <form action="{{ route('cars.index') }}" method="GET">
                <div class="row g-3 align-items-end">
                    <div class="col-lg-3 col-md-6">
                        <label class="form-label small fw-bold text-muted text-uppercase mb-1"><i class="fas fa-car me-1 text-primary"></i> Brand / Model</label>
                        <select name="brand" class="form-select border-2">
                            <option value="">All Brands</option>
                            @foreach($brands as $brand)
                                <option value="{{ $brand }}" {{ request('brand') == $brand ? 'selected' : '' }}>{{ $brand }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <label class="form-label small fw-bold text-muted text-uppercase mb-1"><i class="fas fa-calendar-alt me-1 text-primary"></i> Delivery Date</label>
                        <input type="date" name="pickup_date" class="form-control border-2" min="{{ date('Y-m-d') }}" value="{{ request('pickup_date') }}">
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <label class="form-label small fw-bold text-muted text-uppercase mb-1"><i class="fas fa-calendar-check me-1 text-primary"></i> Return Date</label>
                        <input type="date" name="return_date" class="form-control border-2" min="{{ date('Y-m-d', strtotime('+1 day')) }}" value="{{ request('return_date') }}">
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <button type="submit" class="btn btn-primary w-100 rounded-3 py-2 font-weight-bold shadow-sm" style="background: linear-gradient(135deg, #ff7a00, #ea580c); border: none; height: 48px;">
                            <i class="fas fa-search me-2"></i> Find Available Cars
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <div class="row g-4">
            
            <!-- Sidebar Filter Panel -->
            <div class="col-lg-3" data-aos="fade-right">
                <div class="dashboard-card border-0 shadow-sm rounded-4 bg-white sticky-top" style="top: 90px; z-index: 10;">
                    <div class="card-header-custom bg-white p-3 border-bottom d-flex justify-content-between align-items-center">
                        <h6 class="fw-bold mb-0 text-dark"><i class="fas fa-sliders me-2 text-primary"></i> Filter car</h6>
                        <a href="{{ route('cars.index') }}" class="small text-primary text-decoration-none fw-semibold">
                            <i class="fas fa-rotate-left me-1"></i> Reset
                        </a>
                    </div>
                    <div class="card-body-custom p-3">
                        <form action="{{ route('cars.index') }}" method="GET">
                            
                            <!-- Preserve Search Bar Date Params if present -->
                            @if(request('pickup_date')) <input type="hidden" name="pickup_date" value="{{ request('pickup_date') }}"> @endif
                            @if(request('return_date')) <input type="hidden" name="return_date" value="{{ request('return_date') }}"> @endif

                            <!-- Keyword Search -->
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-muted">Keyword Search</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="fas fa-search text-muted"></i></span>
                                    <input type="text" name="keyword" class="form-control form-control-sm border-start-0" placeholder="Model, feature..." value="{{ request('keyword') }}">
                                </div>
                            </div>

                            <!-- Fuel Type -->
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-muted">Fuel Type</label>
                                <select name="fuel_type" class="form-select form-select-sm">
                                    <option value="">All Fuel Types</option>
                                    @foreach($fuelTypes as $fuel)
                                        <option value="{{ $fuel }}" {{ request('fuel_type') == $fuel ? 'selected' : '' }}>{{ $fuel }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Transmission -->
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-muted">Transmission</label>
                                <select name="transmission" class="form-select form-select-sm">
                                    <option value="">All Transmissions</option>
                                    @foreach($transmissions as $trans)
                                        <option value="{{ $trans }}" {{ request('transmission') == $trans ? 'selected' : '' }}>{{ $trans }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Max Daily Price -->
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-muted">Max Budget (₹ / day)</label>
                                <input type="number" name="max_price" class="form-control form-control-sm" placeholder="e.g. 4000" value="{{ request('max_price') }}">
                            </div>

                            <!-- Sort By -->
                            <div class="mb-4">
                                <label class="form-label small fw-bold text-muted">Sort Results</label>
                                <select name="sort" class="form-select form-select-sm">
                                    <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Newest Vehicles</option>
                                    <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                                    <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary btn-sm w-100 rounded-pill py-2 fw-bold">
                                <i class="fas fa-filter me-1"></i> Apply Filters
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Vehicle Listing Grid -->
            <div class="col-lg-9" data-aos="fade-left">
                
                <!-- Results Bar Header -->
                <div class="d-flex align-items-center justify-content-between mb-3 bg-white p-3 rounded-3 shadow-sm border">
                    <span class="small text-muted fw-semibold">
                        Showing <strong class="text-dark">{{ $cars->firstItem() ?? 0 }} - {{ $cars->lastItem() ?? 0 }}</strong> of <strong class="text-dark">{{ $cars->total() }}</strong> vehicles
                    </span>
                    <div class="d-flex align-items-center gap-2">
                        <small class="text-muted fw-semibold">Sort:</small>
                        <form action="{{ route('cars.index') }}" method="GET" id="topSortForm">
                            @foreach(request()->except('sort') as $key => $val)
                                <input type="hidden" name="{{ $key }}" value="{{ $val }}">
                            @endforeach
                            <select name="sort" class="form-select form-select-sm border-0 bg-light" onchange="document.getElementById('topSortForm').submit()">
                                <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Featured / Latest</option>
                                <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                                <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                            </select>
                        </form>
                    </div>
                </div>

                <!-- Cars Cards Grid -->
                <div class="row g-4 mb-4">
                    @forelse($cars as $car)
                        <div class="col-md-6 col-lg-4">
                            <div class="car-card bg-white border-0 shadow-sm rounded-4 overflow-hidden h-100 d-flex flex-column transition-all hover-lift">
                                
                                <!-- Vehicle Image Thumbnail -->
                                <div class="car-card-img position-relative bg-light" style="height: 190px;">
                                    @if($car->thumbnail)
                                        <img src="{{ asset('storage/' . $car->thumbnail) }}" alt="{{ $car->display_name }}" class="w-100 h-100 object-fit-cover">
                                    @else
                                        <div class="d-flex align-items-center justify-content-center h-100 text-primary opacity-50">
                                            <i class="fas fa-car display-4"></i>
                                        </div>
                                    @endif

                                    <!-- Status Badges -->
                                    <span class="car-badge position-absolute top-0 start-0 m-3 {{ strtolower($car->status) }}">
                                        {{ $car->status }}
                                    </span>
                                    <span class="car-fuel-badge position-absolute top-0 end-0 m-3">
                                        <i class="fas fa-gas-pump me-1"></i> {{ $car->fuel_type }}
                                    </span>
                                </div>

                                <!-- Body Info -->
                                <div class="car-card-body p-3 d-flex flex-column flex-grow-1">
                                    <div class="car-card-brand text-uppercase text-primary small fw-bold mb-1">{{ $car->brand }}</div>
                                    <h5 class="car-card-title fw-bold text-dark mb-2 fs-6">
                                        {{ $car->model }} <span class="text-muted fw-normal fs-7">({{ $car->year }})</span>
                                    </h5>

                                    <!-- Specs Pills -->
                                    <div class="d-flex align-items-center gap-3 mb-3 small text-muted">
                                        <span><i class="fas fa-cog text-primary me-1"></i> {{ $car->transmission }}</span>
                                        <span><i class="fas fa-users text-primary me-1"></i> {{ $car->seating_capacity }} Seats</span>
                                    </div>

                                    <!-- Footer & CTA -->
                                    <div class="mt-auto pt-3 border-top d-flex align-items-center justify-content-between">
                                        <div>
                                            <div class="fw-bold text-dark fs-5">₹{{ number_format($car->rental_price_per_day, 0) }}</div>
                                            <small class="text-muted fs-7">per day</small>
                                        </div>
                                        <a href="{{ route('cars.show', $car->id) }}" class="btn btn-book rounded-pill px-3 py-2 fw-semibold">
                                            Details <i class="fas fa-arrow-right ms-1"></i>
                                        </a>
                                    </div>
                                </div>

                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center py-5 bg-white rounded-4 shadow-sm">
                            <i class="fas fa-car-side text-muted opacity-25 display-1 mb-3"></i>
                            <h4 class="fw-bold text-dark mb-2">No Vehicles Found</h4>
                            <p class="text-muted mx-auto mb-4" style="max-width: 400px;">
                                We couldn't find any vehicles matching your filter criteria. Try adjusting your brand or price filter.
                            </p>
                            <a href="{{ route('cars.index') }}" class="btn btn-primary rounded-pill px-4 fw-bold" style="background: linear-gradient(135deg, #ff7a00, #ea580c); border: none;">
                                Clear Filters
                            </a>
                        </div>
                    @endforelse
                </div>

                <!-- Clean Centered Bootstrap 5 Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $cars->links() }}
                </div>

            </div>
        </div>
    </div>
</section>
@endsection
