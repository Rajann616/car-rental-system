<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    /**
     * Display listing of all bookings for admin.
     */
    public function index(Request $request)
    {
        $query = Booking::with(['user', 'car', 'payment']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('booking_number', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($u) use ($search) {
                      $u->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $bookings = $query->latest()->paginate(10)->withQueryString();

        return view('admin.bookings.index', compact('bookings'));
    }

    /**
     * Update booking status (Pending -> Confirmed -> Active -> Completed -> Cancelled).
     */
    public function updateStatus(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);

        $request->validate([
            'status' => 'required|in:Pending,Confirmed,Active,Completed,Cancelled',
        ]);

        $newStatus = $request->status;
        $booking->update(['status' => $newStatus]);

        // Synchronize car status
        if (in_array($newStatus, ['Confirmed', 'Active'])) {
            $booking->car->update(['status' => 'Booked']);
        } elseif (in_array($newStatus, ['Completed', 'Cancelled'])) {
            $booking->car->update(['status' => 'Available']);
        }

        // Send In-App Notification to Customer
        try {
            $statusIcons = [
                'Confirmed' => ['icon' => 'fa-check-circle', 'color' => 'text-success', 'title' => 'Booking Confirmed! 🎉', 'msg' => 'Your booking has been verified and confirmed by AutoLux.'],
                'Active' => ['icon' => 'fa-key', 'color' => 'text-info', 'title' => 'Vehicle Handed Over! 🔑', 'msg' => 'Vehicle has been handed over. Your rental trip is now active.'],
                'Completed' => ['icon' => 'fa-flag-checkered', 'color' => 'text-primary', 'title' => 'Rental Completed! 🏁', 'msg' => 'Vehicle returned and rental period completed successfully.'],
                'Cancelled' => ['icon' => 'fa-times-circle', 'color' => 'text-danger', 'title' => 'Booking Cancelled ⚠️', 'msg' => 'Your booking reservation has been cancelled.'],
            ];

            $meta = $statusIcons[$newStatus] ?? ['icon' => 'fa-info-circle', 'color' => 'text-primary', 'title' => "Booking {$newStatus}", 'msg' => "Your booking status was updated to {$newStatus}."];

            $booking->user->notify(new \App\Notifications\BookingStatusNotification(
                $booking,
                $meta['title'],
                $meta['msg'],
                $meta['icon'],
                $meta['color']
            ));
        } catch (\Exception $e) {
            \Log::warning('Booking status notification failed: ' . $e->getMessage());
        }

        return back()->with('success', "Booking #{$booking->booking_number} updated to {$newStatus}.");
    }
}
