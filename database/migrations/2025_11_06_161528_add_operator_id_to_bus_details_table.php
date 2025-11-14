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
        Schema::table('bus_details', function (Blueprint $table) {
            $table->unsignedBigInteger('bus_operator_id')->after('id');

            $table->foreign('bus_operator_id')
            ->references('id')
            ->on('bus_operators')
            ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bus_details', function (Blueprint $table) {
            $table->dropForeign(['bus_operator_id']);
        });
    }
};
