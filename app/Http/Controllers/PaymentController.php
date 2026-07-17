<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Invoice;
use Illuminate\Http\Request;

// تحكم المدفوعات (إدارة عمليات الدفع)
class PaymentController extends Controller
{
    // عرض قائمة المدفوعات
    public function index()
    {
        $payments = Payment::with(['invoice.contract.tenant'])->latest()->get();
        return view('payments.index', compact('payments'));
    }

    // صفحة تسجيل دفعة جديدة
    public function create()
    {
        $invoices = Invoice::where('status', '!=', 'paid')->with('contract.tenant')->get();
        return view('payments.create', compact('invoices'));
    }

    // حفظ الدفعة وتحديث حالة الفاتورة
    public function store(Request $request)
    {
        $validated = $request->validate([
            'invoice_id' => 'required|exists:invoices,id',
            'amount' => 'required|numeric|min:0',
            'method' => 'required|string',
            'payment_date' => 'required|date',
            'reference_number' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        // توليد رقم الدفعة تلقائياً
        $validated['payment_number'] = 'PAY-' . date('Ymd') . '-' . str_pad(Payment::count() + 1, 4, '0', STR_PAD_LEFT);

        $payment = Payment::create($validated);
        
        // تحديث حالة الفاتورة إذا تم سداد كامل المبلغ
        $invoice = Invoice::find($validated['invoice_id']);
        $totalPaid = Payment::where('invoice_id', $invoice->id)->sum('amount');
        if ($totalPaid >= $invoice->amount) {
            $invoice->update(['status' => 'paid']);
        }

        return redirect()->route('payments.index')->with('success', 'تم تسجيل الدفعة بنجاح');
    }

    public function show(Payment $payment)
    {
        $payment->load(['invoice.contract.tenant', 'invoice.contract.unit']);
        return view('payments.show', compact('payment'));
    }

    public function edit(Payment $payment)
    {
        $invoices = Invoice::with('contract.tenant')->get();
        return view('payments.edit', compact('payment', 'invoices'));
    }

    public function update(Request $request, Payment $payment)
    {
        $validated = $request->validate([
            'invoice_id' => 'required|exists:invoices,id',
            'amount' => 'required|numeric|min:0',
            'method' => 'required|string',
            'payment_date' => 'required|date',
            'reference_number' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $payment->update($validated);
        return redirect()->route('payments.index')->with('success', 'تم تحديث الدفعة بنجاح');
    }

    public function destroy(Payment $payment)
    {
        $payment->delete();
        return redirect()->route('payments.index')->with('success', 'تم حذف الدفعة بنجاح');
    }
}
