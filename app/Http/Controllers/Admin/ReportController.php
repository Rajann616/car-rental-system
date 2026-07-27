<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Car;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    /**
     * Display reporting dashboard with date filtering.
     */
    public function index(Request $request)
    {
        $startDate = $request->filled('start_date') ? Carbon::parse($request->start_date)->startOfDay() : now()->subDays(30)->startOfDay();
        $endDate = $request->filled('end_date') ? Carbon::parse($request->end_date)->endOfDay() : now()->endOfDay();

        $totalRevenue = Payment::where('status', 'Success')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->sum('amount');

        $totalBookingsCount = Booking::whereBetween('created_at', [$startDate, $endDate])->count();
        $completedBookingsCount = Booking::where('status', 'Completed')->whereBetween('created_at', [$startDate, $endDate])->count();
        $cancelledBookingsCount = Booking::where('status', 'Cancelled')->whereBetween('created_at', [$startDate, $endDate])->count();

        // Top performing vehicles by revenue
        $topVehicles = Car::withCount(['bookings' => function ($q) use ($startDate, $endDate) {
            $q->whereBetween('created_at', [$startDate, $endDate]);
        }])
        ->get()
        ->sortByDesc('bookings_count')
        ->take(5);

        // Recent Payments Log
        $payments = Payment::with(['user', 'booking.car'])
            ->whereBetween('created_at', [$startDate, $endDate])
            ->latest()
            ->paginate(15);

        return view('admin.reports.index', compact(
            'startDate',
            'endDate',
            'totalRevenue',
            'totalBookingsCount',
            'completedBookingsCount',
            'cancelledBookingsCount',
            'topVehicles',
            'payments'
        ));
    }
}
