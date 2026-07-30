<?php

namespace App\Notifications;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class BookingStatusNotification extends Notification
{
    use Queueable;

    protected Booking $booking;
    protected string $eventTitle;
    protected string $eventMessage;
    protected string $icon;
    protected string $color;

    public function __construct(Booking $booking, string $eventTitle, string $eventMessage, string $icon = 'fa-car', string $color = 'text-primary')
    {
        $this->booking = $booking;
        $this->eventTitle = $eventTitle;
        $this->eventMessage = $eventMessage;
        $this->icon = $icon;
        $this->color = $color;
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
            'title' => $this->eventTitle,
            'message' => $this->eventMessage,
            'icon' => $this->icon,
            'color' => $this->color,
            'action_url' => route('bookings.show', $this->booking->id),
        ];
    }
}
