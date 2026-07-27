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

        return back()->with('success', "Booking #{$booking->booking_number} updated to {$newStatus}.");
    }
}
