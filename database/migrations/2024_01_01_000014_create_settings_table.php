<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // إنشاء جدول الإعدادات
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique(); // المفتاح (للإشارة للإعداد برمجياً)
            $table->text('value')->nullable(); // القيمة
            $table->string('type')->default('string'); // نوع البيانات (نص، رقم، منطقي...)
            $table->string('group')->default('general'); // المجموعة (عام، إشعارات، ...)
            $table->string('label')->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_public')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};