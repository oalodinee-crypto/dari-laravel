<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // إنشاء جدول الفواتير
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number')->unique(); // رقم الفاتورة
            $table->foreignId('contract_id')->nullable()->constrained()->onDelete('set null'); // العقد المرتبط
            $table->foreignId('unit_id')->constrained()->onDelete('cascade'); // الوحدة
            $table->foreignId('tenant_id')->constrained('users')->onDelete('cascade'); // المستأجر (الملزم بالدفع)
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade'); // منشئ الفاتورة
            $table->enum('type', ['rent', 'maintenance', 'utilities', 'other'])->default('rent'); // نوع الفاتورة
            $table->string('description'); // الوصف
            $table->decimal('amount', 12, 2); // المبلغ الصافي
            $table->decimal('tax_amount', 12, 2)->default(0); // قيمة الضريبة
            $table->decimal('total_amount', 12, 2); // المبلغ الإجمالي
            $table->date('issue_date'); // تاريخ الإصدار
            $table->date('due_date'); // تاريخ الاستحقاق
            $table->enum('status', ['pending', 'paid', 'partial', 'overdue', 'cancelled'])->default('pending'); // حالة الدفع
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
