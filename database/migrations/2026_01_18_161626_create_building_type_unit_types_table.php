<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('building_type_unit_types', function (Blueprint $table) {
            $table->id();

            $table->foreignId('building_type_id')
                  ->constrained('building_types')
                  ->cascadeOnDelete();

            $table->foreignId('unit_type_id')
                  ->constrained('unit_types')
                  ->cascadeOnDelete();

            // يمنع تكرار نفس الربط
            $table->unique(['building_type_id', 'unit_type_id']);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('building_type_unit_types');
    }
};
