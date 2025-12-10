<?php

use App\Models\Location;
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
        Schema::table('bus_schedules', function(Blueprint $table) {

            // try {
            //     $table->dropForeign(['from_bus_location_id']);
            //     $table->dropForeign(['to_bus_location_id']);
            // } catch (\Exception $e) {}
            // try {
            //     $table->dropIndex(['from_bus_location_id']);
            //     $table->dropIndex(['to_bus_location_id']);
            // } catch (\Exception $e) {}

            // $table->foreignIdFor(BusLocation::class, 'from_bus_location_id')
            //    ->constrained('bus_locations')
            //    ->cascadeOnDelete()->change();
            // $table->foreignIdFor(BusLocation::class, 'to_bus_location_id')
            //    ->constrained('to_bus_location_id')
            //    ->cascadeOnDelete()->change();

            // mysql
            // $table->unsignedBigInteger('from_bus_location_id')->change();
            // $table->unsignedBigInteger('to_bus_location_id')->change();

            // pgsql
            $table->bigInteger('from_bus_location_id')->change();
            $table->bigInteger('to_bus_location_id')->change();

            $table->foreign('from_bus_location_id')
                  ->references('id')
                  ->on('bus_locations')
                  ->cascadeOnDelete();

            $table->foreign('to_bus_location_id')
                  ->references('id')
                  ->on('bus_locations')
                  ->cascadeOnDelete();

            // $table->renameColumn('arrival_date', 'schedule_date');
        });
        // Part 2: Separate the Column Rename (HIGHLY RECOMMENDED for PgSQL)
        Schema::table('bus_schedules', function(Blueprint $table) {
            $table->renameColumn('arrival_date', 'schedule_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bus_schedules', function (Blueprint $table) {
            $table->dropForeign(['from_bus_location_id']);
            $table->dropForeign(['to_bus_location_id']);

            // Restore old indexed columns (if needed)
            $table->unsignedBigInteger('from_bus_location_id')->index()->change();
            $table->unsignedBigInteger('to_bus_location_id')->index()->change();

            $table->renameColumn('schedule_date', 'arrival_date');
        });
    }
};
