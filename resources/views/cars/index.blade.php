@extends('layouts.customer')

@section('title', 'Browse Cars — AutoLux')
@section('page_title', 'Browse Cars')

@section('content')
<style>
    /* Premium Liquid Glass System */
    .liquid-cars-hero {
        background: linear-gradient(135deg, #061120 0%, #0a1f3c 45%, #11325d 75%, #18437f 100%);
        border: 1px solid rgba(255, 255, 255, 0.18);
        box-shadow: 0 20px 45px -10px rgba(6, 17, 32, 0.35);
        position: relative;
        overflow: hidden;
    }
    .liquid-cars-hero::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0; height: 1px;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.8), transparent);
    }
    .hero-glow-1 {
        position: absolute; width: 320px; height: 320px;
        background: radial-gradient(circle, rgba(37, 99, 235, 0.4) 0%, rgba(37, 99, 235, 0) 70%);
        top: -80px; right: -50px; border-radius: 50%;
        animation: liquidMorph 12s ease-in-out infinite alternate;
    }
    .hero-glow-2 {
        position: absolute; width: 260px; height: 260px;
        background: radial-gradient(circle, rgba(255, 122, 0, 0.3) 0%, rgba(255, 122, 0, 0) 70%);
        bottom: -60px; left: 8%; border-radius: 50%;
        animation: liquidMorph 16s ease-in-out infinite alternate-reverse;
    }
    @keyframes liquidMorph {
        0% { transform: scale(1) translate(0, 0); }
        50% { transform: scale(1.18) translate(18px, -18px); }
        100% { transform: scale(0.92) translate(-12px, 12px); }
    }
    .liquid-search-card {
        background: rgba(255, 255, 255, 0.94);
        backdrop-filter: blur(24px) saturate(190%);
        -webkit-backdrop-filter: blur(24px) saturate(190%);
        border: 1px solid rgba(255, 255, 255, 0.9);
        box-shadow: 0 15px 35px rgba(15, 23, 42, 0.07);
    }
    .liquid-car-card {
        background: #ffffff;
        border: 1px solid rgba(226, 232, 240, 0.85);
        transition: all 0.38s cubic-bezier(0.16, 1, 0.3, 1);
        position: relative;
    }
    .liquid-car-card::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0; height: 2px;
        background: linear-gradient(90deg, transparent, rgba(37, 99, 235, 0.6), transparent);
        opacity: 0;
        transition: opacity 0.35s ease;
    }
    .liquid-car-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 22px 40px -12px rgba(15, 23, 42, 0.14);
        border-color: rgba(37, 99, 235, 0.35);
    }
    .liquid-car-card:hover::before {
        opacity: 1;
    }
    .liquid-car-card:hover .car-img-zoom {
        transform: scale(1.09);
    }
    .car-img-zoom {
        transition: transform 0.55s ease;
    }
    .liquid-badge {
        background: rgba(255, 255, 255, 0.16);
        backdrop-filter: blur(14px);
        -webkit-backdrop-filter: blur(14px);
        border: 1px solid rgba(255, 255, 255, 0.3);
        color: #ffffff;
    }
    .glass-badge-dark {
        background: rgba(15, 23, 42, 0.65);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        color: #ffffff;
        border: 1px solid rgba(255, 255, 255, 0.25);
    }
    .glass-badge-light {
        background: rgba(255, 255, 255, 0.85);
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
        color: #0f172a;
        border: 1px solid rgba(255, 255, 255, 0.9);
    }
    .btn-liquid-primary {
        background: linear-gradient(135deg, #ff7a00, #ea580c);
        border: none;
        box-shadow: 0 4px 14px rgba(234, 88, 12, 0.35);
        color: #ffffff;
        transition: all 0.3s ease;
    }
    .btn-liquid-primary:hover {
        box-shadow: 0 8px 24px rgba(234, 88, 12, 0.55);
        transform: translateY(-2px);
        color: #ffffff;
    }
    .btn-liquid-chip {
        transition: all 0.25s ease;
    }
    .btn-liquid-chip.active, .btn-liquid-chip:hover {
        background: linear-gradient(135deg, #2563eb, #1d4ed8) !important;
        color: #ffffff !important;
        box-shadow: 0 4px 14px rgba(37, 99, 235, 0.35);
        border-color: transparent !important;
    }
    /* Skeleton Shimmer Loading Animation */
    @keyframes skeletonShimmer {
        0% { background-position: -200% 0; }
        100% { background-position: 200% 0; }
    }
    .skeleton-box {
        background: linear-gradient(90deg, #f1f5f9 25%, #e2e8f0 50%, #f1f5f9 75%);
        background-size: 200% 100%;
        animation: skeletonShimmer 1.5s infinite ease-in-out;
        border-radius: 10px;
    }
</style>

<section class="dashboard-section pb-5">
    <div class="container-fluid px-0">
        
        <!-- Liquid Glass Slim Header Banner -->
        <div class="mb-4" data-aos="fade-down">
            <div class="py-3 px-4 rounded-4 text-white liquid-cars-hero shadow-sm">
                <div class="hero-glow-1"></div>
                <div class="hero-glow-2"></div>

                <div class="row align-items-center position-relative g-2" style="z-index: 2;">
                    <div class="col-md-8 col-lg-9">
                        <div class="d-flex align-items-center gap-2 flex-wrap mb-1">
                            <h4 class="fw-bold text-white font-display mb-0">Find Your Ideal Self-Drive Car</h4>
                            <span class="badge liquid-badge rounded-pill px-3 py-1 fs-7 fw-semibold">
                                <i class="fas fa-sparkles text-warning me-1"></i> Gujarat Verified Fleet
                            </span>
                        </div>
                        <p class="text-white-50 mb-0 small">
                            Explore Ahmedabad's finest self-drive vehicles. Filter by brand, fuel, transmission, or price.
                        </p>
                    </div>
                    <div class="col-md-4 col-lg-3 text-md-end mt-2 mt-md-0">
                        <div class="d-inline-flex align-items-center gap-2 liquid-badge px-3 py-2 rounded-pill shadow-xs">
                            <i class="fas fa-circle-check text-success fs-5"></i>
                            <div class="text-start">
                                <div class="fw-bold fs-6 text-white leading-none">{{ $cars->total() }} Vehicles Available</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Unified Liquid Glass Search & Filter Control Bar -->
        <div class="liquid-search-card mb-4 rounded-4 p-3 p-md-4" data-aos="fade-up">
            <form action="{{ route('cars.index') }}" method="GET" id="mainFilterForm">
                
                <!-- Main Search Inputs Row -->
                <div class="row g-2 align-items-center">
                    <!-- Keyword Search -->
                    <div class="col-lg-3 col-md-6">
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0 text-muted rounded-start-3"><i class="fas fa-search"></i></span>
                            <input type="text" name="keyword" class="form-control rounded-end-3 py-2 border-start-0" placeholder="Search model, brand..." value="{{ request('keyword') }}">
                        </div>
                    </div>

                    <!-- Brand Select -->
                    <div class="col-lg-2 col-md-4">
                        <select name="brand" class="form-select rounded-3 py-2 fw-medium border">
                            <option value="">All Brands</option>
                            @foreach($brands as $brand)
                                <option value="{{ $brand }}" {{ request('brand') == $brand ? 'selected' : '' }}>{{ $brand }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Pickup Date -->
                    <div class="col-lg-2 col-md-4">
                        <input type="date" name="pickup_date" class="form-control rounded-3 py-2 fw-medium border" min="{{ date('Y-m-d') }}" value="{{ request('pickup_date') }}" title="Pickup Date">
                    </div>

                    <!-- Return Date -->
                    <div class="col-lg-2 col-md-4">
                        <input type="date" name="return_date" class="form-control rounded-3 py-2 fw-medium border" min="{{ date('Y-m-d', strtotime('+1 day')) }}" value="{{ request('return_date') }}" title="Return Date">
                    </div>

                    <!-- Action Buttons -->
                    <div class="col-lg-3 col-md-12 d-flex gap-2">
                        <button type="submit" class="btn btn-liquid-primary flex-grow-1 rounded-3 py-2 fw-bold shadow-sm">
                            <i class="fas fa-search me-1"></i> Search
                        </button>
                        <button type="button" class="btn btn-outline-primary rounded-3 px-3 py-2 fw-semibold" data-bs-toggle="collapse" data-bs-target="#advancedFilterCollapse" aria-expanded="false" aria-controls="advancedFilterCollapse">
                            <i class="fas fa-sliders me-1"></i> Filters
                        </button>
                        <button type="button" class="btn btn-outline-warning text-dark rounded-3 px-3 py-2 fw-semibold" data-bs-toggle="modal" data-bs-target="#saveSearchModal" title="Save Search Alert">
                            <i class="fas fa-bell"></i>
                        </button>
                        @if(request()->hasAny(['keyword', 'brand', 'fuel_type', 'transmission', 'max_price', 'pickup_date', 'return_date']))
                            <a href="{{ route('cars.index') }}" class="btn btn-light rounded-3 px-3 py-2 text-danger border" title="Reset Filters">
                                <i class="fas fa-rotate-left"></i>
                            </a>
                        @endif
                    </div>
                </div>

                <!-- Expandable Advanced Filters Drawer -->
                <div class="collapse {{ request()->hasAny(['transmission', 'max_price']) ? 'show' : '' }} mt-3 pt-3 border-top" id="advancedFilterCollapse">
                    @if(request('fuel_type'))
                        <input type="hidden" name="fuel_type" value="{{ request('fuel_type') }}">
                    @endif
                    <div class="row g-3 align-items-center">
                        <!-- Transmission -->
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted mb-1"><i class="fas fa-cogs text-primary me-1"></i> Transmission</label>
                            <select name="transmission" class="form-select rounded-3 py-2">
                                <option value="">All Transmissions</option>
                                @foreach($transmissions as $trans)
                                    <option value="{{ $trans }}" {{ request('transmission') == $trans ? 'selected' : '' }}>{{ $trans }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Max Daily Price Range Slider -->
                        <div class="col-md-6">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <label class="form-label small fw-bold text-muted mb-0"><i class="fas fa-tag text-primary me-1"></i> Max Daily Budget</label>
                                <span class="fw-bold text-primary small" id="priceSliderValUnified">₹{{ number_format(request('max_price', 15000), 0) }} / day</span>
                            </div>
                            <input type="range" name="max_price" class="form-range" min="1000" max="15000" step="500" value="{{ request('max_price', 15000) }}" oninput="document.getElementById('priceSliderValUnified').textContent = '₹' + parseInt(this.value).toLocaleString('en-IN') + ' / day'">
                        </div>
                    </div>
                </div>

            </form>
        </div>

        <!-- Vehicle Directory Grid Area -->
        <div class="row g-4">
            <div class="col-12" data-aos="fade-up">
                
                <!-- Quick Filter Chips (1-Tap Fast Selection) -->
                <div class="d-flex align-items-center gap-2 mb-3 overflow-x-auto pb-1 scrollbar-none">
                    <a href="{{ route('cars.index', request()->except(['fuel_type', 'transmission', 'page'])) }}" 
                       class="btn btn-sm rounded-pill px-3 py-2 fw-semibold text-nowrap {{ !request('fuel_type') && !request('transmission') ? 'btn-primary shadow-xs' : 'btn-white border text-dark' }}">
                        <i class="fas fa-layer-group me-1"></i> All Fleet
                    </a>
                    <a href="{{ route('cars.index', array_merge(request()->except(['fuel_type', 'page']), ['fuel_type' => 'Petrol'])) }}" 
                       class="btn btn-sm rounded-pill px-3 py-2 fw-semibold text-nowrap {{ request('fuel_type') == 'Petrol' ? 'btn-primary shadow-xs' : 'btn-white border text-dark' }}">
                        ⛽ Petrol Fleet
                    </a>
                    <a href="{{ route('cars.index', array_merge(request()->except(['fuel_type', 'page']), ['fuel_type' => 'Diesel'])) }}" 
                       class="btn btn-sm rounded-pill px-3 py-2 fw-semibold text-nowrap {{ request('fuel_type') == 'Diesel' ? 'btn-primary shadow-xs' : 'btn-white border text-dark' }}">
                        🛢️ Diesel Power
                    </a>
                    <a href="{{ route('cars.index', array_merge(request()->except(['fuel_type', 'page']), ['fuel_type' => 'Electric'])) }}" 
                       class="btn btn-sm rounded-pill px-3 py-2 fw-semibold text-nowrap {{ request('fuel_type') == 'Electric' ? 'btn-primary shadow-xs' : 'btn-white border text-dark' }}">
                        ⚡ EV / Electric
                    </a>
                    <a href="{{ route('cars.index', array_merge(request()->except(['transmission', 'page']), ['transmission' => 'Automatic'])) }}" 
                       class="btn btn-sm rounded-pill px-3 py-2 fw-semibold text-nowrap {{ request('transmission') == 'Automatic' ? 'btn-primary shadow-xs' : 'btn-white border text-dark' }}">
                        ⚙️ Automatic Drive
                    </a>
                </div>

                <!-- Results Bar Header -->
                <div class="d-flex align-items-center justify-content-between mb-3 bg-white p-3 rounded-4 shadow-sm border">
                    <span class="small text-muted fw-semibold">
                        Showing <strong class="text-dark">{{ $cars->firstItem() ?? 0 }} - {{ $cars->lastItem() ?? 0 }}</strong> of <strong class="text-dark">{{ $cars->total() }}</strong> vehicles
                    </span>
                    <div class="d-flex align-items-center gap-2">
                        <small class="text-muted fw-semibold">Sort:</small>
                        <form action="{{ route('cars.index') }}" method="GET" id="topSortForm">
                            @foreach(request()->except('sort') as $key => $val)
                                <input type="hidden" name="{{ $key }}" value="{{ $val }}">
                            @endforeach
                            <select name="sort" class="form-select form-select-sm border-0 bg-light rounded-pill px-3" onchange="document.getElementById('topSortForm').submit()">
                                <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Featured / Latest</option>
                                <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                                <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                            </select>
                        </form>
                    </div>
                </div>

                <!-- Skeleton Loading Placeholder Grid (Shown on Filter Trigger) -->
                <div class="row g-4 mb-4 d-none" id="skeletonGrid">
                    @for($i = 0; $i < 6; $i++)
                        <div class="col-md-6 col-lg-4">
                            <div class="bg-white rounded-4 overflow-hidden shadow-xs border p-3">
                                <div class="skeleton-box mb-3" style="height: 185px;"></div>
                                <div class="skeleton-box mb-2" style="height: 14px; width: 35%;"></div>
                                <div class="skeleton-box mb-3" style="height: 22px; width: 75%;"></div>
                                <div class="d-flex gap-3 mb-3">
                                    <div class="skeleton-box" style="height: 16px; width: 40%;"></div>
                                    <div class="skeleton-box" style="height: 16px; width: 40%;"></div>
                                </div>
                                <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                                    <div class="skeleton-box" style="height: 26px; width: 35%;"></div>
                                    <div class="skeleton-box rounded-pill" style="height: 36px; width: 45%;"></div>
                                </div>
                            </div>
                        </div>
                    @endfor
                </div>

                <!-- Cars Cards Grid (Liquid Glass Cards) -->
                <div class="row g-4 mb-4" id="carsGridContainer">
                    @forelse($cars as $car)
                        <div class="col-md-6 col-lg-4">
                            <div class="liquid-car-card rounded-4 overflow-hidden h-100 d-flex flex-column shadow-xs">
                                
                                <!-- Vehicle Image Thumbnail with Hover Zoom (Clickable) -->
                                <a href="{{ route('cars.show', $car->id) }}" class="d-block position-relative bg-light overflow-hidden text-decoration-none" style="height: 195px;">
                                    @if($car->thumbnail)
                                        <img src="{{ asset('storage/' . $car->thumbnail) }}" alt="{{ $car->display_name }}" class="w-100 h-100 object-fit-cover car-img-zoom">
                                    @else
                                        <div class="d-flex align-items-center justify-content-center h-100 text-primary opacity-50">
                                            <i class="fas fa-car display-4"></i>
                                        </div>
                                    @endif

                                    <!-- Status Badge -->
                                    <span class="car-badge position-absolute top-0 start-0 m-3 {{ strtolower($car->status) }}">
                                        @if($car->status === 'Available')
                                            <span class="pulse-dot me-1"></span>
                                        @endif
                                        {{ $car->status }}
                                    </span>
                                    
                                    <!-- Fuel Type Badge -->
                                    <span class="glass-badge-dark position-absolute top-0 end-0 m-3 rounded-pill px-3 py-1 small font-weight-bold">
                                        <i class="fas fa-gas-pump me-1 text-warning"></i> {{ $car->fuel_type }}
                                    </span>

                                    <!-- Bottom Verified Tag -->
                                    <span class="glass-badge-light position-absolute bottom-0 start-0 m-3 rounded-pill px-2.5 py-0.5 fs-7 fw-semibold">
                                        <i class="fas fa-shield-check text-success me-1"></i> Verified
                                    </span>
                                </a>

                                <!-- Body Info -->
                                <div class="p-3 d-flex flex-column flex-grow-1">
                                    <div class="d-flex align-items-center justify-content-between mb-1">
                                        <span class="text-uppercase text-primary small fw-bold tracking-wider">{{ $car->brand }}</span>
                                        <span class="small text-muted fw-semibold fs-7"><i class="fas fa-calendar me-1"></i>{{ $car->year }}</span>
                                    </div>
                                    <h5 class="fw-bold mb-2 fs-6">
                                        <a href="{{ route('cars.show', $car->id) }}" class="text-dark text-decoration-none transition-all hover-primary">
                                            {{ $car->model }}
                                        </a>
                                    </h5>

                                    <!-- Specs Pills -->
                                    <div class="d-flex align-items-center gap-2 mb-3 flex-wrap fs-7">
                                        <span class="px-2.5 py-1 rounded-pill bg-light border text-dark fw-medium">
                                            <i class="fas fa-cogs text-primary me-1"></i> {{ $car->transmission }}
                                        </span>
                                        <span class="px-2.5 py-1 rounded-pill bg-light border text-dark fw-medium">
                                            <i class="fas fa-users text-primary me-1"></i> {{ $car->seating_capacity }} Seats
                                        </span>
                                    </div>

                                    <!-- Footer & CTA -->
                                    <div class="mt-auto pt-3 border-top d-flex align-items-center justify-content-between">
                                        <div>
                                            <div class="fw-bold text-dark fs-5">₹{{ number_format($car->rental_price_per_day, 0) }}</div>
                                            <small class="text-muted fs-7">per day</small>
                                        </div>
                                        <a href="{{ route('cars.show', $car->id) }}" class="btn btn-liquid-primary rounded-pill px-3 py-2 fw-semibold fs-7">
                                            View & Reserve <i class="fas fa-arrow-right ms-1"></i>
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
                            <a href="{{ route('cars.index') }}" class="btn btn-liquid-primary rounded-pill px-4 py-2 fw-bold">
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

<!-- Offcanvas Mobile Filter Drawer (<= 991px) -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="carFilterDrawer" aria-labelledby="carFilterDrawerLabel">
    <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title fw-bold text-dark" id="carFilterDrawerLabel">
            <i class="fas fa-sliders text-primary me-2"></i> Filter Vehicles
        </h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body p-4">
        <form action="{{ route('cars.index') }}" method="GET">
            @if(request('pickup_date')) <input type="hidden" name="pickup_date" value="{{ request('pickup_date') }}"> @endif
            @if(request('return_date')) <input type="hidden" name="return_date" value="{{ request('return_date') }}"> @endif

            <div class="mb-3">
                <label class="form-label small fw-bold text-muted text-uppercase">Brand</label>
                <select name="brand" class="form-select rounded-3">
                    <option value="">All Brands</option>
                    @foreach($brands as $brand)
                        <option value="{{ $brand }}" {{ request('brand') == $brand ? 'selected' : '' }}>{{ $brand }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label small fw-bold text-muted text-uppercase">Keyword Search</label>
                <input type="text" name="keyword" class="form-control rounded-3" placeholder="Model, feature..." value="{{ request('keyword') }}">
            </div>

            <div class="mb-3">
                <label class="form-label small fw-bold text-muted text-uppercase">Fuel Type</label>
                <select name="fuel_type" class="form-select rounded-3">
                    <option value="">All Fuel Types</option>
                    @foreach($fuelTypes as $fuel)
                        <option value="{{ $fuel }}" {{ request('fuel_type') == $fuel ? 'selected' : '' }}>{{ $fuel }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label small fw-bold text-muted text-uppercase">Transmission</label>
                <select name="transmission" class="form-select rounded-3">
                    <option value="">All Transmissions</option>
                    @foreach($transmissions as $trans)
                        <option value="{{ $trans }}" {{ request('transmission') == $trans ? 'selected' : '' }}>{{ $trans }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Dynamic Max Daily Price Range Slider (Mobile) -->
            <div class="mb-3">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <label class="form-label small fw-bold text-muted text-uppercase mb-0">Max Budget</label>
                    <span class="fw-bold text-primary small" id="priceSliderValMobile">₹{{ number_format(request('max_price', 15000), 0) }} / day</span>
                </div>
                <input type="range" name="max_price" class="form-range" min="1000" max="15000" step="500" value="{{ request('max_price', 15000) }}" oninput="document.getElementById('priceSliderValMobile').textContent = '₹' + parseInt(this.value).toLocaleString('en-IN') + ' / day'">
                <div class="d-flex justify-content-between text-muted fs-7 mt-1">
                    <span>₹1,000</span>
                    <span>₹15,000</span>
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label small fw-bold text-muted text-uppercase">Sort Results</label>
                <select name="sort" class="form-select rounded-3">
                    <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Newest Vehicles</option>
                    <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                    <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                </select>
            </div>

            <button type="submit" class="btn btn-liquid-primary w-100 rounded-pill py-2 fw-bold">
                <i class="fas fa-filter me-1"></i> Apply Filters
            </button>
            <a href="{{ route('cars.index') }}" class="btn btn-outline-secondary w-100 rounded-pill py-2 mt-2 fw-semibold">
                Reset
            </a>
        </form>
    </div>
</div>

<!-- Save Search Alert Modal (Liquid Glass Theme) -->
<div class="modal fade" id="saveSearchModal" tabindex="-1" aria-labelledby="saveSearchModalLabel" aria-hidden="true" style="z-index: 1060;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="modal-header p-4 text-white border-0" style="background: linear-gradient(135deg, #061120 0%, #0a1f3c 50%, #11325d 100%);">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-circle p-2 bg-white bg-opacity-10 text-warning">
                        <i class="fas fa-bell fs-4"></i>
                    </div>
                    <div>
                        <h5 class="modal-title fw-bold text-white mb-0" id="saveSearchModalLabel">
                            Save Search Alert 🔔
                        </h5>
                        <small class="text-white-50">Get notified when matching cars join the fleet</small>
                    </div>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form action="{{ route('customer.save-search') }}" method="POST">
                @csrf
                <input type="hidden" name="brand" value="{{ request('brand') }}">
                <input type="hidden" name="keyword" value="{{ request('keyword') }}">
                <input type="hidden" name="fuel_type" value="{{ request('fuel_type') }}">
                <input type="hidden" name="transmission" value="{{ request('transmission') }}">
                <input type="hidden" name="max_price" value="{{ request('max_price') }}">

                <div class="modal-body p-4">
                    <div class="p-3 bg-light rounded-3 mb-3 border">
                        <h6 class="fw-bold text-dark mb-2 fs-7 text-uppercase tracking-wider">Active Search Filter Criteria</h6>
                        <div class="row g-2 small text-muted">
                            <div class="col-6">🚗 Brand: <span class="fw-bold text-dark">{{ request('brand', 'All Brands') }}</span></div>
                            <div class="col-6">🔍 Keyword: <span class="fw-bold text-dark">{{ request('keyword', 'None') }}</span></div>
                            <div class="col-6">⛽ Fuel: <span class="fw-bold text-dark">{{ request('fuel_type', 'Any Fuel') }}</span></div>
                            <div class="col-6">💰 Max Budget: <span class="fw-bold text-dark">₹{{ number_format(request('max_price', 15000), 0) }}/day</span></div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold text-dark small">Notification Email</label>
                        <input type="email" class="form-control rounded-3 py-2" value="{{ auth()->user()->email ?? '' }}" readonly>
                    </div>

                    <div class="text-muted fs-7">
                        <i class="fas fa-envelope text-primary me-1"></i>
                        We will send you an instant email & in-app notification when a new matching vehicle becomes available!
                    </div>
                </div>

                <div class="modal-footer bg-light p-3 border-top">
                    <button type="button" class="btn btn-secondary rounded-pill px-3" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-warning rounded-pill px-4 py-2 fw-bold text-dark shadow-sm">
                        Save Search Alert <i class="fas fa-check ms-1"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function showSkeletonLoader() {
        const grid = document.getElementById('carsGridContainer');
        const skeleton = document.getElementById('skeletonGrid');
        if (grid && skeleton) {
            grid.classList.add('d-none');
            skeleton.classList.remove('d-none');
        }
    }

    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', function() {
                showSkeletonLoader();
            });
        });
    });
</script>
@endpush
@endsection
