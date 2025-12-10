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
        // requires composer doctrine/dbal
        // Schema::table('bus_schedules', function (Blueprint $table) {
        //     $table->renameColumn('departure_time', 'boarding_time');
        //     $table->renameColumn('arrival_time', 'travel_duration');
        //     $table->renameColumn('schedule_date', 'travel_date');
        // });

        DB::statement('ALTER TABLE bus_schedules RENAME COLUMN departure_time TO boarding_time');
        DB::statement('ALTER TABLE bus_schedules RENAME COLUMN arrival_time TO travel_duration');
        DB::statement('ALTER TABLE bus_schedules RENAME COLUMN schedule_date TO travel_date');

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
