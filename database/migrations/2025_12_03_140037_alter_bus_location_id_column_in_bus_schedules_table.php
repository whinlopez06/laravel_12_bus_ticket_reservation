<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("
            ALTER TABLE bus_schedules
            CHANGE from_bus_location_id from_location_id BIGINT UNSIGNED NOT NULL,
            CHANGE to_bus_location_id to_location_id BIGINT UNSIGNED NOT NULL
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("
            ALTER TABLE bus_schedules
            CHANGE from_location_id from_bus_location_id BIGINT UNSIGNED NOT NULL,
            CHANGE to_location_id to_bus_location_id BIGINT UNSIGNED NOT NULL
        ");
    }
};
