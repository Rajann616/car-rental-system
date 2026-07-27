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
        $fromDateInput = $request->input('from_date', $request->input('start_date'));
        $toDateInput = $request->input('to_date', $request->input('end_date'));

        $startDate = $fromDateInput ? Carbon::parse($fromDateInput)->startOfDay() : now()->subDays(30)->startOfDay();
        $endDate = $toDateInput ? Carbon::parse($toDateInput)->endOfDay() : now()->endOfDay();

        $fromDate = $startDate->format('Y-m-d');
        $toDate = $endDate->format('Y-m-d');

        $totalPeriodRevenue = Payment::where('status', 'Success')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->sum('amount');

        $totalPeriodBookings = Booking::whereBetween('created_at', [$startDate, $endDate])->count();
        $completedBookings = Booking::where('status', 'Completed')->whereBetween('created_at', [$startDate, $endDate])->count();
        $cancelledBookings = Booking::where('status', 'Cancelled')->whereBetween('created_at', [$startDate, $endDate])->count();

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
            'fromDate',
            'toDate',
            'totalPeriodRevenue',
            'totalPeriodBookings',
            'completedBookings',
            'cancelledBookings',
            'topVehicles',
            'payments'
        ));
    }
}
