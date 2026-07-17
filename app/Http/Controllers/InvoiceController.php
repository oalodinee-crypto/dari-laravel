<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Contract;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Http\Request;

// تحكم الفواتير (إدارة الفواتير والمدفوعات)
class InvoiceController extends Controller
{
    // عرض قائمة الفواتير والإحصائيات
    public function index()
    {
        $invoices = Invoice::with(['unit.building', 'tenant'])->latest()->paginate(15);
        $stats = [
            'total' => Invoice::sum('total_amount'),
            'paid' => Invoice::where('status', 'paid')->sum('total_amount'),
            'pending' => Invoice::where('status', 'pending')->sum('total_amount'),
            'overdue' => Invoice::where('status', 'overdue')->sum('total_amount'),
        ];
        return view('invoices.index', compact('invoices', 'stats'));
    }

    // إنشاء فاتورة جديدة
    public function create()
    {
        $units = Unit::with(['building', 'tenant'])->where('status', 'occupied')->get();
        $contracts = Contract::where('status', 'active')->get();
        return view('invoices.create', compact('units', 'contracts'));
    }

    // حفظ الفاتورة
    public function store(Request $request)
    {
        $validated = $request->validate([
            'unit_id' => 'required|exists:units,id',
            'contract_id' => 'nullable|exists:contracts,id',
            'type' => 'required|in:rent,maintenance,utilities,other',
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'tax_amount' => 'nullable|numeric|min:0',
            'issue_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:issue_date',
        ]);

        $unit = Unit::find($validated['unit_id']);
        
        // التحقق من وجود مستأجر للوحدة
        if (empty($unit->tenant_id)) {
            return back()->withErrors(['unit_id' => 'هذه الوحدة ليس لها مستأجر. يرجى تعيين مستأجر للوحدة أولاً.'])->withInput();
        }
        
        $validated['tenant_id'] = $unit->tenant_id;
        $validated['created_by'] = auth()->id();
        $validated['invoice_number'] = 'INV-' . date('Y') . '-' . str_pad(Invoice::count() + 1, 6, '0', STR_PAD_LEFT);
        $validated['total_amount'] = $validated['amount'] + ($validated['tax_amount'] ?? 0);

        $invoice = Invoice::create($validated);
        return redirect()->route('invoices.show', $invoice)->with('success', 'تم إنشاء الفاتورة بنجاح');
    }

    // عرض تفاصيل الفاتورة
    public function show(Invoice $invoice)
    {
        $invoice->load(['unit.building', 'tenant', 'contract', 'payments']);
        return view('invoices.show', compact('invoice'));
    }

    public function edit(Invoice $invoice)
    {
        $units = Unit::with(['building', 'tenant'])->get();
        return view('invoices.edit', compact('invoice', 'units'));
    }

    public function update(Request $request, Invoice $invoice)
    {
        $validated = $request->validate([
            'type' => 'required|in:rent,maintenance,utilities,other',
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'tax_amount' => 'nullable|numeric|min:0',
            'due_date' => 'required|date',
            'status' => 'required|in:pending,paid,partial,overdue,cancelled',
        ]);

        $validated['total_amount'] = $validated['amount'] + ($validated['tax_amount'] ?? 0);
        $invoice->update($validated);
        return redirect()->route('invoices.show', $invoice)->with('success', 'تم تحديث الفاتورة بنجاح');
    }

    public function destroy(Invoice $invoice)
    {
        $invoice->delete();
        return redirect()->route('invoices.index')->with('success', 'تم حذف الفاتورة بنجاح');
    }
}