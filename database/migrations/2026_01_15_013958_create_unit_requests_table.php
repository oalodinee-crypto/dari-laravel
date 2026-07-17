<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // إنشاء جدول طلبات الوحدات (طلبات السكان)
        Schema::create('unit_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // مقدم الطلب
            $table->foreignId('building_id')->nullable()->constrained()->onDelete('set null'); // المبنى المطلوب (اختياري)
            $table->string('unit_type')->nullable(); // نوع الوحدة المطلوبة
            $table->integer('rooms_count')->nullable(); // عدد الغرف
            $table->decimal('budget_min', 10, 2)->nullable(); // الحد الأدنى للميزانية
            $table->decimal('budget_max', 10, 2)->nullable(); // الحد الأقصى للميزانية
            $table->text('notes')->nullable(); // ملاحظات إضافية
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending'); // حالة الطلب
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->onDelete('set null'); // المراجع
            $table->text('admin_notes')->nullable(); // ملاحظات الإدارة
            $table->timestamp('reviewed_at')->nullable(); // وقت المراجعة
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('unit_requests');
    }
};