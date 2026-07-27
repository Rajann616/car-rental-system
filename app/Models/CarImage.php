<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'car_id',
        'image_path',
        'sort_order',
    ];

    /**
     * Get the car this image belongs to.
     */
    public function car()
    {
        return $this->belongsTo(Car::class);
    }
}
