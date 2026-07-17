<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // إضافة نوع المبنى إلى جدول المباني
        Schema::table('buildings', function (Blueprint $table) {
            $table->string('building_type')->nullable(); // نوع المبنى (سكني، تجاري، إلخ)
        });
    }

    public function down(): void
    {
        Schema::table('buildings', function (Blueprint $table) {
            $table->dropColumn('building_type');
        });
    }
};
