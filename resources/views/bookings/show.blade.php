@extends('layouts.app')

@section('title', 'Booking Invoice — ' . $booking->booking_number)

@section('content')
<section class="dashboard-section pb-5">
    <div class="container">
        <!-- Print / Action Header -->
        <div class="d-flex justify-content-between align-items-center mb-4" data-aos="fade-down">
            <a href="{{ route('customer.dashboard') }}" class="btn btn-outline-secondary btn-sm rounded-pill">
                <i class="fas fa-arrow-left me-1"></i> Dashboard
            </a>
            <button onclick="window.print()" class="btn btn-primary btn-sm rounded-pill px-3">
                <i class="fas fa-print me-1"></i> Print / Download Invoice
            </button>
        </div>

        <!-- Printable Invoice Card -->
        <div class="dashboard-card max-w-4xl mx-auto p-4 p-md-5 bg-white shadow-lg rounded-4" id="printableInvoice" data-aos="zoom-in">
            <!-- Invoice Header -->
            <div class="row align-items-center mb-4 pb-4 border-bottom">
                <div class="col-sm-6">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <span class="brand-icon"><i class="fas fa-car-side"></i></span>
                        <span class="brand-text fs-3 fw-bold">Drive<span class="brand-accent">Ease</span></span>
                    </div>
                    <div class="small text-muted">123 SG Highway, Iskcon Cross Roads, Ahmedabad, GJ</div>
                    <div class="small text-muted">GSTIN: 24AAACD1234E1Z5 | Support: +91 98765 43210</div>
                </div>
                <div class="col-sm-6 text-sm-end mt-3 mt-sm-0">
                    <h4 class="fw-bold text-primary mb-1">RENTAL INVOICE</h4>
                    <div class="fw-bold fs-5 text-dark">{{ $booking->booking_number }}</div>
                    <div class="small text-muted">Date: {{ $booking->created_at->format('d M Y, h:i A') }}</div>
                    <span class="badge-status {{ $booking->status_badge }} mt-2 d-inline-block">{{ $booking->status }}</span>
                </div>
            </div>

            <!-- Customer & Vehicle Meta -->
            <div class="row g-4 mb-4 pb-4 border-bottom">
                <div class="col-sm-6">
                    <h6 class="fw-bold text-uppercase text-muted small mb-2">Billed To (Customer)</h6>
                    <div class="fw-bold fs-6 text-dark">{{ $booking->user->name }}</div>
                    <div class="small text-muted">{{ $booking->user->email }}</div>
                    <div class="small text-muted">Phone: {{ $booking->user->phone ?? 'N/A' }}</div>
                    <div class="small text-muted">City: {{ $booking->user->city ?? 'Ahmedabad' }}, Gujarat</div>
                </div>
                <div class="col-sm-6">
                    <h6 class="fw-bold text-uppercase text-muted small mb-2">Vehicle Details</h6>
                    <div class="fw-bold fs-6 text-dark">{{ $booking->car->brand }} {{ $booking->car->model }} ({{ $booking->car->year }})</div>
                    <div class="small text-muted">Registration No: <span class="fw-semibold text-dark">{{ $booking->car->registration_number }}</span></div>
                    <div class="small text-muted">Fuel & Trans: {{ $booking->car->fuel_type }} ({{ $booking->car->transmission }})</div>
                    <div class="small text-muted">Pickup Hub: {{ $booking->pickup_location }}</div>
                </div>
            </div>

            <!-- Schedule -->
            <div class="row g-3 mb-4 p-3 bg-light rounded-3">
                <div class="col-sm-6">
                    <small class="text-muted d-block">Pickup Date & Time</small>
                    <strong class="text-dark"><i class="fas fa-calendar-alt text-primary me-1"></i> {{ $booking->pickup_date->format('d M Y') }} (10:00 AM)</strong>
                </div>
                <div class="col-sm-6">
                    <small class="text-muted d-block">Return Date & Time</small>
                    <strong class="text-dark"><i class="fas fa-calendar-check text-primary me-1"></i> {{ $booking->return_date->format('d M Y') }} (10:00 AM)</strong>
                </div>
            </div>

            <!-- Line Items Table -->
            <div class="table-responsive mb-4">
                <table class="table align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Description</th>
                            <th class="text-center">Days</th>
                            <th class="text-end">Daily Rate</th>
                            <th class="text-end">Total Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <strong>Vehicle Rental Charge</strong>
                                <div class="small text-muted">{{ $booking->car->brand }} {{ $booking->car->model }} self-drive rental</div>
                            </td>
                            <td class="text-center">{{ $booking->rental_days }}</td>
                            <td class="text-end">₹{{ number_format($booking->car->rental_price_per_day, 2) }}</td>
                            <td class="text-end fw-semibold">₹{{ number_format($booking->car->rental_price_per_day * $booking->rental_days, 2) }}</td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Refundable Security Deposit</strong>
                                <div class="small text-muted">Refunded upon car return inspection</div>
                            </td>
                            <td class="text-center">1</td>
                            <td class="text-end">₹{{ number_format($booking->security_deposit, 2) }}</td>
                            <td class="text-end fw-semibold">₹{{ number_format($booking->security_deposit, 2) }}</td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr class="table-light fs-5">
                            <th colspan="3" class="text-end">Grand Total Paid</th>
                            <th class="text-end text-primary fw-bold">₹{{ number_format($booking->total_amount, 2) }}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <!-- Payment Transaction Proof -->
            @if($booking->payment)
                <div class="p-3 border rounded-3 bg-light mb-4">
                    <div class="row align-items-center">
                        <div class="col-sm-6">
                            <div class="small text-muted">Payment Method: <strong>{{ $booking->payment->method }}</strong></div>
                            <div class="small text-muted">Transaction ID: <strong class="text-dark">{{ $booking->payment->transaction_id }}</strong></div>
                        </div>
                        <div class="col-sm-6 text-sm-end">
                            <div class="small text-muted">Razorpay Order: <strong>{{ $booking->payment->razorpay_order_id }}</strong></div>
                            <div class="small text-muted">Payment Status: <span class="badge bg-success">PAID SUCCESSFUL</span></div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Invoice Footer -->
            <div class="text-center pt-3 border-top text-muted small">
                Thank you for choosing DriveEase. Drive safely and adhere to traffic regulations across Gujarat!
            </div>
        </div>
    </div>
</section>
@endsection
