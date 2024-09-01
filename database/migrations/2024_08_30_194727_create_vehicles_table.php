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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->integer('number');
            $table->string('model');
            $table->foreignId('manufacturer_id')->constrained()->onDelete('cascade');
            $table->string('slug')->unique();
            $table->string('img_url');
            $table->string('registration')->nullable();
            $table->string('adaption_description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
