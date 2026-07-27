<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    /**
     * Display a listing of vehicles with search & filters.
     */
    public function index(Request $request)
    {
        $query = Car::query();

        // Search by keyword
        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->where(function ($q) use ($keyword) {
                $q->where('brand', 'like', "%{$keyword}%")
                  ->orWhere('model', 'like', "%{$keyword}%")
                  ->orWhere('description', 'like', "%{$keyword}%");
            });
        }

        // Filter by brand
        if ($request->filled('brand')) {
            $query->where('brand', $request->brand);
        }

        // Filter by fuel type
        if ($request->filled('fuel_type')) {
            $query->where('fuel_type', $request->fuel_type);
        }

        // Filter by transmission
        if ($request->filled('transmission')) {
            $query->where('transmission', $request->transmission);
        }

        // Filter by price range
        if ($request->filled('min_price')) {
            $query->where('rental_price_per_day', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('rental_price_per_day', '<=', $request->max_price);
        }

        // Sort order
        $sortBy = $request->get('sort', 'latest');
        match ($sortBy) {
            'price_low' => $query->orderBy('rental_price_per_day', 'asc'),
            'price_high' => $query->orderBy('rental_price_per_day', 'desc'),
            default => $query->latest(),
        };

        $cars = $query->paginate(9)->withQueryString();

        $brands = Car::select('brand')->distinct()->pluck('brand');
        $fuelTypes = ['Petrol', 'Diesel', 'Electric', 'Hybrid', 'CNG'];
        $transmissions = ['Manual', 'Automatic'];

        return view('cars.index', compact('cars', 'brands', 'fuelTypes', 'transmissions'));
    }

    /**
     * Display the specified vehicle detail page.
     */
    public function show($id)
    {
        $car = Car::with(['images', 'bookings' => function ($q) {
            $q->whereIn('status', ['Confirmed', 'Active']);
        }])->findOrFail($id);

        $similarCars = Car::where('brand', $car->brand)
            ->where('id', '!=', $car->id)
            ->take(3)
            ->get();

        if ($similarCars->isEmpty()) {
            $similarCars = Car::where('id', '!=', $car->id)->take(3)->get();
        }

        return view('cars.show', compact('car', 'similarCars'));
    }
}
