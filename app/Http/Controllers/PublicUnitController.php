<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use App\Services\QrCodeService;
use Illuminate\Http\Request;

// تحكم الوحدات العامة (الوصول عبر QR Code)
class PublicUnitController extends Controller
{
    /**
     * Show public unit page (accessed via QR code)
     */
    /**
     * عرض صفحة الوحدة العامة (عن طريق مسح الرمز)
     */
    public function show(Unit $unit)
    {
        $unit->load(['building', 'tenant']);
        
        return view('public.unit', compact('unit'));
    }
    
    /**
     * Quick maintenance request form
     */
    /**
     * نموذج طلب صيانة سريع (بدون تسجيل دخول)
     */
    public function maintenanceForm(Unit $unit)
    {
        return view('public.maintenance-form', compact('unit'));
    }
    
    /**
     * Submit quick maintenance request
     */
    /**
     * إرسال طلب الصيانة السريع
     */
    public function submitMaintenance(Request $request, Unit $unit)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'priority' => 'required|in:low,medium,high',
            'contact_phone' => 'required|string|max:20',
        ]);
        
        $unit->maintenanceRequests()->create([
            'user_id' => $unit->tenant_id,
            'unit_id' => $unit->id,
            'title' => $validated['title'],
            'description' => $validated['description'] . "\n\nهاتف التواصل: " . $validated['contact_phone'],
            'priority' => $validated['priority'],
            'status' => 'pending',
        ]);
        
        return redirect()->route('units.public', $unit)
            ->with('success', 'تم إرسال طلب الصيانة بنجاح!');
    }
    
    /**
     * Generate QR code for unit
     */
    /**
     * توليد رمز QR للوحدة
     */
    public function generateQrCode(Unit $unit, QrCodeService $qrCodeService)
    {
        $qrCodeService->generateForUnit($unit);
        
        return back()->with('success', 'تم إنشاء رمز QR بنجاح!');
    }
}
