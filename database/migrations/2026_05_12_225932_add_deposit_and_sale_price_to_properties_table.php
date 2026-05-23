<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->decimal('deposit', 15, 2)->nullable()->after('total_price');         // المقدم
            $table->decimal('final_sale_price', 15, 2)->nullable()->after('sale_status'); // السعر النهائي للبيع
        });
    }

    public function down(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->dropColumn(['deposit', 'final_sale_price']);
        });
    }
};
