<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Bus;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bus_details', function (Blueprint $table) {
            $table->id();
            // $table->foreignIdFor(Bus::class);
            $table->unsignedBigInteger('bus_id');
            $table->string('description', 200);
            $table->string('plate_number')->nullable();
            $table->integer('seat_capacity')->nullable()->default(0);
            $table->timestamps();

            $table->foreign('bus_id')
            ->references('id')
            ->on('buses')
            ->cascadeOnDelete();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bus_details');
    }
};
