<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // إنشاء جدول المستخدمين
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // الاسم الكامل
            $table->string('username')->unique()->nullable(); // اسم المستخدم (فريد)
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('phone')->nullable();
            $table->string('country')->nullable();
            $table->string('governorate')->nullable();
            $table->string('city')->nullable();
            $table->date('birthdate')->nullable(); // تاريخ الميلاد
            $table->enum('gender', ['male', 'female'])->nullable(); // الجنس (ذكر/أنثى)
            $table->string('avatar')->nullable(); // صورة الملف الشخصي
            $table->boolean('is_active')->default(true); // حالة الحساب (نشط/غير نشط)
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
