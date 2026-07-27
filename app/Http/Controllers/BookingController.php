<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Car;
use App\Models\Payment;
use App\Services\RazorpayService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    /**
     * Show booking checkout / confirmation page.
     */
    public function create(Request $request, $carId)
    {
        $car = Car::findOrFail($carId);

        $request->validate([
            'pickup_date' => 'required|date|after_or_equal:today',
            'return_date' => 'required|date|after:pickup_date',
            'pickup_location' => 'required|string',
        ]);

        $pickupDate = Carbon::parse($request->pickup_date);
        $returnDate = Carbon::parse($request->return_date);

        // Check availability
        if (!$car->isAvailableForDates($pickupDate->toDateString(), $returnDate->toDateString())) {
            return back()->with('error', 'This vehicle is not available for the selected dates. Please choose different dates.');
        }

        $days = max(1, $pickupDate->diffInDays($returnDate));
        $rentalCost = $car->rental_price_per_day * $days;
        $securityDeposit = 2000;
        $totalAmount = $rentalCost + $securityDeposit;

        // Initialize Razorpay Order
        $razorpayService = new RazorpayService();
        $tempReceipt = 'REC-' . time();
        $razorpayOrder = $razorpayService->createOrder($totalAmount, $tempReceipt);

        return view('bookings.create', compact(
            'car',
            'pickupDate',
            'returnDate',
            'days',
            'rentalCost',
            'securityDeposit',
            'totalAmount',
            'request',
            'razorpayOrder'
        ));
    }

    /**
     * Store booking and process payment callback.
     */
    public function store(Request $request)
    {
        $request->validate([
            'car_id' => 'required|exists:cars,id',
            'pickup_date' => 'required|date',
            'return_date' => 'required|date',
            'pickup_location' => 'required|string',
            'total_amount' => 'required|numeric',
            'security_deposit' => 'required|numeric',
            'razorpay_payment_id' => 'required|string',
            'razorpay_order_id' => 'required|string',
            'razorpay_signature' => 'nullable|string',
        ]);

        $car = Car::findOrFail($request->car_id);

        // Double check availability
        if (!$car->isAvailableForDates($request->pickup_date, $request->return_date)) {
            return redirect()->route('cars.index')->with('error', 'Vehicle is no longer available for selected dates.');
        }

        // Verify Payment
        $razorpayService = new RazorpayService();
        $isVerified = $razorpayService->verifySignature(
            $request->razorpay_order_id,
            $request->razorpay_payment_id,
            $request->razorpay_signature ?? ''
        );

        $paymentStatus = $isVerified ? 'Success' : 'Pending';
        $bookingStatus = $isVerified ? 'Confirmed' : 'Pending';

        // Create Booking
        $booking = Booking::create([
            'user_id' => auth()->id(),
            'car_id' => $car->id,
            'pickup_date' => $request->pickup_date,
            'return_date' => $request->return_date,
            'total_amount' => $request->total_amount,
            'security_deposit' => $request->security_deposit,
            'pickup_location' => $request->pickup_location,
            'return_location' => $request->pickup_location,
            'status' => $bookingStatus,
        ]);

        // Create Payment Record
        Payment::create([
            'booking_id' => $booking->id,
            'user_id' => auth()->id(),
            'amount' => $request->total_amount,
            'currency' => 'INR',
            'status' => $paymentStatus,
            'razorpay_order_id' => $request->razorpay_order_id,
            'razorpay_payment_id' => $request->razorpay_payment_id,
            'razorpay_signature' => $request->razorpay_signature,
            'method' => 'Razorpay Online',
        ]);

        // Mark Car status as Booked
        if ($bookingStatus === 'Confirmed') {
            $car->update(['status' => 'Booked']);
        }

        return redirect()->route('bookings.show', $booking->id)
            ->with('success', 'Booking confirmed successfully! Your rental receipt and invoice are generated.');
    }

    /**
     * Display customer booking details / invoice page.
     */
    public function show($id)
    {
        $booking = Booking::with(['car', 'user', 'payment'])->findOrFail($id);

        if ($booking->user_id !== auth()->id() && !auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized access to booking.');
        }

        return view('bookings.show', compact('booking'));
    }

    /**
     * Display list of customer bookings.
     */
    public function index()
    {
        $bookings = auth()->user()->bookings()->with('car')->latest()->paginate(10);
        return view('bookings.index', compact('bookings'));
    }

    /**
     * Cancel booking.
     */
    public function cancel(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);

        if ($booking->user_id !== auth()->id() && !auth()->user()->isAdmin()) {
            abort(403);
        }

        if (!$booking->canBeCancelled()) {
            return back()->with('error', 'Booking cannot be cancelled less than 24 hours before pickup.');
        }

        $booking->update([
            'status' => 'Cancelled',
            'cancelled_at' => now(),
            'cancellation_reason' => $request->get('reason', 'Cancelled by customer'),
        ]);

        // Release car back to Available status
        $booking->car->update(['status' => 'Available']);

        return back()->with('success', 'Booking cancelled successfully. Refund will be processed as per policy.');
    }
}
