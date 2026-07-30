<?php

namespace Tests\Unit;

use App\Models\User;
use App\Models\Car;
use App\Models\Booking;
use App\Models\Document;
use App\Notifications\BookingConfirmedNotification;
use App\Notifications\BookingStatusNotification;
use App\Notifications\DocumentStatusNotification;
use App\Notifications\AdminNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NotificationsUnitTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected Booking $booking;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::create([
            'name' => 'Notif Test User',
            'email' => 'notiftest@example.com',
            'password' => bcrypt('password123'),
            'role' => 'customer',
        ]);

        $car = Car::create([
            'brand' => 'Honda',
            'model' => 'City',
            'year' => 2024,
            'registration_number' => 'GJ-01-HO-3333',
            'fuel_type' => 'Petrol',
            'transmission' => 'Automatic',
            'seating_capacity' => 5,
            'rental_price_per_day' => 2000,
            'status' => 'Available',
        ]);

        $this->booking = Booking::create([
            'user_id' => $this->user->id,
            'car_id' => $car->id,
            'pickup_date' => '2026-08-01',
            'return_date' => '2026-08-03',
            'total_amount' => 6000,
            'security_deposit' => 2000,
            'pickup_location' => 'Ahmedabad',
            'status' => 'Confirmed',
        ]);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function booking_confirmed_notification_returns_expected_array()
    {
        $notif = new BookingConfirmedNotification($this->booking);
        $array = $notif->toArray($this->user);

        $this->assertEquals($this->booking->id, $array['booking_id']);
        $this->assertEquals('Booking Confirmed! 🎉', $array['title']);
        $this->assertStringContainsString($this->booking->booking_number, $array['message']);
        $this->assertEquals(['database'], $notif->via($this->user));
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function document_status_notification_returns_expected_array()
    {
        $doc = Document::create([
            'user_id' => $this->user->id,
            'type' => 'Aadhaar Card',
            'file_path' => 'documents/1/aadhaar.jpg',
            'file_name' => 'aadhaar.jpg',
            'status' => 'Approved',
        ]);

        $notif = new DocumentStatusNotification($doc);
        $array = $notif->toArray($this->user);

        $this->assertStringContainsString('Document Approved!', $array['title']);
        $this->assertEquals('text-success', $array['color']);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function admin_notification_returns_expected_array()
    {
        $notif = new AdminNotification('New Alert 🔔', 'Something happened', 'http://localhost/admin', 'fa-bell', 'text-info');
        $array = $notif->toArray($this->user);

        $this->assertEquals('New Alert 🔔', $array['title']);
        $this->assertEquals('http://localhost/admin', $array['action_url']);
    }
}
