<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Car;
use App\Models\Booking;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CustomerBookingTest extends TestCase
{
    use RefreshDatabase;

    protected User $customer;
    protected Car $car;

    protected function setUp(): void
    {
        parent::setUp();

        $this->customer = User::create([
            'name' => 'Rai Rajan',
            'email' => 'rajan@example.com',
            'phone' => '9876543210',
            'password' => bcrypt('password123'),
            'role' => 'customer',
        ]);

        $this->car = Car::create([
            'brand' => 'Mahindra',
            'model' => 'Thar',
            'year' => 2024,
            'registration_number' => 'GJ-01-TH-7777',
            'fuel_type' => 'Diesel',
            'transmission' => 'Manual',
            'seating_capacity' => 4,
            'rental_price_per_day' => 3500,
            'status' => 'Available',
        ]);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function customer_can_view_booking_checkout_confirmation_page()
    {
        $today = now()->format('Y-m-d');
        $futureDate = now()->addDays(2)->format('Y-m-d');
        $response = $this->actingAs($this->customer)->get("/customer/bookings/create/{$this->car->id}?pickup_location=Iskcon+Cross+Roads&pickup_date={$today}&return_date={$futureDate}");

        $response->assertStatus(200);
        $response->assertSee('Delivery Address');
        $response->assertSee('Proceed to Secure Payment');
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function customer_booking_creation_fails_with_invalid_validation_data()
    {
        $response = $this->actingAs($this->customer)->post('/customer/bookings', [
            'car_id' => $this->car->id,
            // Missing pickup_date, return_date, total_amount, etc.
        ]);

        $response->assertSessionHasErrors(['pickup_date', 'return_date', 'pickup_location', 'razorpay_payment_id', 'razorpay_order_id']);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function customer_booking_creation_redirects_to_success_page()
    {
        $bookingData = [
            'car_id' => $this->car->id,
            'pickup_date' => '2026-08-10',
            'return_date' => '2026-08-12',
            'pickup_location' => 'SG Highway, Ahmedabad',
            'total_amount' => 9000,
            'security_deposit' => 2000,
            'razorpay_payment_id' => 'pay_demo_test123',
            'razorpay_order_id' => 'order_demo_test123',
            'razorpay_signature' => 'dummy_sig',
        ];

        $response = $this->actingAs($this->customer)->post('/customer/bookings', $bookingData);

        $booking = Booking::first();
        $this->assertNotNull($booking);
        $response->assertRedirect("/bookings/{$booking->id}/success");
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function customer_can_view_payment_success_screen()
    {
        $booking = Booking::create([
            'user_id' => $this->customer->id,
            'car_id' => $this->car->id,
            'pickup_date' => '2026-08-10',
            'return_date' => '2026-08-12',
            'total_amount' => 9000,
            'security_deposit' => 2000,
            'pickup_location' => 'SG Highway, Ahmedabad',
            'status' => 'Confirmed',
        ]);

        $response = $this->actingAs($this->customer)->get("/bookings/{$booking->id}/success");
        $response->assertStatus(200);
        $response->assertSee('Payment Successful!');
        $response->assertSee($booking->booking_number);
        $response->assertSee('View Invoice');
        $response->assertSee('Go to Dashboard');
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function customer_can_view_invoice_page()
    {
        $booking = Booking::create([
            'user_id' => $this->customer->id,
            'car_id' => $this->car->id,
            'pickup_date' => '2026-08-10',
            'return_date' => '2026-08-12',
            'total_amount' => 9000,
            'security_deposit' => 2000,
            'pickup_location' => 'SG Highway, Ahmedabad',
            'status' => 'Confirmed',
        ]);

        $response = $this->actingAs($this->customer)->get("/bookings/{$booking->id}");
        $response->assertStatus(200);
        $response->assertSee('RENTAL INVOICE');
        $response->assertSee('Vehicle Delivery Address');
        $response->assertSee('Drive safely and return the vehicle on time.');
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function customer_cannot_view_another_customers_booking_invoice()
    {
        $otherUser = User::create([
            'name' => 'Other User',
            'email' => 'other@example.com',
            'password' => bcrypt('password123'),
            'role' => 'customer',
        ]);

        $booking = Booking::create([
            'user_id' => $otherUser->id,
            'car_id' => $this->car->id,
            'pickup_date' => '2026-08-10',
            'return_date' => '2026-08-12',
            'total_amount' => 9000,
            'security_deposit' => 2000,
            'pickup_location' => 'SG Highway, Ahmedabad',
            'status' => 'Confirmed',
        ]);

        $response = $this->actingAs($this->customer)->get("/bookings/{$booking->id}");
        $response->assertStatus(403);
    }
}
