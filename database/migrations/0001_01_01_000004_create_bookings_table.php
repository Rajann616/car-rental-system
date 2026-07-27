<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('booking_number', 20)->unique();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('car_id')->constrained()->cascadeOnDelete();
            $table->date('pickup_date');
            $table->date('return_date');
            $table->decimal('total_amount', 10, 2);
            $table->decimal('security_deposit', 10, 2)->default(0);
            $table->enum('status', ['Pending', 'Confirmed', 'Active', 'Completed', 'Cancelled'])->default('Pending');
            $table->text('pickup_location')->nullable();
            $table->text('return_location')->nullable();
            $table->text('notes')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->text('cancellation_reason')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
