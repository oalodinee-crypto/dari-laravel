<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('building_types', function (Blueprint $table) {
            $table->id();

            // علاقة مع building_categories
            $table->foreignId('category_id')
                  ->constrained('building_categories')
                  ->cascadeOnDelete();

            $table->string('name_ar'); // مثال: عمارة، فيلا...
            $table->string('name_en')->nullable(); // Apartment Building, Villa...

            $table->unsignedInteger('sort_order')->default(0);

            // يمنع التكرار داخل نفس الفئة
            $table->unique(['category_id', 'name_ar']);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('building_types');
    }
};
