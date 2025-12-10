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
        Schema::table('bus_schedules', function (Blueprint $table) {
            // Drop the existing TIME column
            $table->dropColumn('travel_duration');

            // Add a new VARCHAR column with the same name
            $table->integer(column: 'travel_duration')->nullable()->after('boarding_time');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bus_schedules', function (Blueprint $table) {
            // Drop the string column
            $table->dropColumn('travel_duration');

            // Recreate the original TIME column
            $table->time('travel_duration')->nullable()->after('boarding_time');
        });
    }
};
