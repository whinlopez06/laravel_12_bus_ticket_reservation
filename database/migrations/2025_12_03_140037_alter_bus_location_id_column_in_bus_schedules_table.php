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
        // DB::statement("
        //     ALTER TABLE bus_schedules
        //     CHANGE from_bus_location_id from_location_id BIGINT UNSIGNED NOT NULL,
        //     CHANGE to_bus_location_id to_location_id BIGINT UNSIGNED NOT NULL
        // ");
        // DB::statement("
        //     ALTER TABLE bus_schedules
        //     RENAME COLUMN from_bus_location_id TO from_location_id;
        //     ALTER TABLE bus_schedules
        //     RENAME COLUMN to_bus_location_id TO to_location_id;
        // ");

        // Rename first column
        Schema::table('bus_schedules', function (Blueprint $table) {
            $table->renameColumn('from_bus_location_id', 'from_location_id');
        });

        // Rename second column
        Schema::table('bus_schedules', function (Blueprint $table) {
            $table->renameColumn('to_bus_location_id', 'to_location_id');
        });

        // Change column types if needed
        Schema::table('bus_schedules', function (Blueprint $table) {
            $table->bigInteger('from_location_id')->change();
            $table->bigInteger('to_location_id')->change();
        });
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
