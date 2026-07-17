<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // إنشاء جدول المستندات والوثائق
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('uploaded_by')->constrained('users')->onDelete('cascade'); // الموظف الذي رفع الملف
            $table->nullableMorphs('documentable'); // الكائن المرتبط (عقد، وحدة، إلخ)
            $table->string('title'); // عنوان المستند
            $table->string('file_path'); // مسار الملف
            $table->string('file_name'); // اسم الملف الأصلي
            $table->string('file_type'); // نوع الملف
            $table->integer('file_size'); // حجم الملف
            $table->enum('category', ['contract', 'invoice', 'receipt', 'identity', 'maintenance', 'other'])->default('other'); // تصنيف المستند
            $table->text('description')->nullable(); // الوصف
            $table->boolean('is_private')->default(false); // سري/خاص
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
