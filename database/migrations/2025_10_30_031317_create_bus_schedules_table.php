<?php

use App\Models\BusDetail;
use App\Models\BusOperator;
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
        Schema::create('bus_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(BusOperator::class);
            $table->foreignIdFor(BusDetail::class);
            $table->unsignedInteger('from_bus_location_id')->index();
            $table->unsignedInteger('to_bus_location_id')->index();
            $table->time('departure_time')->nullable();
            $table->time('arrival_time')->nullable();
            $table->date('arrival_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bus_schedules');
    }
};
