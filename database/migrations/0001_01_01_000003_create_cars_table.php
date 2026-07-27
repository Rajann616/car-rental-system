<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->string('brand', 100);
            $table->string('model', 100);
            $table->year('year');
            $table->string('registration_number', 20)->unique();
            $table->enum('fuel_type', ['Petrol', 'Diesel', 'Electric', 'Hybrid', 'CNG']);
            $table->enum('transmission', ['Manual', 'Automatic']);
            $table->unsignedTinyInteger('seating_capacity')->default(5);
            $table->decimal('rental_price_per_day', 10, 2);
            $table->text('description')->nullable();
            $table->json('features')->nullable();
            $table->enum('status', ['Available', 'Booked', 'Rented', 'Maintenance'])->default('Available');
            $table->string('thumbnail')->nullable();
            $table->timestamps();
        });

        Schema::create('car_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('car_id')->constrained()->cascadeOnDelete();
            $table->string('image_path');
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('car_images');
        Schema::dropIfExists('cars');
    }
};
