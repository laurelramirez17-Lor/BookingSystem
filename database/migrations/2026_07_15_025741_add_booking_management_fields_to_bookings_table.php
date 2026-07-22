<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {

            // The booking fields above already exist in earlier project migrations.
            // Keep this migration additive so a fresh migration does not fail on
            // duplicate columns.
            $table->foreignId('user_id')
                ->nullable()
                ->after('room_id')
                ->constrained()
                ->nullOnDelete();

        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {

            $table->dropColumn([
                'user_id'
            ]);

        });
    }
};
