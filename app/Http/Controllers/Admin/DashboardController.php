<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Car;
use App\Models\Document;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Show the admin dashboard.
     */
    public function index()
    {
        $stats = [
            'total_customers' => User::where('role', 'customer')->count(),
            'total_vehicles' => Car::count(),
            'available_vehicles' => Car::where('status', 'Available')->count(),
            'booked_vehicles' => Car::whereIn('status', ['Booked', 'Rented'])->count(),
            'maintenance_vehicles' => Car::where('status', 'Maintenance')->count(),
            'today_bookings' => Booking::whereDate('created_at', today())->count(),
            'monthly_revenue' => Payment::where('status', 'Success')
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->sum('amount'),
            'total_revenue' => Payment::where('status', 'Success')->sum('amount'),
            'pending_bookings' => Booking::where('status', 'Pending')->count(),
            'active_bookings' => Booking::where('status', 'Active')->count(),
            'pending_documents' => Document::where('status', 'Pending')->count(),
        ];

        $recentBookings = Booking::with(['user', 'car', 'payment'])
            ->latest()
            ->take(10)
            ->get();

        $recentPayments = Payment::with(['user', 'booking.car'])
            ->where('status', 'Success')
            ->latest()
            ->take(5)
            ->get();

        $pendingDocumentsList = Document::with('user')
            ->where('status', 'Pending')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'stats',
            'recentBookings',
            'recentPayments',
            'pendingDocumentsList'
        ));
    }
}
