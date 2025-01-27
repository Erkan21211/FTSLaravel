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
        Schema::create('bus_planning', function (Blueprint $table) {
            $table->id();
            $table->foreignId('festival_id')->constrained('festivals')->onDelete('cascade');
            $table->foreignId('bus_id')->constrained('buses')->onDelete('cascade');
            $table->dateTime('departure_time')->nullable();
            $table->string('departure_location');
            $table->integer('available_seats');
            $table->decimal('cost_per_seat', 8, 2);
            $table->integer('seats_filled')->default(0);
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bus_planning');
    }
};
