<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use App\Models\Building;
use App\Models\User;
use App\Services\QrCodeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

// تحكم الوحدات السكنية
class UnitController extends Controller
{
    // عرض قائمة الوحدات
    public function index()
    {
        $units = Unit::with(['building', 'tenant'])->latest()->paginate(15);
        return view('units.index', compact('units'));
    }

    // صفحة إضافة وحدة جديدة
    public function create()
    {
        $buildings = Building::all();
        $tenants = User::role('Resident')->get();
        return view('units.create', compact('buildings', 'tenants'));
    }

    // حفظ الوحدة الجديدة
    public function store(Request $request)
    {
        $validated = $request->validate([
            'building_id' => 'required|exists:buildings,id',
            'unit_number' => 'required|string|max:50',
            'floor_number' => 'required|integer',
            'type' => 'required|in:apartment,studio,office,shop,storage',
            'area' => 'nullable|numeric',
            'bedrooms' => 'nullable|integer|min:0',
            'bathrooms' => 'nullable|integer|min:0',
            'rent_amount' => 'nullable|numeric',
            'status' => 'required|in:available,occupied,maintenance,reserved',
            'tenant_id' => 'nullable|exists:users,id',
        ]);

        Unit::create($validated);
        Building::find($validated['building_id'])->increment('units_count');
        return redirect()->route('units.index')->with('success', 'تم إضافة الوحدة بنجاح');
    }

    // عرض تفاصيل الوحدة
    public function show(Unit $unit)
    {
        $unit->load(['building', 'tenant', 'contracts', 'invoices', 'maintenanceRequests']);
        return view('units.show', compact('unit'));
    }

    // صفحة تعديل الوحدة
    public function edit(Unit $unit)
    {
        $buildings = Building::all();
        $tenants = User::role('Resident')->get();
        return view('units.edit', compact('unit', 'buildings', 'tenants'));
    }

    public function update(Request $request, Unit $unit)
    {
        $validated = $request->validate([
            'building_id' => 'required|exists:buildings,id',
            'unit_number' => 'required|string|max:50',
            'floor_number' => 'required|integer',
            'type' => 'required|in:apartment,studio,office,shop,storage',
            'area' => 'nullable|numeric',
            'bedrooms' => 'nullable|integer|min:0',
            'bathrooms' => 'nullable|integer|min:0',
            'rent_amount' => 'nullable|numeric',
            'status' => 'required|in:available,occupied,maintenance,reserved',
            'tenant_id' => 'nullable|exists:users,id',
        ]);

        $unit->update($validated);
        return redirect()->route('units.show', $unit)->with('success', 'تم تحديث الوحدة بنجاح');
    }

    // حذف الوحدة
    public function destroy(Unit $unit)
    {
        $unit->building->decrement('units_count');
        $unit->delete();
        return redirect()->route('units.index')->with('success', 'تم حذف الوحدة بنجاح');
    }
    
    /**
     * Upload images for unit
     */
    // رفع صور للوحدة
    public function uploadImages(Request $request, Unit $unit)
    {
        $request->validate([
            'images.*' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120'
        ]);
        
        $currentImages = $unit->images ?? [];
        
        foreach ($request->file('images') as $image) {
            $path = $image->store('units/' . $unit->id, 'public');
            $currentImages[] = $path;
        }
        
        $unit->update(['images' => $currentImages]);
        
        return back()->with('success', 'تم رفع الصور بنجاح');
    }
    
    /**
     * Delete image from unit
     */
    // حذف صورة من الوحدة
    public function deleteImage(Request $request, Unit $unit)
    {
        $imagePath = $request->input('image');
        $currentImages = $unit->images ?? [];
        
        if (($key = array_search($imagePath, $currentImages)) !== false) {
            Storage::disk('public')->delete($imagePath);
            unset($currentImages[$key]);
            $unit->update(['images' => array_values($currentImages)]);
        }
        
        return back()->with('success', 'تم حذف الصورة');
    }
    
    /**
     * Generate QR code for unit
     */
    // توليد رمز QR للوحدة
    public function generateQrCode(Unit $unit, QrCodeService $qrCodeService)
    {
        $qrCodeService->generateForUnit($unit);
        return back()->with('success', 'تم إنشاء رمز QR بنجاح');
    }
}
