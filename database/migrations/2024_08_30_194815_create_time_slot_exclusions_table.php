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
        Schema::create('time_slot_exclusions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained();
            $table->datetime('starts_at');
            $table->datetime('ends_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('time_slot_exclusions');
    }
};
