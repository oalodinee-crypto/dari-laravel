<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Building;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;

// تحكم الإعلانات (عرض، إضافة، تعديل، حذف)
class AnnouncementController extends Controller
{
    // عرض قائمة الإعلانات (للمدير، المالك، الساكن)
    public function index()
    {
        $user = auth()->user();
        
        // الأدمن والمدير يرون جميع الإعلانات
        if ($user->hasAnyRole(['Admin', 'Manager', 'Super Admin'])) {
            $announcements = Announcement::with(['createdBy', 'building'])->latest()->paginate(15);
        }
        // المالك يرى إعلانات الأدمن الموجهة للمالكين + إعلاناته
        elseif ($user->hasRole('Owner')) {
            $announcements = Announcement::with(['createdBy', 'building'])
                ->where(function($query) use ($user) {
                    // إعلانات الأدمن للمالكين
                    $query->where('target', 'owners')
                          ->orWhere('target', 'all')
                          // أو إعلاناته الخاصة
                          ->orWhere('created_by', $user->id);
                })
                ->latest()
                ->paginate(15);
        }
        // الساكن يرى إعلانات المالكين والأدمن الموجهة للساكنين
        else {
            $announcements = Announcement::with(['createdBy', 'building'])
                ->where(function($query) {
                    $query->where('target', 'tenants')
                          ->orWhere('target', 'all');
                })
                ->latest()
                ->paginate(15);
        }
        
        return view('announcements.index', compact('announcements'));
    }

    // نموذج إضافة إعلان جديد
    public function create()
    {
        // منع الساكن فقط من إضافة إعلانات
        if (auth()->user()->hasRole('Resident')) {
            abort(403, 'ليس لديك صلاحية لإضافة إعلانات');
        }
        
        $buildings = Building::all();
        return view('announcements.create', compact('buildings'));
    }

    // تخزين الإعلان الجديد وإرسال الإشعارات
    public function store(Request $request)
    {
        // منع الساكن فقط من إضافة إعلانات
        if (auth()->user()->hasRole('Resident')) {
            abort(403, 'ليس لديك صلاحية لإضافة إعلانات');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'building_id' => 'nullable|exists:buildings,id',
            'type' => 'required|in:general,maintenance,emergency,event,reminder',
            'priority' => 'required|in:low,medium,high,urgent',
            'target' => 'required|in:all,tenants,owners,staff',
            'expires_at' => 'nullable|date',
            'is_active' => 'boolean',
        ]);

        $user = auth()->user();
        $validated['created_by'] = $user->id;
        $validated['publish_at'] = now();

        // تحديد الهدف تلقائياً حسب دور المنشئ
        if ($user->hasRole('Owner')) {
            // المالك ينشئ إعلان للساكنين
            $validated['target'] = 'tenants';
        } elseif ($user->hasAnyRole(['Admin', 'Manager', 'Super Admin'])) {
            // الأدمن ينشئ إعلان للمالكين (إذا لم يختر)
            if (!isset($validated['target']) || $validated['target'] == 'all') {
                $validated['target'] = 'owners';
            }
        }

        $announcement = Announcement::create($validated);
        
        // إرسال إشعارات حسب الهدف
        if ($validated['target'] == 'owners') {
            // إشعار للمالكين
            $owners = User::role('Owner')->get();
            foreach ($owners as $owner) {
                Notification::create([
                    'user_id' => $owner->id,
                    'type' => 'announcement',
                    'title' => 'إعلان جديد: ' . $validated['title'],
                    'message' => \Str::limit($validated['content'], 100),
                    'data' => ['announcement_id' => $announcement->id],
                    'action_url' => route('announcements.show', $announcement->id),
                ]);
            }
        } elseif ($validated['target'] == 'tenants') {
            // إشعار للساكنين
            $residents = User::role('Resident')->get();
            foreach ($residents as $resident) {
                Notification::create([
                    'user_id' => $resident->id,
                    'type' => 'announcement',
                    'title' => 'إعلان جديد: ' . $validated['title'],
                    'message' => \Str::limit($validated['content'], 100),
                    'data' => ['announcement_id' => $announcement->id],
                    'action_url' => route('announcements.show', $announcement->id),
                ]);
            }
        } elseif ($validated['target'] == 'all') {
            // إشعار للجميع
            $users = User::whereHas('roles', function($q) {
                $q->whereIn('name', ['Owner', 'Resident']);
            })->get();
            foreach ($users as $u) {
                Notification::create([
                    'user_id' => $u->id,
                    'type' => 'announcement',
                    'title' => 'إعلان جديد: ' . $validated['title'],
                    'message' => \Str::limit($validated['content'], 100),
                    'data' => ['announcement_id' => $announcement->id],
                    'action_url' => route('announcements.show', $announcement->id),
                ]);
            }
        }
        
        return redirect()->route('announcements.index')->with('success', 'تم نشر الإعلان بنجاح');
    }

    public function show(Announcement $announcement)
    {
        return view('announcements.show', compact('announcement'));
    }

    public function edit(Announcement $announcement)
    {
        $user = auth()->user();
        
        // منع الساكن من التعديل
        if ($user->hasRole('Resident')) {
            abort(403, 'ليس لديك صلاحية لتعديل الإعلانات');
        }
        
        // المالك يعدل فقط إعلاناته
        if ($user->hasRole('Owner') && $announcement->created_by != $user->id) {
            abort(403, 'ليس لديك صلاحية لتعديل هذا الإعلان');
        }

        $buildings = Building::all();
        return view('announcements.edit', compact('announcement', 'buildings'));
    }

    public function update(Request $request, Announcement $announcement)
    {
        $user = auth()->user();
        
        // منع الساكن من التعديل
        if ($user->hasRole('Resident')) {
            abort(403, 'ليس لديك صلاحية لتعديل الإعلانات');
        }
        
        // المالك يعدل فقط إعلاناته
        if ($user->hasRole('Owner') && $announcement->created_by != $user->id) {
            abort(403, 'ليس لديك صلاحية لتعديل هذا الإعلان');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'building_id' => 'nullable|exists:buildings,id',
            'type' => 'required|in:general,maintenance,emergency,event,reminder',
            'priority' => 'required|in:low,medium,high,urgent',
            'target' => 'required|in:all,tenants,owners,staff',
            'expires_at' => 'nullable|date',
            'is_active' => 'boolean',
        ]);

        $announcement->update($validated);
        return redirect()->route('announcements.index')->with('success', 'تم تحديث الإعلان بنجاح');
    }

    public function destroy(Announcement $announcement)
    {
        $user = auth()->user();
        
        // منع الساكن من الحذف
        if ($user->hasRole('Resident')) {
            abort(403, 'ليس لديك صلاحية لحذف الإعلانات');
        }
        
        // المالك يحذف فقط إعلاناته
        if ($user->hasRole('Owner') && $announcement->created_by != $user->id) {
            abort(403, 'ليس لديك صلاحية لحذف هذا الإعلان');
        }

        $announcement->delete();
        return redirect()->route('announcements.index')->with('success', 'تم حذف الإعلان بنجاح');
    }
}
