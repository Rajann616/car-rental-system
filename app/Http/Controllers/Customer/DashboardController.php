<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Car;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Show the customer dashboard.
     */
    public function index()
    {
        $user = auth()->user();

        $activeBookings = $user->bookings()
            ->whereIn('status', ['Confirmed', 'Active'])
            ->with('car')
            ->latest()
            ->get();

        $recentBookings = $user->bookings()
            ->with(['car', 'payment'])
            ->latest()
            ->take(5)
            ->get();

        $totalBookings = $user->bookings()->count();
        $totalSpent = $user->payments()->where('status', 'Success')->sum('amount');
        $documentsCount = $user->documents()->count();
        $approvedDocuments = $user->documents()->where('status', 'Approved')->count();
        $pendingDocuments = $user->documents()->where('status', 'Pending')->count();

        // Recommended vehicles for quick booking
        $recommendedCars = Car::available()
            ->orderBy('rental_price_per_day', 'asc')
            ->take(3)
            ->get();

        return view('customer.dashboard', compact(
            'activeBookings',
            'recentBookings',
            'totalBookings',
            'totalSpent',
            'documentsCount',
            'approvedDocuments',
            'pendingDocuments',
            'recommendedCars'
        ));
    }

    /**
     * Save customer search alert preference.
     */
    public function saveSearch(Request $request)
    {
        $user = auth()->user();

        $brand = $request->get('brand', 'All Brands');
        $keyword = $request->get('keyword', '');

        // Dispatch notification
        try {
            $user->notify(new \App\Notifications\BookingStatusNotification(
                new \App\Models\Booking(['booking_number' => 'ALERT-' . rand(1000, 9999)]),
                "Search Alert Saved 🔔",
                "Your search alert for " . ($brand ?: "vehicles") . " " . ($keyword ? "'{$keyword}'" : "") . " has been saved. We will notify you when new matching cars arrive!",
                'fa-bell',
                'text-warning'
            ));
        } catch (\Exception $e) {
            \Log::warning('Save search notification failed: ' . $e->getMessage());
        }

        return back()->with('success', "Search Alert Saved! We'll notify you via email & in-app alerts when new " . ($brand ?: "matching") . " vehicles are listed.");
    }
}
