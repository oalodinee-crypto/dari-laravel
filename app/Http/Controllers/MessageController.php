<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Http\Request;

// تحكم الرسائل (نظام المراسلة الداخلي)
class MessageController extends Controller
{
    /**
     * عرض قائمة المحادثات
     */
    public function index()
    {
        $user = auth()->user();
        
        // جلب آخر رسالة من كل محادثة
        $conversations = Message::where('sender_id', $user->id)
            ->orWhere('receiver_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy(function ($message) use ($user) {
                return $message->sender_id == $user->id 
                    ? $message->receiver_id 
                    : $message->sender_id;
            })
            ->map(function ($messages) {
                return $messages->first();
            });

        // جلب بيانات المستخدمين
        $userIds = $conversations->keys();
        $users = User::whereIn('id', $userIds)->get()->keyBy('id');

        return view('messages.index', compact('conversations', 'users'));
    }

    /**
     * عرض محادثة محددة
     */
    public function show($userId)
    {
        $user = auth()->user();
        $otherUser = User::findOrFail($userId);
        
        // جلب جميع الرسائل بين المستخدمين
        $messages = Message::conversation($user->id, $userId)
            ->orderBy('created_at', 'asc')
            ->get();
        
        // تحديد الرسائل كمقروءة
        Message::where('sender_id', $userId)
            ->where('receiver_id', $user->id)
            ->where('is_read', false)
            ->update(['is_read' => true, 'read_at' => now()]);

        return view('messages.show', compact('messages', 'otherUser'));
    }

    /**
     * إنشاء رسالة جديدة
     */
    public function create()
    {
        $user = auth()->user();
        
        // تحديد المستخدمين المتاحين للمراسلة بناءً على الدور
        if ($user->hasRole('Admin')) {
            $users = User::where('id', '!=', $user->id)->get();
        } elseif ($user->hasRole('Manager')) {
            // المالك يراسل السكان في مبانيه
            $users = User::role('Resident')->where('id', '!=', $user->id)->get();
        } else {
            // الساكن يراسل المالكين
            $users = User::role('Manager')->get();
        }

        return view('messages.create', compact('users'));
    }

    /**
     * إرسال رسالة
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'subject' => 'nullable|string|max:255',
            'body' => 'required|string',
            'type' => 'nullable|in:general,maintenance,complaint,payment,contract',
            'related_id' => 'nullable|integer',
        ]);

        $message = Message::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $validated['receiver_id'],
            'subject' => $validated['subject'] ?? null,
            'body' => $validated['body'],
            'type' => $validated['type'] ?? 'general',
            'related_id' => $validated['related_id'] ?? null,
        ]);

        // إنشاء إشعار للمستلم
        $this->createNotification(
            $validated['receiver_id'],
            'رسالة جديدة',
            'لديك رسالة جديدة من ' . auth()->user()->name,
            'message',
            route('messages.show', auth()->id())
        );

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => $message]);
        }

        return redirect()->route('messages.show', $validated['receiver_id'])
            ->with('success', 'تم إرسال الرسالة بنجاح');
    }

    /**
     * الرد على رسالة
     */
    public function reply(Request $request, $userId)
    {
        $validated = $request->validate([
            'body' => 'required|string',
        ]);

        $message = Message::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $userId,
            'body' => $validated['body'],
            'type' => 'general',
        ]);

        // إشعار
        $this->createNotification(
            $userId,
            'رد جديد',
            'لديك رد جديد من ' . auth()->user()->name,
            'message',
            route('messages.show', auth()->id())
        );

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => $message->load('sender'),
            ]);
        }

        return back()->with('success', 'تم إرسال الرد بنجاح');
    }

    /**
     * عدد الرسائل غير المقروءة
     */
    public function unreadCount()
    {
        $count = auth()->user()->unreadMessages()->count();
        return response()->json(['count' => $count]);
    }

    /**
     * تحديد رسالة كمقروءة
     */
    public function markAsRead(Message $message)
    {
        if ($message->receiver_id == auth()->id()) {
            $message->markAsRead();
        }

        return response()->json(['success' => true]);
    }

    /**
     * حذف رسالة
     */
    public function destroy(Message $message)
    {
        if ($message->sender_id == auth()->id() || $message->receiver_id == auth()->id()) {
            $message->delete();
            return back()->with('success', 'تم حذف الرسالة');
        }

        return back()->with('error', 'لا يمكنك حذف هذه الرسالة');
    }

    /**
     * Helper: إنشاء إشعار
     */
    private function createNotification($userId, $title, $message, $type, $actionUrl = null)
    {
        Notification::create([
            'user_id' => $userId,
            'type' => $type,
            'title' => $title,
            'message' => $message,
            'data' => [],
            'action_url' => $actionUrl,
        ]);
    }
}
