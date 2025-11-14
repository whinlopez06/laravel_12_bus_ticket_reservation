<?php

use App\Models\BusOperator;
use App\Models\BusDetail;
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
        Schema::create('operator_buses', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(BusOperator:: class);
            $table->foreignIdFor(model: BusDetail::class);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('operator_buses');
    }
};
