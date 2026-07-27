<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    protected $fillable = [
        'brand',
        'model',
        'year',
        'registration_number',
        'fuel_type',
        'transmission',
        'seating_capacity',
        'rental_price_per_day',
        'description',
        'features',
        'status',
        'thumbnail',
    ];

    protected function casts(): array
    {
        return [
            'features' => 'array',
            'rental_price_per_day' => 'decimal:2',
        ];
    }

    /**
     * Get car images.
     */
    public function images()
    {
        return $this->hasMany(CarImage::class)->orderBy('sort_order');
    }

    /**
     * Get car bookings.
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * Get maintenance records.
     */
    public function maintenanceRecords()
    {
        return $this->hasMany(MaintenanceRecord::class);
    }

    /**
     * Check if car is available for given dates.
     */
    public function isAvailableForDates($pickupDate, $returnDate): bool
    {
        if ($this->status !== 'Available') {
            return false;
        }

        return !$this->bookings()
            ->whereIn('status', ['Confirmed', 'Active'])
            ->where(function ($query) use ($pickupDate, $returnDate) {
                $query->whereBetween('pickup_date', [$pickupDate, $returnDate])
                    ->orWhereBetween('return_date', [$pickupDate, $returnDate])
                    ->orWhere(function ($q) use ($pickupDate, $returnDate) {
                        $q->where('pickup_date', '<=', $pickupDate)
                          ->where('return_date', '>=', $returnDate);
                    });
            })
            ->exists();
    }

    /**
     * Get formatted price.
     */
    public function getFormattedPriceAttribute(): string
    {
        return '₹' . number_format($this->rental_price_per_day, 0);
    }

    /**
     * Get display name.
     */
    public function getDisplayNameAttribute(): string
    {
        return $this->brand . ' ' . $this->model . ' (' . $this->year . ')';
    }

    /**
     * Scope: only available cars.
     */
    public function scopeAvailable($query)
    {
        return $query->where('status', 'Available');
    }

    /**
     * Scope: filter by brand.
     */
    public function scopeByBrand($query, $brand)
    {
        return $query->where('brand', $brand);
    }

    /**
     * Scope: filter by fuel type.
     */
    public function scopeByFuelType($query, $fuelType)
    {
        return $query->where('fuel_type', $fuelType);
    }

    /**
     * Scope: filter by transmission.
     */
    public function scopeByTransmission($query, $transmission)
    {
        return $query->where('transmission', $transmission);
    }

    /**
     * Scope: filter by price range.
     */
    public function scopeByPriceRange($query, $min, $max)
    {
        return $query->whereBetween('rental_price_per_day', [$min, $max]);
    }
}
