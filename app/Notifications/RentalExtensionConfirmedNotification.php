<?php

namespace App\Notifications;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RentalExtensionConfirmedNotification extends Notification
{
    use Queueable;

    protected Booking $booking;
    protected int $days;
    protected float $extraCost;
    protected string $paymentMsg;

    public function __construct(Booking $booking, int $days, float $extraCost, string $paymentMsg)
    {
        $this->booking = $booking;
        $this->days = $days;
        $this->extraCost = $extraCost;
        $this->paymentMsg = $paymentMsg;
    }

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject("Rental Extension Confirmed — #{$this->booking->booking_number}")
            ->greeting("Hello {$notifiable->name}!")
            ->line("Your rental trip for {$this->booking->car->brand} {$this->booking->car->model} (#{$this->booking->booking_number}) has been extended by {$this->days} day(s).")
            ->line("New Return Date: " . $this->booking->return_date->format('d M, Y'))
            ->line("Extension Amount: ₹" . number_format($this->extraCost, 0) . " ({$this->paymentMsg}).")
            ->action('View Updated Invoice & Rental Details', route('bookings.show', $this->booking->id))
            ->line('Thank you for driving with AutoLux Car Rental!');
    }

    public function toArray($notifiable): array
    {
        return [
            'booking_id' => $this->booking->id,
            'booking_number' => $this->booking->booking_number,
            'title' => 'Rental Extended! 🕒',
            'message' => "Your rental for {$this->booking->car->brand} {$this->booking->car->model} has been extended until " . $this->booking->return_date->format('d M, Y') . " (+{$this->days} day(s)).",
            'icon' => 'fa-clock-rotate-left',
            'color' => 'text-success',
            'action_url' => route('bookings.show', $this->booking->id),
        ];
    }
}
