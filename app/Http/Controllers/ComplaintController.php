<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

// تحكم الشكاوى والمقترحات
class ComplaintController extends Controller
{
    public function index()
    {
        if (auth()->user()->hasRole('Manager') || auth()->user()->hasRole('Admin')) {
            $complaints = Complaint::with(['user', 'assignedTo'])->latest()->get();
        } else {
            $complaints = Complaint::where('user_id', auth()->id())->latest()->get();
        }
        return view('complaints.index', compact('complaints'));
    }

    // صفحة تقديم شكوى جديدة
    public function create() { return view('complaints.create'); }

    // حفظ الشكوى
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:complaint,suggestion',
            'priority' => 'required|in:low,medium,high',
            'description' => 'required|string',
        ]);

        $complaint = Complaint::create([
            'user_id' => auth()->id(),
            'title' => $validated['title'],
            'type' => $validated['type'],
            'priority' => $validated['priority'],
            'description' => $validated['description'],
            'status' => 'pending',
        ]);

        // Notify Managers
        $managers = User::role('Manager')->get();
        foreach ($managers as $manager) {
            Notification::create([
                'user_id' => $manager->id,
                'type' => 'complaint',
                'title' => 'شكوى جديدة',
                'message' => 'تم تقديم شكوى جديدة من ' . auth()->user()->name,
                'data' => ['complaint_id' => $complaint->id],
                'action_url' => route('complaints.show', $complaint->id),
            ]);
        }

        return redirect()->route('complaints.index')->with('success', 'تم تقديم الشكوى بنجاح');
    }

    public function show(Complaint $complaint)
    {
        if (!auth()->user()->hasRole(['Admin', 'Manager']) && $complaint->user_id != auth()->id()) {
            abort(403);
        }

        $complaint->load(['user', 'assignedTo']);
        $managers = User::role('Manager')->get();
        
        return view('complaints.show', compact('complaint', 'managers'));
    }

    public function edit(Complaint $complaint)
    {
        return view('complaints.edit', compact('complaint'));
    }

    public function update(Request $request, Complaint $complaint)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,in_progress,resolved,closed',
            'response' => 'nullable|string',
        ]);

        $oldStatus = $complaint->status;

        $complaint->update([
            'status' => $validated['status'],
            'response' => $validated['response'] ?? $complaint->response
        ]);

        // Notify User
        if ($oldStatus !== $validated['status'] || !empty($validated['response'])) {
            $this->notifyComplaintUser($complaint, 'تحديث على شكواك', 'تم تحديث حالة الشكوى.');
        }

        return redirect()->route('complaints.show', $complaint)->with('success', 'تم تحديث الشكوى بنجاح');
    }

    // إسناد الشكوى لموظف معين
    public function assign(Request $request, Complaint $complaint)
    {
        $request->validate(['assigned_to' => 'required|exists:users,id']);
        
        $assignee = User::find($request->assigned_to);
        $complaint->update(['assigned_to' => $assignee->id]);

        // Notify Assignee
        Notification::create([
            'user_id' => $assignee->id,
            'type' => 'assignment',
            'title' => 'تم إسناد شكوى إليك',
            'message' => 'تم تكليفك بمتابعة شكوى رقم #' . $complaint->id,
            'data' => ['complaint_id' => $complaint->id],
            'action_url' => route('complaints.show', $complaint->id),
        ]);

        return back()->with('success', 'تم إسناد الشكوى بنجاح');
    }

    public function reject(Request $request, Complaint $complaint)
    {
        $request->validate(['rejection_reason' => 'required|string']);

        $complaint->update([
            'status' => 'rejected',
            'rejection_reason' => $request->rejection_reason
        ]);

        $this->notifyComplaintUser($complaint, 'تم رفض الشكوى', 'نأسف، تم رفض شكواك. راجع التفاصيل.');

        return back()->with('success', 'تم رفض الشكوى');
    }

    public function destroy(Complaint $complaint)
    {
        $complaint->delete();
        return redirect()->route('complaints.index')->with('success', 'تم حذف الشكوى بنجاح');
    }

    private function notifyComplaintUser($complaint, $title, $message)
    {
        Notification::create([
            'user_id' => $complaint->user_id,
            'type' => 'complaint_update',
            'title' => $title,
            'message' => $message,
            'data' => ['complaint_id' => $complaint->id],
            'action_url' => route('complaints.show', $complaint->id),
        ]);
    }

    private function getStatusLabel($status)
    {
        return match($status) {
            'pending' => 'قيد الانتظار',
            'in_progress' => 'قيد المعالجة',
            'resolved' => 'تم الحل',
            'closed' => 'مغلقة',
            'rejected' => 'مرفوضة',
            default => $status,
        };
    }
}