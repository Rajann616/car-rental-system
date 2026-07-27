<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the premium landing page.
     */
    public function index()
    {
        $featuredCars = Car::available()
            ->orderBy('rental_price_per_day', 'desc')
            ->take(6)
            ->get();

        $brands = Car::select('brand')
            ->distinct()
            ->orderBy('brand')
            ->pluck('brand');

        return view('home', compact('featuredCars', 'brands'));
    }
}
