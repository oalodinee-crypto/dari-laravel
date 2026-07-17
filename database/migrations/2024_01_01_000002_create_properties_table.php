<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // إنشاء جدول الممتلكات (العقارات العامة)
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // المالك (المستخدم)
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('type', ['apartment', 'villa', 'office', 'land', 'building'])->default('apartment'); // نوع العقار
            $table->enum('status', ['available', 'rented', 'sold', 'maintenance'])->default('available'); // حالة العقار
            $table->decimal('price', 12, 2);
            $table->decimal('area', 10, 2)->nullable();
            $table->integer('bedrooms')->nullable();
            $table->integer('bathrooms')->nullable();
            $table->string('city');
            $table->string('district')->nullable();
            $table->text('address')->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->json('features')->nullable();
            $table->json('images')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
