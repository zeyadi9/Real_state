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
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->enum('type', ['apartment', 'land']);
            $table->string('region')->nullable();
            $table->enum('finishing_status', ['finished', 'core'])->nullable();
            $table->enum('status', ['available', 'sold'])->default('available');
            $table->decimal('price', 15, 2)->nullable();
            $table->decimal('area', 10, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
