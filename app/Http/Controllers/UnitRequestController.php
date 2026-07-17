<?php

namespace App\Http\Controllers;

use App\Models\UnitRequest;
use App\Models\Building;
use Illuminate\Http\Request;

// تحكم طلبات الوحدات (للسكان الجدد)
class UnitRequestController extends Controller
{
    /**
     * عرض طلباتي (للساكن)
     */
    // عرض طلباتي (للساكن)
    public function index()
    {
        $requests = UnitRequest::where('user_id', auth()->id())
            ->latest()
            ->get();
        
        return view('resident.unit-requests.index', compact('requests'));
    }

    /**
     * صفحة طلب وحدة جديدة (للساكن)
     */
    // صفحة طلب وحدة جديدة (للساكن)
    public function create()
    {
        $buildings = Building::where('status', 'active')->get();
        return view('resident.unit-requests.create', compact('buildings'));
    }

    /**
     * حفظ طلب وحدة جديد (للساكن)
     */
    // حفظ طلب وحدة جديد (للساكن)
    public function store(Request $request)
    {
        $request->validate([
            'unit_type' => 'required|string|max:100',
            'rooms_count' => 'nullable|integer|min:1',
            'bathrooms_count' => 'nullable|integer|min:1',
            'floor_from' => 'nullable|integer',
            'floor_to' => 'nullable|integer',
            'area_required' => 'nullable|integer|min:1',
            'parking' => 'nullable|string',
            'furnished' => 'nullable|string',
            'view_preference' => 'nullable|string',
            'move_date' => 'nullable|date',
            'contact_phone' => 'nullable|string|max:20',
            'budget_min' => 'nullable|numeric|min:0',
            'budget_max' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string|max:1000',
        ]);

        UnitRequest::create([
            'user_id' => auth()->id(),
            'building_id' => $request->building_id,
            'unit_type' => $request->unit_type,
            'rooms_count' => $request->rooms_count,
            'bathrooms_count' => $request->bathrooms_count,
            'floor_from' => $request->floor_from,
            'floor_to' => $request->floor_to,
            'area_required' => $request->area_required,
            'parking' => $request->parking,
            'furnished' => $request->furnished,
            'view_preference' => $request->view_preference,
            'move_date' => $request->move_date,
            'contact_phone' => $request->contact_phone,
            'budget_min' => $request->budget_min,
            'budget_max' => $request->budget_max,
            'notes' => $request->notes,
            'status' => 'pending',
        ]);

        return redirect()->route('resident.my-requests')
            ->with('success', 'تم إرسال طلبك بنجاح!');
    }

    /**
     * عرض تفاصيل طلب معين (للساكن)
     */
    // عرض تفاصيل طلب معين (للساكن)
    public function show($id)
    {
        $request = UnitRequest::where('user_id', auth()->id())
            ->findOrFail($id);
        
        return view('resident.unit-requests.show', compact('request'));
    }

    /**
     * حذف/إلغاء طلب (للساكن)
     */
    // حذف/إلغاء طلب (للساكن)
    public function destroy($id)
    {
        $unitRequest = UnitRequest::where('user_id', auth()->id())
            ->where('status', 'pending')
            ->findOrFail($id);
        
        $unitRequest->delete();

        return redirect()->route('resident.my-requests')
            ->with('success', 'تم إلغاء الطلب بنجاح!');
    }

    // =============================================
    // دوال المدير / الأدمن
    // =============================================

    /**
     * عرض جميع الطلبات (للمدير)
     */
    // عرض جميع الطلبات (للمدير)
    public function managerIndex()
    {
        $requests = UnitRequest::with('user')
            ->latest()
            ->get();
        
        return view('manager.unit-requests', compact('requests'));
    }

    /**
     * عرض تفاصيل طلب (للمدير)
     */
    // عرض تفاصيل طلب (للمدير)
    public function managerShow($id)
    {
        $request = UnitRequest::with('user')->findOrFail($id);
        return view('manager.unit-requests-show', compact('request'));
    }

    /**
     * قبول طلب (للمدير)
     */
    // قبول طلب (للمدير)
    public function approve($id)
    {
        $unitRequest = UnitRequest::findOrFail($id);
        $unitRequest->update([
            'status' => 'approved',
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
        ]);

        return redirect()->route('manager.unit-requests')
            ->with('success', 'تم قبول الطلب بنجاح!');
    }

    /**
     * رفض طلب (للمدير)
     */
    // رفض طلب (للمدير)
    public function reject($id)
    {
        $unitRequest = UnitRequest::findOrFail($id);
        $unitRequest->update([
            'status' => 'rejected',
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
        ]);

        return redirect()->route('manager.unit-requests')
            ->with('success', 'تم رفض الطلب.');
    }
}