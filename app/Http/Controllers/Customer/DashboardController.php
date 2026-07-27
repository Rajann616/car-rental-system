<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
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
            ->with('car')
            ->latest()
            ->take(5)
            ->get();

        $totalBookings = $user->bookings()->count();
        $totalSpent = $user->payments()->where('status', 'Success')->sum('amount');
        $documentsCount = $user->documents()->count();
        $pendingDocuments = $user->documents()->where('status', 'Pending')->count();

        return view('customer.dashboard', compact(
            'activeBookings',
            'recentBookings',
            'totalBookings',
            'totalSpent',
            'documentsCount',
            'pendingDocuments'
        ));
    }
}
