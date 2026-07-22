<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->string('booking_status')->default('pending')->after('payment_status');
            $table->index(['room_id', 'booking_date', 'checkout_date']);
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropIndex(['room_id', 'booking_date', 'checkout_date']);
            $table->dropColumn('booking_status');
        });
    }
};
