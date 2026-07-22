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

            // Foreign key to events
            $table->foreignId('event_id')->constrained()->onDelete('cascade');

            // Booking details
            $table->string('customer_name');
            $table->string('email');
            $table->date('booking_date');
            $table->time('booking_time');

            // File upload (confirmation)
            $table->string('confirmation_file')->nullable();

            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};