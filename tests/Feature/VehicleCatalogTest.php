<?php

namespace Tests\Feature;

use App\Models\Car;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VehicleCatalogTest extends TestCase
{
    use RefreshDatabase;

    protected Car $car1;
    protected Car $car2;

    protected function setUp(): void
    {
        parent::setUp();

        $this->car1 = Car::create([
            'brand' => 'BMW',
            'model' => '5 Series',
            'year' => 2024,
            'registration_number' => 'GJ-01-BM-5555',
            'fuel_type' => 'Petrol',
            'transmission' => 'Automatic',
            'seating_capacity' => 5,
            'rental_price_per_day' => 8000,
            'status' => 'Available',
        ]);

        $this->car2 = Car::create([
            'brand' => 'Audi',
            'model' => 'A6',
            'year' => 2023,
            'registration_number' => 'GJ-01-AU-6666',
            'fuel_type' => 'Diesel',
            'transmission' => 'Automatic',
            'seating_capacity' => 5,
            'rental_price_per_day' => 7500,
            'status' => 'Booked',
        ]);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function homepage_displays_featured_available_cars()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('BMW');
        $response->assertSee('5 Series');
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function cars_index_page_lists_all_vehicles()
    {
        $response = $this->get('/cars');
        $response->assertStatus(200);
        $response->assertSee('BMW');
        $response->assertSee('Audi');
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function cars_index_page_filters_by_brand()
    {
        $response = $this->get('/cars?brand=BMW');
        $response->assertStatus(200);
        $response->assertSee('BMW');
        $response->assertDontSee('Audi A6');
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function car_show_page_displays_vehicle_details_and_delivery_map()
    {
        $response = $this->get("/cars/{$this->car1->id}");
        $response->assertStatus(200);
        $response->assertSee('BMW 5 Series');
        $response->assertSee('Delivery Address');
        $response->assertSee('📍 Use Current Location');
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function car_show_page_returns_404_for_non_existent_car()
    {
        $response = $this->get('/cars/99999');
        $response->assertStatus(404);
    }
}
