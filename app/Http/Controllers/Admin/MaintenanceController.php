<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\MaintenanceRecord;
use Illuminate\Http\Request;

class MaintenanceController extends Controller
{
    /**
     * Display maintenance schedule for admin.
     */
    public function index()
    {
        $records = MaintenanceRecord::with('car')->latest()->paginate(10);
        $cars = Car::orderBy('brand')->get();

        return view('admin.maintenance.index', compact('records', 'cars'));
    }

    /**
     * Store new maintenance record & auto-toggle car status to Maintenance.
     */
    public function store(Request $request)
    {
        $request->validate([
            'car_id' => 'required|exists:cars,id',
            'title' => 'required|string|max:255',
            'scheduled_date' => 'required|date',
            'cost' => 'nullable|numeric|min:0',
            'description' => 'nullable|string',
        ]);

        $record = MaintenanceRecord::create([
            'car_id' => $request->car_id,
            'title' => $request->title,
            'scheduled_date' => $request->scheduled_date,
            'cost' => $request->cost ?? 0,
            'description' => $request->description,
            'status' => 'In Progress',
        ]);

        // Auto toggle vehicle status to Maintenance
        $record->car->update(['status' => 'Maintenance']);

        return back()->with('success', 'Maintenance record created and vehicle status set to Maintenance.');
    }

    /**
     * Mark maintenance as completed & release vehicle back to Available status.
     */
    public function complete($id)
    {
        $record = MaintenanceRecord::findOrFail($id);

        $record->update([
            'status' => 'Completed',
            'completed_date' => now(),
        ]);

        // Release vehicle status back to Available
        $record->car->update(['status' => 'Available']);

        return back()->with('success', 'Maintenance marked as Completed. Vehicle is now Available for rent!');
    }
}
