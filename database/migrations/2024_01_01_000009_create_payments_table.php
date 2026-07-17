<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // إنشاء جدول المدفوعات (السندات)
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('payment_number')->unique(); // رقم عملية الدفع
            $table->foreignId('invoice_id')->constrained()->onDelete('cascade'); // الفاتورة المسددة
            $table->foreignId('tenant_id')->constrained('users')->onDelete('cascade'); // القائم بالدفع
            $table->foreignId('received_by')->nullable()->constrained('users')->onDelete('set null');
            $table->decimal('amount', 12, 2); // المبلغ المدفوع
            $table->enum('method', ['cash', 'bank_transfer', 'card', 'check', 'online'])->default('cash'); // طريقة الدفع
            $table->string('reference_number')->nullable(); // رقم مرجعي (مثل رقم الشيك أو التحويل)
            $table->date('payment_date'); // تاريخ السداد
            $table->enum('status', ['pending', 'completed', 'failed', 'refunded'])->default('completed'); // حالة العملية
            $table->text('notes')->nullable();
            $table->string('receipt')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
