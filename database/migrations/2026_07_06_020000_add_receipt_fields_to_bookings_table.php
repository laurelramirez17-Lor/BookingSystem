<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->string('booking_reference')->nullable()->unique()->after('id');
            $table->foreignId('room_id')->nullable()->after('event_id')->constrained()->nullOnDelete();
            $table->unsignedInteger('number_of_guests')->default(1)->after('email');
            $table->decimal('total_price', 10, 2)->nullable()->after('booking_time');
            $table->string('payment_status')->default('pending')->after('total_price');
        });

        DB::table('bookings')
            ->whereNull('booking_reference')
            ->orderBy('id')
            ->get()
            ->each(function (object $booking): void {
                DB::table('bookings')
                    ->where('id', $booking->id)
                    ->update([
                        'booking_reference' => 'ARAUM-'.now()->format('Ymd').'-'.Str::upper(Str::random(6)),
                    ]);
            });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropForeign(['room_id']);
            $table->dropUnique(['booking_reference']);
            $table->dropColumn([
                'booking_reference',
                'room_id',
                'number_of_guests',
                'total_price',
                'payment_status',
            ]);
        });
    }
};
