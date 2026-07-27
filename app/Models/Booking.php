<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_number',
        'user_id',
        'car_id',
        'pickup_date',
        'return_date',
        'total_amount',
        'security_deposit',
        'status',
        'pickup_location',
        'return_location',
        'notes',
        'cancelled_at',
        'cancellation_reason',
    ];

    protected function casts(): array
    {
        return [
            'pickup_date' => 'date',
            'return_date' => 'date',
            'total_amount' => 'decimal:2',
            'security_deposit' => 'decimal:2',
            'cancelled_at' => 'datetime',
        ];
    }

    /**
     * Boot method to auto-generate booking number.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($booking) {
            if (empty($booking->booking_number)) {
                $booking->booking_number = 'BK-' . strtoupper(Str::random(8));
            }
        });
    }

    /**
     * Get the user who made this booking.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the car for this booking.
     */
    public function car()
    {
        return $this->belongsTo(Car::class);
    }

    /**
     * Get the payment for this booking.
     */
    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    /**
     * Get the number of rental days.
     */
    public function getRentalDaysAttribute(): int
    {
        return $this->pickup_date->diffInDays($this->return_date);
    }

    /**
     * Get formatted total amount.
     */
    public function getFormattedTotalAttribute(): string
    {
        return '₹' . number_format($this->total_amount, 2);
    }

    /**
     * Check if booking can be cancelled (24h before pickup).
     */
    public function canBeCancelled(): bool
    {
        if (!in_array($this->status, ['Pending', 'Confirmed'])) {
            return false;
        }

        return now()->diffInHours($this->pickup_date, false) >= 24;
    }

    /**
     * Get status badge CSS class.
     */
    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'Pending' => 'warning',
            'Confirmed' => 'info',
            'Active' => 'primary',
            'Completed' => 'success',
            'Cancelled' => 'danger',
            default => 'secondary',
        };
    }

    /**
     * Scope: user's bookings.
     */
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }
}
