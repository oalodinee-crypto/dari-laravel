<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // إنشاء جدول الشكاوى والمقترحات
        Schema::create('complaints', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('description');
            $table->enum('type', ['complaint', 'suggestion'])->default('complaint'); // نوع التذكرة (شكوى / اقتراح)
            $table->enum('priority', ['low', 'medium', 'high'])->default('medium'); // الأولوية
            $table->enum('status', ['pending', 'in_progress', 'resolved', 'closed'])->default('pending'); // الحالة
            $table->text('response')->nullable();
            $table->timestamps();
            
            $table->index(['user_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('complaints');
    }
};
