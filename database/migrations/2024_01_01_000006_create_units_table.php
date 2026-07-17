<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // إنشاء جدول الوحدات السكنية
        Schema::create('units', function (Blueprint $table) {
            $table->id();
            $table->foreignId('building_id')->constrained()->onDelete('cascade'); // المبنى التابع له
            $table->foreignId('tenant_id')->nullable()->constrained('users')->onDelete('set null'); // المستأجر الحالي (إن وجد)
            $table->string('unit_number');
            $table->integer('floor_number');
            $table->enum('type', ['apartment', 'studio', 'office', 'shop', 'storage'])->default('apartment');
            $table->decimal('area', 10, 2)->nullable();
            $table->integer('bedrooms')->default(0);
            $table->integer('bathrooms')->default(0);
            $table->decimal('rent_amount', 12, 2)->nullable(); // قيمة الإيجار
            $table->enum('status', ['available', 'occupied', 'maintenance', 'reserved'])->default('available'); // حالة الوحدة
            $table->date('lease_start')->nullable();
            $table->date('lease_end')->nullable();
            $table->json('features')->nullable();
            $table->json('images')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->unique(['building_id', 'unit_number']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('units');
    }
};
