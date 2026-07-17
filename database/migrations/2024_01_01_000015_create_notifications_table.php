<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // إنشاء جدول الإشعارات
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // المستخدم المستهدف
            $table->string('type'); // نوع الإشعار
            $table->string('title'); // العنوان
            $table->text('message'); // النص
            $table->json('data')->nullable(); // بيانات إضافية
            $table->string('action_url')->nullable(); // رابط الإجراء
            $table->timestamp('read_at')->nullable(); // وقت القراءة
            $table->timestamps();
            
            $table->index(['user_id', 'read_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
