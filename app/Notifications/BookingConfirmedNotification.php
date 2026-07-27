<?php

namespace App\Notifications;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class BookingConfirmedNotification extends Notification
{
    use Queueable;

    protected Booking $booking;

    public function __construct(Booking $booking)
    {
        $this->booking = $booking;
    }

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toArray($notifiable): array
    {
        return [
            'booking_id' => $this->booking->id,
            'booking_number' => $this->booking->booking_number,
            'title' => 'Booking Confirmed!',
            'message' => "Your reservation #{$this->booking->booking_number} for {$this->booking->car->brand} {$this->booking->car->model} is confirmed.",
            'action_url' => route('bookings.show', $this->booking->id),
        ];
    }
}
