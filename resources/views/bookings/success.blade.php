@extends('layouts.app')

@section('title', 'Payment Successful — AutoLux')

@section('content')
<section class="dashboard-section pb-5">
    <div class="container">
        <div class="row justify-content-center" data-aos="zoom-in">
            <div class="col-lg-7 col-md-9">
                <div class="dashboard-card border-0 shadow-lg rounded-4 bg-white overflow-hidden text-center p-4 p-md-5">
                    
                    <!-- Success Animated Badge Icon -->
                    <div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-success bg-opacity-10 text-success mb-4 p-4" style="width: 100px; height: 100px;">
                        <i class="fas fa-check-circle display-3 text-success"></i>
                    </div>

                    <h2 class="fw-bold text-dark mb-1 font-display fs-2">Payment Successful!</h2>
                    <p class="text-muted mb-4 fs-6">Your rental reservation has been created & verified.</p>

                    <!-- Booking & Payment Details Card -->
                    <div class="bg-light rounded-4 p-4 text-start mb-4 border">
                        
                        <!-- Prominent Booking ID Box -->
                        <div class="d-flex justify-content-between align-items-center p-3 bg-white rounded-3 border mb-3 shadow-sm">
                            <div>
                                <small class="text-muted text-uppercase fw-bold d-block" style="font-size: 0.72rem; letter-spacing: 0.05em;">Booking ID</small>
                                <span class="fw-extrabold text-primary fs-3 font-display" style="letter-spacing: 0.03em;">{{ $booking->booking_number }}</span>
                            </div>
                            <span class="badge bg-success bg-opacity-25 text-success border border-success border-opacity-50 rounded-pill px-3 py-2 fw-bold fs-6">
                                <i class="fas fa-circle-check me-1"></i> {{ strtoupper($booking->status) }}
                            </span>
                        </div>

                        <div class="row g-3">
                            <div class="col-sm-6">
                                <div class="p-3 bg-white rounded-3 border">
                                    <small class="text-muted d-block mb-1 fs-7"><i class="fas fa-car me-1 text-primary"></i> Vehicle Reserved</small>
                                    <div class="fw-bold text-dark fs-6">{{ $booking->car->brand }} {{ $booking->car->model }}</div>
                                    <div class="small text-muted">{{ $booking->car->fuel_type }} | {{ $booking->car->transmission }}</div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="p-3 bg-white rounded-3 border">
                                    <small class="text-muted d-block mb-1 fs-7"><i class="fas fa-indian-rupee-sign me-1 text-success"></i> Total Amount Paid</small>
                                    <div class="fw-bold text-success fs-5">₹{{ number_format($booking->total_amount, 0) }}</div>
                                    <div class="small text-muted">Paid via {{ $booking->payment->method ?? 'Online UPI' }}</div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="p-3 bg-white rounded-3 border">
                                    <small class="text-muted d-block mb-1 fs-7"><i class="fas fa-truck-fast me-1 text-primary"></i> Estimated Delivery</small>
                                    <div class="fw-bold text-dark fs-6">{{ $booking->pickup_date->format('d M Y') }}</div>
                                    <div class="small text-muted">10:00 AM</div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="p-3 bg-white rounded-3 border">
                                    <small class="text-muted d-block mb-1 fs-7"><i class="fas fa-location-dot me-1 text-danger"></i> Delivery Address</small>
                                    <div class="fw-bold text-dark text-truncate small" title="{{ $booking->pickup_location }}">{{ $booking->pickup_location }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex flex-column flex-sm-row gap-3 justify-content-center">
                        <a href="{{ route('bookings.show', $booking->id) }}" class="btn btn-primary btn-lg rounded-pill px-4 fw-bold shadow-sm" style="background: linear-gradient(135deg, #ff7a00, #ea580c); border: none;">
                            <i class="fas fa-file-invoice me-2"></i> View Invoice
                        </a>
                        <a href="{{ route('customer.dashboard') }}" class="btn btn-outline-secondary btn-lg rounded-pill px-4 fw-semibold">
                            <i class="fas fa-tachometer-alt me-2"></i> Go to Dashboard
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>
@endsection
