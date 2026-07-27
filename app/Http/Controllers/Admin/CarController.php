<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\CarImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CarController extends Controller
{
    /**
     * Display a listing of all cars for admin.
     */
    public function index(Request $request)
    {
        $query = Car::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('brand', 'like', "%{$search}%")
                  ->orWhere('model', 'like', "%{$search}%")
                  ->orWhere('registration_number', 'like', "%{$search}%");
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $cars = $query->latest()->paginate(10)->withQueryString();

        return view('admin.cars.index', compact('cars'));
    }

    /**
     * Show form to create new vehicle.
     */
    public function create()
    {
        return view('admin.cars.create');
    }

    /**
     * Store newly created vehicle in database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'brand' => 'required|string|max:100',
            'model' => 'required|string|max:100',
            'year' => 'required|integer|min:2000|max:' . (date('Y') + 1),
            'registration_number' => 'required|string|max:20|unique:cars,registration_number',
            'fuel_type' => 'required|in:Petrol,Diesel,Electric,Hybrid,CNG',
            'transmission' => 'required|in:Manual,Automatic',
            'seating_capacity' => 'required|integer|min:2|max:20',
            'rental_price_per_day' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'features' => 'nullable|array',
            'status' => 'required|in:Available,Booked,Rented,Maintenance',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $request->file('thumbnail')->store('cars/thumbnails', 'public');
        }

        $car = Car::create($validated);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $imageFile) {
                $path = $imageFile->store('cars/gallery', 'public');
                $car->images()->create([
                    'image_path' => $path,
                    'sort_order' => $index,
                ]);
            }
        }

        return redirect()->route('admin.cars.index')
            ->with('success', 'Vehicle added successfully!');
    }

    /**
     * Show form to edit existing vehicle.
     */
    public function edit(Car $car)
    {
        return view('admin.cars.edit', compact('car'));
    }

    /**
     * Update vehicle in database.
     */
    public function update(Request $request, Car $car)
    {
        $validated = $request->validate([
            'brand' => 'required|string|max:100',
            'model' => 'required|string|max:100',
            'year' => 'required|integer|min:2000|max:' . (date('Y') + 1),
            'registration_number' => 'required|string|max:20|unique:cars,registration_number,' . $car->id,
            'fuel_type' => 'required|in:Petrol,Diesel,Electric,Hybrid,CNG',
            'transmission' => 'required|in:Manual,Automatic',
            'seating_capacity' => 'required|integer|min:2|max:20',
            'rental_price_per_day' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'features' => 'nullable|array',
            'status' => 'required|in:Available,Booked,Rented,Maintenance',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($request->hasFile('thumbnail')) {
            if ($car->thumbnail) {
                Storage::disk('public')->delete($car->thumbnail);
            }
            $validated['thumbnail'] = $request->file('thumbnail')->store('cars/thumbnails', 'public');
        }

        $car->update($validated);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $imageFile) {
                $path = $imageFile->store('cars/gallery', 'public');
                $car->images()->create([
                    'image_path' => $path,
                    'sort_order' => $car->images()->count() + $index,
                ]);
            }
        }

        return redirect()->route('admin.cars.index')
            ->with('success', 'Vehicle updated successfully!');
    }

    /**
     * Remove vehicle from database.
     */
    public function destroy(Car $car)
    {
        if ($car->thumbnail) {
            Storage::disk('public')->delete($car->thumbnail);
        }

        foreach ($car->images as $image) {
            Storage::disk('public')->delete($image->image_path);
        }

        $car->delete();

        return redirect()->route('admin.cars.index')
            ->with('success', 'Vehicle deleted successfully!');
    }
}
