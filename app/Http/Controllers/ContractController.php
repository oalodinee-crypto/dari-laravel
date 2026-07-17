<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Http\Request;

// تحكم العقود (إدارة عقود الإيجار والبيع)
class ContractController extends Controller
{
    public function index()
    {
        $contracts = Contract::with(['unit.building', 'tenant'])->latest()->paginate(15);
        return view('contracts.index', compact('contracts'));
    }

    public function create()
    {
        $units = Unit::with('building')->where('status', 'available')->get();
        $tenants = User::role('Resident')->get();
        return view('contracts.create', compact('units', 'tenants'));
    }

    // إنشاء عقد جديد
    public function store(Request $request)
    {
        $validated = $request->validate([
            'unit_id' => 'required|exists:units,id',
            'tenant_id' => 'required|exists:users,id',
            'type' => 'required|in:rent,sale,lease',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'amount' => 'required|numeric|min:0',
            'payment_frequency' => 'required|in:monthly,quarterly,semi_annual,annual',
            'security_deposit' => 'nullable|numeric|min:0',
            'terms' => 'nullable|string',
            'status' => 'required|in:draft,active,expired,terminated,renewed',
        ]);

        $validated['contract_number'] = 'CNT-' . date('Y') . '-' . str_pad(Contract::count() + 1, 5, '0', STR_PAD_LEFT);
        $validated['created_by'] = auth()->id();
        
        $contract = Contract::create($validated);
        
        // Update unit status
        Unit::find($validated['unit_id'])->update([
            'status' => 'occupied',
            'tenant_id' => $validated['tenant_id'],
            'lease_start' => $validated['start_date'],
            'lease_end' => $validated['end_date'],
        ]);

        return redirect()->route('contracts.show', $contract)->with('success', 'تم إنشاء العقد بنجاح');
    }

    public function show(Contract $contract)
    {
        $contract->load(['unit.building', 'tenant', 'createdBy', 'invoices']);
        return view('contracts.show', compact('contract'));
    }

    public function edit(Contract $contract)
    {
        $units = Unit::with('building')->get();
        $tenants = User::role('Resident')->get();
        return view('contracts.edit', compact('contract', 'units', 'tenants'));
    }

    public function update(Request $request, Contract $contract)
    {
        $validated = $request->validate([
            'type' => 'required|in:rent,sale,lease',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'amount' => 'required|numeric|min:0',
            'payment_frequency' => 'required|in:monthly,quarterly,semi_annual,annual',
            'security_deposit' => 'nullable|numeric|min:0',
            'terms' => 'nullable|string',
            'status' => 'required|in:draft,active,expired,terminated,renewed',
        ]);

        $contract->update($validated);
        return redirect()->route('contracts.show', $contract)->with('success', 'تم تحديث العقد بنجاح');
    }

    public function destroy(Contract $contract)
    {
        $contract->unit->update(['status' => 'available', 'tenant_id' => null]);
        $contract->delete();
        return redirect()->route('contracts.index')->with('success', 'تم حذف العقد بنجاح');
    }
}
