<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

// تحكم الإشعارات
class NotificationController extends Controller
{
    // عرض كل الإشعارات
    public function index()
    {
        $notifications = Notification::where('user_id', auth()->id())
            ->latest()
            ->paginate(20);
        
        return view('notifications.index', compact('notifications'));
    }

    // جلب الإشعارات غير المقروءة (للقائمة العلوية)
    public function unread()
    {
        $notifications = Notification::where('user_id', auth()->id())
            ->unread()
            ->latest()
            ->get();
        
        return response()->json([
            'count' => $notifications->count(),
            'notifications' => $notifications->take(5)
        ]);
    }

    // تحديد إشعار كمقروء
    public function markAsRead($id)
    {
        $notification = Notification::where('user_id', auth()->id())->findOrFail($id);
        $notification->markAsRead();
        
        return back()->with('success', 'تم تحديد الإشعار كمقروء');
    }

    // تحديد الكل كمقروء
    public function markAllAsRead()
    {
        Notification::where('user_id', auth()->id())
            ->unread()
            ->update(['read_at' => now()]);
        
        return back()->with('success', 'تم تحديد جميع الإشعارات كمقروءة');
    }

    // حذف إشعار
    public function destroy($id)
    {
        Notification::where('user_id', auth()->id())->findOrFail($id)->delete();
        return back()->with('success', 'تم حذف الإشعار');
    }

    // Helper: Create notification
    public static function create($userId, $type, $title, $message, $actionUrl = null, $data = [])
    {
        return Notification::create([
            'user_id' => $userId,
            'type' => $type,
            'title' => $title,
            'message' => $message,
            'action_url' => $actionUrl,
            'data' => $data,
        ]);
    }
}
