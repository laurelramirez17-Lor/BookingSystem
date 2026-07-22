<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('rooms', function (Blueprint $table) {
            $table->string('room_type')->nullable()->after('name');
            $table->text('amenities')->nullable()->after('description');
            $table->unsignedInteger('max_guests')->default(2)->after('price_max');
        });
    }

    public function down(): void
    {
        Schema::table('rooms', function (Blueprint $table) {
            $table->dropColumn(['room_type', 'amenities', 'max_guests']);
        });
    }
};
