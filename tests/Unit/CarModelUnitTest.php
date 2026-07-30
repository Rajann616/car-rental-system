<?php

namespace Tests\Unit;

use App\Models\Car;
use App\Models\User;
use App\Models\Booking;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CarModelUnitTest extends TestCase
{
    use RefreshDatabase;

    #[\PHPUnit\Framework\Attributes\Test]
    public function user_role_helper_methods_work_correctly()
    {
        $customer = new User(['role' => 'customer']);
        $admin = new User(['role' => 'admin']);

        $this->assertTrue($customer->isCustomer());
        $this->assertFalse($customer->isAdmin());

        $this->assertTrue($admin->isAdmin());
        $this->assertFalse($admin->isCustomer());
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function car_availability_check_identifies_conflicting_dates()
    {
        $car = Car::create([
            'brand' => 'Hyundai',
            'model' => 'Creta',
            'year' => 2024,
            'registration_number' => 'GJ-01-CR-9999',
            'fuel_type' => 'Petrol',
            'transmission' => 'Automatic',
            'seating_capacity' => 5,
            'rental_price_per_day' => 2500,
            'status' => 'Available',
        ]);

        $user = User::create([
            'name' => 'Test User',
            'email' => 'unit@test.com',
            'password' => bcrypt('password'),
            'role' => 'customer',
        ]);

        // Create booking for dates 2026-08-01 to 2026-08-05
        Booking::create([
            'user_id' => $user->id,
            'car_id' => $car->id,
            'pickup_date' => '2026-08-01',
            'return_date' => '2026-08-05',
            'total_amount' => 12000,
            'security_deposit' => 2000,
            'pickup_location' => 'Ahmedabad',
            'status' => 'Confirmed',
        ]);

        // Same dates should conflict
        $this->assertFalse($car->isAvailableForDates('2026-08-01', '2026-08-05'));
        // Overlapping dates should conflict
        $this->assertFalse($car->isAvailableForDates('2026-08-03', '2026-08-07'));
        // Non-overlapping dates should be available
        $this->assertTrue($car->isAvailableForDates('2026-08-10', '2026-08-15'));
    }
}
