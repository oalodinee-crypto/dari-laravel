<?php

namespace App\Http\Controllers;

use App\Models\MaintenanceRequest;
use App\Models\Property;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Http\Request;

// تحكم طلبات الصيانة
class MaintenanceController extends Controller
{
    // عرض طلبات الصيانة (حسب الصلاحية)
    public function index()
    {
        $user = auth()->user();
        
        if ($user->hasRole('admin') || $user->hasRole('manager')) {
            $maintenance = MaintenanceRequest::with(['user', 'property', 'assignedTo'])->latest()->paginate(15);
        } elseif ($user->hasRole('technician')) {
            $maintenance = MaintenanceRequest::with(['user', 'property'])
                ->where('assigned_to', $user->id)
                ->latest()->paginate(15);
        } else {
            $maintenance = MaintenanceRequest::with(['property', 'assignedTo'])
                ->where('user_id', $user->id)
                ->latest()->paginate(15);
        }
        
        return view('maintenance.index', compact('maintenance'));
    }

    // تقديم طلب صيانة جديد
    public function create()
    {
        $properties = auth()->user()->hasRole(['admin', 'manager']) 
            ? Property::all() 
            : Property::where('user_id', auth()->id())->get();
        return view('maintenance.create', compact('properties'));
    }

    // حفظ طلب الصيانة وإرسال الإشعارات
    public function store(Request $request)
    {
        $validated = $request->validate([
            'property_id' => 'required|exists:properties,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'priority' => 'required|in:low,medium,high,urgent',
            'images.*' => 'nullable|image|max:2048',
        ]);

        $images = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $images[] = $image->store('maintenance', 'public');
            }
        }

        $maintenance = MaintenanceRequest::create([
            'user_id' => auth()->id(),
            'property_id' => $validated['property_id'],
            'title' => $validated['title'],
            'description' => $validated['description'],
            'priority' => $validated['priority'],
            'images' => $images,
        ]);

        // إرسال إشعار للمالكين فقط
        $managers = User::role('Manager')->get();
        foreach ($managers as $manager) {
            Notification::create([
                'user_id' => $manager->id,
                'type' => 'maintenance',
                'title' => 'طلب صيانة جديد',
                'message' => 'تم تقديم طلب صيانة جديد من ' . auth()->user()->name . ': ' . $validated['title'],
                'data' => ['maintenance_id' => $maintenance->id],
                'action_url' => route('maintenance.show', $maintenance->id),
            ]);
        }

        return redirect()->route('maintenance.show', $maintenance)->with('success', 'تم إنشاء طلب الصيانة بنجاح');
    }

    // عرض تفاصيل الطلب
    public function show(MaintenanceRequest $maintenance)
    {
        $technicians = collect([]);
        return view('maintenance.show', compact('maintenance', 'technicians'));
    }

    public function edit(MaintenanceRequest $maintenance)
    {
        $properties = Property::all();
        $technicians = collect([]);
        return view('maintenance.edit', compact('maintenance', 'properties', 'technicians'));
    }

    // تحديث طلب الصيانة وحالته
    public function update(Request $request, MaintenanceRequest $maintenance)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'priority' => 'required|in:low,medium,high,urgent',
            'status' => 'required|in:pending,in_progress,completed,cancelled',
            'assigned_to' => 'nullable|exists:users,id',
            'notes' => 'nullable|string',
        ]);

        $oldStatus = $maintenance->status;
        $maintenance->update($validated);

        if ($validated['status'] === 'completed' && !$maintenance->completed_at) {
            $maintenance->update(['completed_at' => now()]);
        }

        // إشعار الساكن عند تغيير الحالة
        if ($oldStatus !== $validated['status']) {
            Notification::create([
                'user_id' => $maintenance->user_id,
                'type' => 'maintenance_update',
                'title' => 'تحديث على طلب الصيانة',
                'message' => 'تم تحديث حالة طلب الصيانة الخاص بك إلى: ' . $this->getStatusLabel($validated['status']),
                'data' => ['maintenance_id' => $maintenance->id],
                'action_url' => route('maintenance.show', $maintenance->id),
            ]);
        }

        return redirect()->route('maintenance.show', $maintenance)->with('success', 'تم تحديث طلب الصيانة بنجاح');
    }

    public function destroy(MaintenanceRequest $maintenance)
    {
        $maintenance->delete();
        return redirect()->route('maintenance.index')->with('success', 'تم حذف طلب الصيانة بنجاح');
    }

    public function updateStatus(Request $request, MaintenanceRequest $maintenance)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,in_progress,completed,cancelled',
        ]);

        $maintenance->update($validated);

        if ($validated['status'] === 'completed') {
            $maintenance->update(['completed_at' => now()]);
        }

        return back()->with('success', 'تم تحديث الحالة بنجاح');
    }

    private function getStatusLabel($status)
    {
        return match($status) {
            'pending' => 'قيد الانتظار',
            'in_progress' => 'قيد التنفيذ',
            'completed' => 'مكتملة',
            'cancelled' => 'ملغية',
            default => $status,
        };
    }
}