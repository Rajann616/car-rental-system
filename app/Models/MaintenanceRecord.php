<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaintenanceRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'car_id',
        'title',
        'description',
        'scheduled_date',
        'completed_date',
        'cost',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'scheduled_date' => 'date',
            'completed_date' => 'date',
            'cost' => 'decimal:2',
        ];
    }

    /**
     * Get the car for this maintenance record.
     */
    public function car()
    {
        return $this->belongsTo(Car::class);
    }

    /**
     * Get formatted cost.
     */
    public function getFormattedCostAttribute(): string
    {
        return '₹' . number_format($this->cost, 2);
    }

    /**
     * Get status badge class.
     */
    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'Scheduled' => 'info',
            'In Progress' => 'warning',
            'Completed' => 'success',
            'Cancelled' => 'danger',
            default => 'secondary',
        };
    }
}
