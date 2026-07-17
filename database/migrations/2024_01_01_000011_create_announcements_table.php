<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // إنشاء جدول الإعلانات والتعاميم
        Schema::create('announcements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->foreignId('building_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('title'); // عنوان الإعلان
            $table->text('content'); // محتوى الإعلان
            $table->enum('type', ['general', 'maintenance', 'emergency', 'event', 'reminder'])->default('general'); // نوع الإعلان
            $table->enum('priority', ['low', 'medium', 'high', 'urgent'])->default('medium'); // درجة الأهمية
            $table->enum('target', ['all', 'tenants', 'owners', 'staff'])->default('all'); // الفئة المستهدفة
            $table->dateTime('publish_at')->nullable();
            $table->dateTime('expires_at')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('send_notification')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('announcements');
    }
};
