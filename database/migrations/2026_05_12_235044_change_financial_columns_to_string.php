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
        Schema::table('properties', function (Blueprint $table) {
            $table->string('area_sqm')->nullable()->change();
            $table->string('price_per_sqm')->nullable()->change();
            $table->string('total_price')->nullable()->change();
            $table->string('deposit')->nullable()->change();
            $table->string('final_sale_price')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->double('area_sqm')->nullable()->change();
            $table->double('price_per_sqm')->nullable()->change();
            $table->double('total_price')->nullable()->change();
            $table->double('deposit')->nullable()->change();
            $table->double('final_sale_price')->nullable()->change();
        });
    }
};
