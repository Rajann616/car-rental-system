<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Car;
use App\Models\Booking;
use App\Models\Document;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminManagementTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;
    protected User $customer;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::create([
            'name' => 'Super Admin',
            'email' => 'admin@autolux.in',
            'password' => bcrypt('admin123'),
            'role' => 'admin',
        ]);

        $this->customer = User::create([
            'name' => 'Sample Customer',
            'email' => 'sample@example.com',
            'password' => bcrypt('password123'),
            'role' => 'customer',
        ]);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function admin_can_view_admin_dashboard_and_reports()
    {
        $response = $this->actingAs($this->admin)->get('/admin/dashboard');
        $response->assertStatus(200);

        $response = $this->actingAs($this->admin)->get('/admin/reports');
        $response->assertStatus(200);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function admin_can_create_edit_and_delete_vehicles()
    {
        // Store
        $carData = [
            'brand' => 'Mercedes-Benz',
            'model' => 'E-Class',
            'year' => 2024,
            'registration_number' => 'GJ-01-MB-9999',
            'fuel_type' => 'Petrol',
            'transmission' => 'Automatic',
            'seating_capacity' => 5,
            'rental_price_per_day' => 12000,
            'status' => 'Available',
        ];

        $response = $this->actingAs($this->admin)->post('/admin/cars', $carData);
        $response->assertRedirect('/admin/cars');
        $this->assertDatabaseHas('cars', ['registration_number' => 'GJ-01-MB-9999']);

        $car = Car::where('registration_number', 'GJ-01-MB-9999')->first();

        // Update
        $carData['rental_price_per_day'] = 13500;
        $response = $this->actingAs($this->admin)->put("/admin/cars/{$car->id}", $carData);
        $response->assertRedirect('/admin/cars');
        $this->assertDatabaseHas('cars', ['rental_price_per_day' => 13500]);

        // Destroy
        $response = $this->actingAs($this->admin)->delete("/admin/cars/{$car->id}");
        $response->assertRedirect('/admin/cars');
        $this->assertDatabaseMissing('cars', ['id' => $car->id]);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function admin_can_update_booking_status()
    {
        $car = Car::create([
            'brand' => 'Kia',
            'model' => 'Seltos',
            'year' => 2023,
            'registration_number' => 'GJ-01-KI-1111',
            'fuel_type' => 'Petrol',
            'transmission' => 'Automatic',
            'seating_capacity' => 5,
            'rental_price_per_day' => 2200,
            'status' => 'Available',
        ]);

        $booking = Booking::create([
            'user_id' => $this->customer->id,
            'car_id' => $car->id,
            'pickup_date' => '2026-08-01',
            'return_date' => '2026-08-03',
            'total_amount' => 4400,
            'security_deposit' => 2000,
            'pickup_location' => 'Ahmedabad',
            'status' => 'Pending',
        ]);

        $response = $this->actingAs($this->admin)->post("/admin/bookings/{$booking->id}/status", [
            'status' => 'Confirmed',
        ]);

        $response->assertRedirect();
        $this->assertEquals('Confirmed', $booking->fresh()->status);
        $this->assertEquals('Booked', $car->fresh()->status);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function admin_can_approve_or_reject_customer_documents()
    {
        $doc = Document::create([
            'user_id' => $this->customer->id,
            'type' => 'Driving License',
            'file_path' => 'documents/1/test.jpg',
            'file_name' => 'test.jpg',
            'status' => 'Pending',
        ]);

        // Approve
        $response = $this->actingAs($this->admin)->post("/admin/documents/{$doc->id}/approve");
        $response->assertRedirect();
        $this->assertEquals('Approved', $doc->fresh()->status);

        // Reject
        $response = $this->actingAs($this->admin)->post("/admin/documents/{$doc->id}/reject", [
            'rejection_reason' => 'Image too blurry',
        ]);
        $response->assertRedirect();
        $this->assertEquals('Rejected', $doc->fresh()->status);
        $this->assertEquals('Image too blurry', $doc->fresh()->rejection_reason);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function admin_can_manage_vehicle_maintenance_records()
    {
        $car = Car::create([
            'brand' => 'Toyota',
            'model' => 'Fortuner',
            'year' => 2024,
            'registration_number' => 'GJ-01-TO-2222',
            'fuel_type' => 'Diesel',
            'transmission' => 'Automatic',
            'seating_capacity' => 7,
            'rental_price_per_day' => 5000,
            'status' => 'Available',
        ]);

        // Add maintenance record
        $response = $this->actingAs($this->admin)->post('/admin/maintenance', [
            'car_id' => $car->id,
            'title' => 'Oil & Filter Change',
            'cost' => 4500,
            'scheduled_date' => now()->toDateString(),
            'description' => 'Routine 10k service',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('maintenance_records', ['car_id' => $car->id, 'cost' => 4500]);
        $this->assertEquals('Maintenance', $car->fresh()->status);
    }
}
