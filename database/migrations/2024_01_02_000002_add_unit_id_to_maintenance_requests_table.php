<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // إضافة معرف الوحدة لجدول طلبات الصيانة
        Schema::table('maintenance_requests', function (Blueprint $table) {
            $table->foreignId('unit_id')->nullable()->after('property_id')->constrained()->onDelete('cascade'); // ربط بالوحدة السكنية
        });
    }

    public function down(): void
    {
        Schema::table('maintenance_requests', function (Blueprint $table) {
            $table->dropForeign(['unit_id']);
            $table->dropColumn('unit_id');
        });
    }
};
