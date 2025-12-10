<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::rename('bus_schedule_bookings', 'bus_schedule_reservations');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::rename('bus_schedule_reservations', 'bus_schedule_bookings');
    }
};
