<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // إنشاء جدول العقود
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->string('contract_number')->unique(); // رقم العقد الفريد
            $table->foreignId('unit_id')->constrained()->onDelete('cascade'); // الوحدة المرتبطة
            $table->foreignId('tenant_id')->constrained('users')->onDelete('cascade'); // المستأجر (الطرف الثاني)
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->enum('type', ['rent', 'sale', 'lease'])->default('rent'); // نوع العقد
            $table->date('start_date'); // تاريخ البداية
            $table->date('end_date'); // تاريخ النهاية
            $table->decimal('amount', 12, 2); // قيمة العقد
            $table->enum('payment_frequency', ['monthly', 'quarterly', 'semi_annual', 'annual'])->default('monthly'); // تكرار الدفع
            $table->decimal('security_deposit', 12, 2)->default(0); // مبلغ التأمين
            $table->text('terms')->nullable(); // شروط العقد
            $table->enum('status', ['draft', 'active', 'expired', 'terminated', 'renewed'])->default('draft'); // حالة العقد
            $table->string('document')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contracts');
    }
};
