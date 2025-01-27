<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade');
            $table->foreignId('festival_id')->constrained('festivals')->onDelete('cascade');
            $table->foreignId('bus_planning_id')->constrained('bus_planning')->onDelete('cascade');
            $table->dateTime('booking_date');
            $table->decimal('cost', 8, 2);
            $table->string('status')->default('actief');
            $table->integer('points_earned')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
