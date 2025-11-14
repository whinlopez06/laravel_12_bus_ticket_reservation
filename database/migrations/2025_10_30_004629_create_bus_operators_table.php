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
        Schema::create('bus_operators', function (Blueprint $table) {
            $table->id();
            $table->string('name', 200)->unique();
            $table->string('address', 255);
            $table->string('contact_number');
            $table->string('email_address', 100);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bus_operators');
    }
};
