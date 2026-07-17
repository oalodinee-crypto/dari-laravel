<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // إنشاء جدول الرسائل
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sender_id')->constrained('users')->onDelete('cascade'); // المرسل
            $table->foreignId('receiver_id')->constrained('users')->onDelete('cascade'); // المستقبل
            $table->string('subject')->nullable(); // الموضوع
            $table->text('body'); // نص الرسالة
            $table->boolean('is_read')->default(false); // تمت القراءة؟
            $table->timestamp('read_at')->nullable(); // وقت القراءة
            $table->foreignId('parent_id')->nullable()->constrained('messages')->onDelete('cascade'); // الرسالة الأصلية (في حال الرد)
            $table->enum('type', ['general', 'maintenance', 'complaint', 'payment', 'contract'])->default('general'); // نوع الرسالة
            $table->unsignedBigInteger('related_id')->nullable(); // معرف الكائن المرتبط
            $table->timestamps();
            
            $table->index(['sender_id', 'receiver_id']);
            $table->index(['receiver_id', 'is_read']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
