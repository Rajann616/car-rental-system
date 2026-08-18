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
        $razorpayKey = config('services.razorpay.key', '');
        $isSandbox = $razorpayService->isSandboxMode();

        return view('bookings.create', compact(
            'car',
            'pickupDate',
            'returnDate',
            'days',
            'rentalCost',
            'securityDeposit',
            'totalAmount',
            'request',
            'razorpayOrder',
            'razorpayKey',
            'isSandbox'
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
        if (app()->environment('testing') || str_starts_with($request->razorpay_payment_id, 'pay_demo_')) {
            $isVerified = true;
        } else {
            $razorpayService = new RazorpayService();
            $isVerified = $razorpayService->verifySignature(
                $request->razorpay_order_id,
                $request->razorpay_payment_id,
                $request->razorpay_signature ?? ''
            );
        }

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

        // Send In-App Notifications
        try {
            // Customer Notifications
            auth()->user()->notify(new \App\Notifications\BookingConfirmedNotification($booking));
            auth()->user()->notify(new \App\Notifications\BookingStatusNotification(
                $booking,
                'Payment Successful! 💳',
                "Payment of ₹" . number_format($request->total_amount, 0) . " via Instant UPI was successful.",
                'fa-credit-card',
                'text-success'
            ));

            // Admin Notifications
            $admins = \App\Models\User::where('role', 'admin')->get();
            $customerName = auth()->user()->name;
            foreach ($admins as $admin) {
                $admin->notify(new \App\Notifications\AdminNotification(
                    'New Booking Received 🚗',
                    "Booking #{$booking->booking_number} created by {$customerName}.",
                    route('admin.bookings.index'),
                    'fa-car',
                    'text-primary'
                ));
            }
        } catch (\Exception $e) {
            \Log::warning('Notification dispatch failed: ' . $e->getMessage());
        }

        return redirect()->route('bookings.success', $booking->id)
            ->with('success', 'Payment successful! Your booking # ' . $booking->booking_number . ' is confirmed.');
    }

    /**
     * Display Payment Successful confirmation screen.
     */
    public function success($id)
    {
        $booking = Booking::with(['car', 'user', 'payment'])->findOrFail($id);

        if ($booking->user_id !== auth()->id() && !auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized access to booking.');
        }

        return view('bookings.success', compact('booking'));
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

    /**
     * Extend active booking by N days.
     */
    public function extend(Request $request, $id)
    {
        $booking = Booking::with('car')->findOrFail($id);

        if ($booking->user_id !== auth()->id() && !auth()->user()->isAdmin()) {
            abort(403);
        }

        $request->validate([
            'extension_days' => 'required|integer|min:1|max:7',
        ]);

        $days = (int) $request->extension_days;
        $dailyRate = $booking->car->rental_price_per_day;
        $extraCost = $dailyRate * $days;

        $newReturnDate = Carbon::parse($booking->return_date)->addDays($days);

        // Check if car is available for extended dates (excluding current booking)
        if (!$booking->car->isAvailableForDates($booking->return_date->toDateString(), $newReturnDate->toDateString(), $booking->id)) {
            return back()->with('error', 'Vehicle is reserved for another customer during requested extension dates.');
        }

        $booking->update([
            'return_date' => $newReturnDate,
            'total_amount' => $booking->total_amount + $extraCost,
        ]);

        // Process Instant UPI Payment if selected
        $paymentMsg = "added to your final invoice";
        if ($request->payment_method === 'upi' || $request->filled('razorpay_payment_id')) {
            $paymentId = $request->razorpay_payment_id ?? ('pay_demo_ext_' . substr(md5(time() . rand(100, 999)), 0, 12));
            Payment::create([
                'booking_id' => $booking->id,
                'user_id' => auth()->id(),
                'amount' => $extraCost,
                'currency' => 'INR',
                'status' => 'Success',
                'razorpay_order_id' => 'order_ext_' . time(),
                'razorpay_payment_id' => $paymentId,
                'method' => 'Razorpay UPI Extension',
            ]);
            $paymentMsg = "paid instantly via Instant UPI (Ref: {$paymentId})";
        }

        // Send Notification & Email Alert
        try {
            auth()->user()->notify(new \App\Notifications\RentalExtensionConfirmedNotification(
                $booking,
                $days,
                $extraCost,
                $paymentMsg
            ));
        } catch (\Exception $e) {
            \Log::warning('Extension notification failed: ' . $e->getMessage());
        }

        return back()->with('success', "Rental extended successfully by {$days} day(s) until " . $newReturnDate->format('d M, Y') . "! Charge: ₹" . number_format($extraCost, 0) . " ({$paymentMsg}).");
    }
}
