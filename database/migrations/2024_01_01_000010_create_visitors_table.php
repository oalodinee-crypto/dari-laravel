<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // إنشاء جدول الزيارات
        Schema::create('visitors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('unit_id')->constrained()->onDelete('cascade');
            $table->foreignId('tenant_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null');
            $table->string('visitor_name'); // اسم الزائر
            $table->string('visitor_id_number')->nullable();
            $table->string('visitor_phone')->nullable();
            $table->string('vehicle_number')->nullable();
            $table->text('purpose')->nullable(); // الغرض من الزيارة
            $table->dateTime('expected_arrival'); // وقت الوصول المتوقع
            $table->dateTime('actual_arrival')->nullable(); // وقت الوصول الفعلي
            $table->dateTime('departure_time')->nullable(); // وقت المغادرة
            $table->enum('status', ['pending', 'approved', 'rejected', 'arrived', 'departed'])->default('pending'); // حالة الطلب
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('visitors');
    }
};
