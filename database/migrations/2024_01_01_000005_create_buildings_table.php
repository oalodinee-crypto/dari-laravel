<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // إنشاء جدول المباني
        Schema::create('buildings', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // اسم المبنى
            $table->string('code')->unique(); // رمز المبنى (فريد)
            $table->text('description')->nullable();
            $table->text('address');
            $table->string('city');
            $table->string('district')->nullable();
            $table->integer('floors_count')->default(1);
            $table->integer('units_count')->default(0);
            $table->year('year_built')->nullable();
            $table->decimal('total_area', 12, 2)->nullable();
            $table->json('amenities')->nullable(); // المرافق والخدمات
            $table->json('images')->nullable(); // صور المبنى
            $table->enum('status', ['active', 'maintenance', 'inactive'])->default('active'); // حالة المبنى
            $table->foreignId('manager_id')->nullable()->constrained('users')->onDelete('set null'); // مدير المبنى
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('buildings');
    }
};
