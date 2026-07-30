<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Car;
use App\Models\Booking;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CarRentalFeatureTest extends TestCase
{
    use RefreshDatabase;

    protected User $customer;
    protected User $admin;
    protected Car $car;

    protected function setUp(): void
    {
        parent::setUp();

        // Create Customer User
        $this->customer = User::create([
            'name' => 'John Customer',
            'email' => 'customer@example.com',
            'password' => bcrypt('password123'),
            'role' => 'customer',
        ]);

        // Create Admin User
        $this->admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('admin123'),
            'role' => 'admin',
        ]);

        // Create Available Vehicle
        $this->car = Car::create([
            'brand' => 'Maruti Suzuki',
            'model' => 'Baleno',
            'year' => 2024,
            'registration_number' => 'GJ-01-AB-1234',
            'fuel_type' => 'Petrol',
            'transmission' => 'Automatic',
            'seating_capacity' => 5,
            'rental_price_per_day' => 1500,
            'status' => 'Available',
        ]);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function public_user_can_view_homepage_and_browse_cars()
    {
        $response = $this->get('/');
        $response->assertStatus(200);

        $response = $this->get('/cars');
        $response->assertStatus(200);

        $response = $this->get("/cars/{$this->car->id}");
        $response->assertStatus(200);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function customer_can_access_dashboard_and_documents()
    {
        $response = $this->actingAs($this->customer)->get('/customer/dashboard');
        $response->assertStatus(200);

        $response = $this->actingAs($this->customer)->get('/customer/documents');
        $response->assertStatus(200);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function customer_can_create_booking()
    {
        $bookingData = [
            'car_id' => $this->car->id,
            'pickup_date' => now()->addDay()->toDateString(),
            'return_date' => now()->addDays(3)->toDateString(),
            'pickup_location' => 'Ahmedabad Station',
            'total_amount' => 6500,
            'security_deposit' => 2000,
            'razorpay_payment_id' => 'pay_test_' . rand(1000, 9999),
            'razorpay_order_id' => 'order_test_' . rand(1000, 9999),
            'razorpay_signature' => 'test_sig',
        ];

        $response = $this->actingAs($this->customer)->post('/customer/bookings', $bookingData);
        
        $this->assertDatabaseHas('bookings', [
            'user_id' => $this->customer->id,
            'car_id' => $this->car->id,
            'status' => 'Confirmed',
        ]);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function admin_can_access_admin_dashboard_and_manage_cars()
    {
        $response = $this->actingAs($this->admin)->get('/admin/dashboard');
        $response->assertStatus(200);

        $response = $this->actingAs($this->admin)->get('/admin/cars');
        $response->assertStatus(200);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function non_admin_cannot_access_admin_dashboard()
    {
        $response = $this->actingAs($this->customer)->get('/admin/dashboard');
        $response->assertRedirect('/customer/dashboard');
    }
}
