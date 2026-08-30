@extends('layouts.app')

@section('title', 'Payment Successful — AutoLux')

@push('styles')
<style>
    .success-pulse-ring {
        animation: pulseSuccess 2s infinite cubic-bezier(0.4, 0, 0.6, 1);
    }
    @keyframes pulseSuccess {
        0%, 100% { transform: scale(1); opacity: 1; }
        50% { transform: scale(1.08); opacity: 0.85; }
    }
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
<section class="dashboard-section pb-5" style="padding-top: 110px; min-height: 88vh; background: #f8fafc;">
    <div class="container">
        <div class="row justify-content-center" data-aos="zoom-in">
            <div class="col-lg-8 col-md-10">
                <div class="card border-0 shadow-sm rounded-4 bg-white overflow-hidden text-center p-4 p-md-5">
                    
                    <!-- Success Animated Badge Icon -->
                    <div class="d-inline-flex align-items-center justify-content-center rounded-circle text-white mb-3 shadow-md success-pulse-ring" style="width: 84px; height: 84px; background: linear-gradient(135deg, #10b981, #059669);">
                        <i class="fas fa-check fs-1 text-white"></i>
                    </div>

                    <h2 class="fw-bold text-dark mb-1 font-display fs-2">Payment Successful!</h2>
                    <p class="text-muted mb-4 fs-6">Your rental reservation has been created & verified.</p>

                    <!-- Booking & Payment Details Card -->
                    <div class="bg-light bg-opacity-75 rounded-4 p-4 text-start mb-4 border">
                        
                        <!-- Prominent Booking Reference Box -->
                        <div class="d-flex justify-content-between align-items-center p-3 bg-white rounded-3 border mb-3 shadow-2xs flex-wrap gap-2">
                            <div>
                                <small class="text-muted text-uppercase fw-bold d-block" style="font-size: 0.72rem; letter-spacing: 0.05em;">Booking ID</small>
                                <span class="fw-bold text-primary fs-3 font-display" style="letter-spacing: 0.03em;">{{ $booking->booking_number }}</span>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <button type="button" class="btn btn-sm btn-light border rounded-pill px-3 py-1.5 text-muted fw-medium" onclick="navigator.clipboard.writeText('{{ $booking->booking_number }}'); this.innerText='Copied!'; setTimeout(()=>this.innerHTML='<i class=\'fas fa-copy me-1\'></i> Copy', 2000)">
                                    <i class="fas fa-copy me-1"></i> Copy
                                </button>
                                <span class="badge bg-success-subtle text-success border border-success border-opacity-25 rounded-pill px-3 py-2 fw-bold fs-6">
                                    <i class="fas fa-circle-check me-1"></i> {{ strtoupper($booking->status) }}
                                </span>
                            </div>
                        </div>

                        <!-- 4 Key Reservation Details Tiles -->
                        <div class="row g-3 mb-3">
                            <div class="col-sm-6">
                                <div class="p-3 bg-white rounded-3 border h-100">
                                    <small class="text-muted d-block mb-1 fs-7"><i class="fas fa-car me-1 text-primary"></i> Vehicle Reserved</small>
                                    <div class="fw-bold text-dark fs-6">{{ $booking->car->brand }} {{ $booking->car->model }}</div>
                                    <div class="small text-muted">{{ $booking->car->fuel_type }} · {{ $booking->car->transmission }}</div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="p-3 bg-white rounded-3 border h-100">
                                    <small class="text-muted d-block mb-1 fs-7"><i class="fas fa-indian-rupee-sign me-1 text-success"></i> Total Amount Paid</small>
                                    <div class="fw-bold text-success fs-5">₹{{ number_format($booking->total_amount, 0) }}</div>
                                    <div class="small text-muted d-flex align-items-center gap-1">
                                        <i class="fas fa-shield-check text-success"></i> Verified Online Payment
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="p-3 bg-white rounded-3 border h-100">
                                    <small class="text-muted d-block mb-1 fs-7"><i class="fas fa-calendar-check me-1 text-primary"></i> Delivery Date & Time</small>
                                    <div class="fw-bold text-dark fs-6">{{ $booking->pickup_date->format('d M Y') }}</div>
                                    <div class="small text-muted">10:00 AM (Doorstep Handover)</div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="p-3 bg-white rounded-3 border h-100">
                                    <small class="text-muted d-block mb-1 fs-7"><i class="fas fa-location-dot me-1 text-danger"></i> Delivery Address</small>
                                    <div class="fw-bold text-dark text-truncate small" title="{{ $booking->pickup_location }}">{{ $booking->pickup_location }}</div>
                                    <div class="small text-success"><i class="fas fa-truck-fast me-1"></i> Free Doorstep Delivery</div>
                                </div>
                            </div>
                        </div>

                        <!-- What Happens Next Stepper -->
                        <div class="p-3 bg-white rounded-3 border">
                            <label class="small text-muted text-uppercase fw-bold d-block mb-2.5" style="font-size: 0.72rem; letter-spacing: 0.5px;">Next Steps for Your Trip</label>
                            <div class="row g-2 text-start">
                                <div class="col-md-4">
                                    <div class="d-flex align-items-start gap-2">
                                        <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center flex-shrink-0" style="width: 22px; height: 22px; font-size: 0.7rem;"><i class="fas fa-check"></i></div>
                                        <div>
                                            <strong class="d-block small text-dark">Confirmed</strong>
                                            <span class="text-muted fs-8">Vehicle reserved for your dates</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="d-flex align-items-start gap-2">
                                        <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center flex-shrink-0" style="width: 22px; height: 22px; font-size: 0.7rem;"><i class="fas fa-spray-can-sparkles"></i></div>
                                        <div>
                                            <strong class="d-block small text-dark">Preparation</strong>
                                            <span class="text-muted fs-8">Deep cleaning & sanitization</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="d-flex align-items-start gap-2">
                                        <div class="rounded-circle bg-light border text-muted d-flex align-items-center justify-content-center flex-shrink-0" style="width: 22px; height: 22px; font-size: 0.7rem;"><i class="fas fa-key"></i></div>
                                        <div>
                                            <strong class="d-block small text-dark">Doorstep Delivery</strong>
                                            <span class="text-muted fs-8">Driver delivers car with keys</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex flex-column flex-sm-row gap-3 justify-content-center mb-3">
                        <a href="{{ route('bookings.show', $booking->id) }}" class="btn btn-liquid-primary btn-lg rounded-pill px-4 fw-bold shadow-sm">
                            <i class="fas fa-file-invoice me-2"></i> View Invoice
                        </a>
                        <a href="{{ route('customer.dashboard') }}" class="btn btn-outline-secondary btn-lg rounded-pill px-4 fw-semibold">
                            <i class="fas fa-tachometer-alt me-2"></i> Go to Dashboard
                        </a>
                    </div>

                    <div class="text-center">
                        <a href="{{ route('cars.index') }}" class="text-muted small text-decoration-none">
                            <i class="fas fa-arrow-left me-1"></i> Browse More Cars
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>
@endsection
