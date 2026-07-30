@extends('layouts.app')

@section('title', 'Confirm Booking — AutoLux')

@section('content')
<section class="dashboard-section pb-5">
    <div class="container">
        <!-- Header -->
        <div class="dashboard-header mb-4" data-aos="fade-down">
            <h1 class="fw-bold mb-1">Confirm Reservation & Payment</h1>
            <p class="text-muted">Review your itinerary and complete payment via Instant UPI / GPay.</p>
        </div>

        <div class="row g-4">
            <!-- Left Column: Itinerary Details -->
            <div class="col-lg-7" data-aos="fade-right">
                <div class="dashboard-card mb-4 border-0 shadow-sm rounded-4 bg-white">
                    <div class="card-header-custom p-4 border-bottom">
                        <h5 class="fw-bold mb-0 text-dark"><i class="fas fa-route me-2 text-primary"></i> Rental Summary</h5>
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

                        <div class="row g-3 mb-3">
                            <div class="col-6">
                                <div class="p-3 border rounded-3 bg-white">
                                    <div class="small text-muted"><i class="fas fa-calendar-alt me-1 text-primary"></i> Delivery Date</div>
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

                        <div class="p-3 border rounded-3 bg-white">
                            <div class="small text-muted"><i class="fas fa-map-marker-alt me-1 text-primary"></i> Delivery Address</div>
                            <div class="fw-bold text-dark">{{ $request->pickup_location }}</div>
                        </div>
                    </div>
                </div>

                <!-- Driver Contact & Verification Summary -->
                <div class="dashboard-card border-0 shadow-sm rounded-4 bg-white">
                    <div class="card-header-custom p-4 border-bottom">
                        <h5 class="fw-bold mb-0 text-dark"><i class="fas fa-user-check me-2 text-primary"></i> Customer Information</h5>
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
                                <label class="small text-muted">Phone</label>
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

            <!-- Right Column: Fare Breakdown & Instant UPI Payment -->
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
                            <span class="text-muted">Security Deposit</span>
                            <span class="fw-semibold text-dark">₹{{ number_format($securityDeposit, 0) }}</span>
                        </div>

                        <hr>

                        <div class="d-flex justify-content-between mb-4">
                            <span class="fw-bold fs-5 text-dark">Total Payable</span>
                            <span class="fw-bold fs-4 text-primary">₹{{ number_format($totalAmount, 0) }}</span>
                        </div>

                        <!-- Hidden Form for Payment Submission -->
                        <form action="{{ route('customer.bookings.store') }}" method="POST" id="upiPaymentForm">
                            @csrf
                            <input type="hidden" name="car_id" value="{{ $car->id }}">
                            <input type="hidden" name="pickup_date" value="{{ $pickupDate->toDateString() }}">
                            <input type="hidden" name="return_date" value="{{ $returnDate->toDateString() }}">
                            <input type="hidden" name="pickup_location" value="{{ $request->pickup_location }}">
                            <input type="hidden" name="total_amount" value="{{ $totalAmount }}">
                            <input type="hidden" name="security_deposit" value="{{ $securityDeposit }}">
                            
                            <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id">
                            <input type="hidden" name="razorpay_order_id" id="razorpay_order_id" value="{{ $razorpayOrder['id'] }}">
                            <input type="hidden" name="razorpay_signature" id="razorpay_signature">

                            <button type="button" id="payBtn" onclick="startUPIPayment()" class="btn btn-success btn-lg w-100 rounded-pill fw-bold py-3 shadow-lg" style="background: linear-gradient(135deg, #ff7a00, #ea580c); border: none;">
                                <i class="fas fa-lock me-2"></i> Proceed to Secure Payment
                            </button>
                        </form>

                        <div class="text-center mt-3">
                            <small class="text-muted"><i class="fas fa-shield-alt text-success me-1"></i> 256-Bit Encrypted Secure Checkout</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Instant UPI JS Checkout Integration -->
@if(!$isSandbox)
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
@endif
<script>
    const IS_SANDBOX = @json($isSandbox);

    function startUPIPayment() {
        const payBtn = document.getElementById('payBtn');
        payBtn.disabled = true;
        payBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Processing...';

        if (IS_SANDBOX) {
            // Sandbox / Demo mode — simulate payment directly
            if (!confirm('🧪 Demo Mode: No real payment will be charged.\n\nClick OK to simulate a successful payment.')) {
                payBtn.disabled = false;
                payBtn.innerHTML = '<i class="fas fa-lock me-2"></i> Proceed to Secure Payment';
                return;
            }

            const demoPaymentId = "pay_demo_" + Math.random().toString(36).substring(2, 16);
            document.getElementById('razorpay_payment_id').value = demoPaymentId;
            document.getElementById('razorpay_signature').value = '';
            document.getElementById('upiPaymentForm').submit();
            return;
        }

        // Production mode — open real Razorpay checkout
        const options = {
            "key": @json($razorpayKey),
            "amount": "{{ $totalAmount * 100 }}",
            "currency": "INR",
            "name": "AutoLux Car Rental",
            "description": "Rental Booking for {{ $car->brand }} {{ $car->model }}",
            "image": "https://cdn-icons-png.flaticon.com/512/3202/3202926.png",
            "order_id": "{{ $razorpayOrder['id'] }}",
            "handler": function (response) {
                document.getElementById('razorpay_payment_id').value = response.razorpay_payment_id;
                document.getElementById('razorpay_order_id').value = response.razorpay_order_id;
                document.getElementById('razorpay_signature').value = response.razorpay_signature || '';
                document.getElementById('upiPaymentForm').submit();
            },
            "prefill": {
                "name": "{{ auth()->user()->name }}",
                "email": "{{ auth()->user()->email }}",
                "contact": "{{ auth()->user()->phone ?? '' }}"
            },
            "modal": {
                "ondismiss": function() {
                    payBtn.disabled = false;
                    payBtn.innerHTML = '<i class="fas fa-lock me-2"></i> Proceed to Secure Payment';
                }
            },
            "theme": {
                "color": "#2563eb"
            }
        };

        try {
            const rzp = new Razorpay(options);
            rzp.on('payment.failed', function (response) {
                alert("Payment Failed: " + response.error.description);
                payBtn.disabled = false;
                payBtn.innerHTML = '<i class="fas fa-lock me-2"></i> Proceed to Secure Payment';
            });
            rzp.open();
        } catch (e) {
            console.error('Razorpay initialization error:', e);
            alert('Payment gateway could not be loaded. Please try again.');
            payBtn.disabled = false;
            payBtn.innerHTML = '<i class="fas fa-lock me-2"></i> Pay ₹{{ number_format($totalAmount, 0) }} via Instant UPI / GPay';
        }
    }
</script>
@endsection
