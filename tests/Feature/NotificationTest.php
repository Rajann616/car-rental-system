<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Car;
use App\Models\Booking;
use App\Notifications\BookingConfirmedNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NotificationTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected Booking $booking;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::create([
            'name' => 'Notification User',
            'email' => 'notif@example.com',
            'password' => bcrypt('password123'),
            'role' => 'customer',
        ]);

        $car = Car::create([
            'brand' => 'Tata',
            'model' => 'Harrier',
            'year' => 2024,
            'registration_number' => 'GJ-01-TA-8888',
            'fuel_type' => 'Diesel',
            'transmission' => 'Automatic',
            'seating_capacity' => 5,
            'rental_price_per_day' => 2800,
            'status' => 'Available',
        ]);

        $this->booking = Booking::create([
            'user_id' => $this->user->id,
            'car_id' => $car->id,
            'pickup_date' => '2026-08-01',
            'return_date' => '2026-08-04',
            'total_amount' => 8400,
            'security_deposit' => 2000,
            'pickup_location' => 'Ahmedabad Airport',
            'status' => 'Confirmed',
        ]);

        // Send a test database notification to user
        $this->user->notify(new BookingConfirmedNotification($this->booking));
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function user_can_mark_single_notification_as_read_and_redirect()
    {
        $notification = $this->user->unreadNotifications->first();
        $this->assertNotNull($notification);

        $response = $this->actingAs($this->user)->post("/notifications/{$notification->id}/read");
        
        $response->assertRedirect(route('bookings.show', $this->booking->id));
        $this->assertEquals(0, $this->user->fresh()->unreadNotifications->count());
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function user_can_mark_all_notifications_as_read()
    {
        $this->assertEquals(1, $this->user->unreadNotifications->count());

        $response = $this->actingAs($this->user)->post('/notifications/read-all');
        $response->assertRedirect();

        $this->assertEquals(0, $this->user->fresh()->unreadNotifications->count());
    }
}
