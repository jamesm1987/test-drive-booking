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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->foreignId('event_id')->constrained();
            $table->foreignId('time_slot_id')->constrained()->onDelete('cascade');
            $table->foreignId('vehicle_id')->nullable()->constrained()->onDelete('cascade'); // Nullable for cases where vehicle is assigned later
            $table->timestamp('cancelled_at')->nullable();
            $table->string('name');
            $table->string('phone');
            $table->string('email');
            $table->timestamps();

            $table->unique(['event_id', 'vehicle_id', 'time_slot_id'], 'event_vehicle_timeslot_unique');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
