<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('properties');

        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->string('region')->nullable();              // المنطقة
            $table->string('finishing_status')->nullable();    // حالة الوحدة كـ تشطيب
            $table->string('neighborhood')->nullable();        // الحي
            $table->text('address')->nullable();               // العنوان بالتفصيل
            $table->string('unit_type')->nullable();           // نوع الوحدة
            $table->decimal('area_sqm', 10, 2)->nullable();   // المساحة بالمتر
            $table->unsignedSmallInteger('rooms_count')->nullable();     // عدد الغرف
            $table->unsignedSmallInteger('bathrooms_count')->nullable(); // عدد الحمام
            $table->string('project_name')->nullable();        // اسم المشروع
            $table->string('floor')->nullable();               // الطابق
            $table->decimal('price_per_sqm', 15, 2)->nullable(); // سعر المتر
            $table->decimal('total_price', 15, 2)->nullable();   // إجمالي سعر الوحدة
            $table->text('unit_details')->nullable();          // تفاصيل الوحدة والموقع
            $table->string('client_name')->nullable();         // اسم العميل
            $table->string('client_phone')->nullable();        // رقم هاتف العميل
            $table->string('status')->default('مباشر');        // الحالة: مباشر / وسيط
            $table->text('required_action')->nullable();       // الإجراء المطلوب
            $table->json('media')->nullable();                 // صور أو فيديو
            $table->string('unit_purpose')->nullable();        // الهدف من الوحدة
            $table->string('sale_status')->default('متاح');   // حالة البيع: متاح / مباع
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
