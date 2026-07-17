<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Activity;
use App\Models\Building;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

// تحكم المستخدمين (للمدير والأدمن)
class UserController extends Controller
{
    // عرض قائمة المستخدمين
    public function index()
    {
        $user = auth()->user();
        
        // إذا كان المستخدم Admin يرى الكل
        if ($user->hasRole('Admin')) {
            $users = User::with('roles', 'permissions')->latest()->paginate(15);
            $stats = [
                'total' => User::count(),
                'active' => User::where('is_active', true)->count(),
                'admins' => User::role('Admin')->count(),
                'managers' => User::role('Manager')->count(),
            ];
        } else {
            // المالك يرى فقط السكان المرتبطين بمبانيه
            $buildingIds = Building::where('manager_id', $user->id)->pluck('id');
            $unitTenantIds = Unit::whereIn('building_id', $buildingIds)
                                ->whereNotNull('tenant_id')
                                ->pluck('tenant_id');
            
            $users = User::with('roles', 'permissions')
                        ->whereIn('id', $unitTenantIds)
                        ->latest()
                        ->paginate(15);
            
            $stats = [
                'total' => $users->total(),
                'active' => User::whereIn('id', $unitTenantIds)->where('is_active', true)->count(),
                'admins' => 0,
                'managers' => 0,
            ];
        }
        
        return view('users.index', compact('users', 'stats'));
    }

    // صفحة إضافة مستخدم جديد
    public function create()
    {
        $roles = Role::all();
        
        // المالك يرى فقط دور Resident
        if (!auth()->user()->hasRole('Admin')) {
            $roles = Role::where('name', 'Resident')->get();
        }
        
        $permissions = Permission::all();
        return view('users.create', compact('roles', 'permissions'));
    }

    // حفظ المستخدم الجديد
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'role' => 'required|exists:roles,name',
            'permissions' => 'nullable|array',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'phone' => $validated['phone'],
        ]);

        $user->assignRole($validated['role']);
        
        if (isset($validated['permissions'])) {
            $user->givePermissionTo($validated['permissions']);
        }

        Activity::log('user_created', "تم إنشاء مستخدم جديد: {$user->name}", $user);

        return redirect()->route('users.index')->with('success', 'تم إضافة المستخدم بنجاح');
    }

    // عرض تفاصيل المستخدم
    public function show(User $user)
    {
        // تحقق من الصلاحية
        if (!$this->canManageUser($user)) {
            abort(403, 'ليس لديك صلاحية لعرض هذا المستخدم');
        }
        
        $user->load(['roles', 'permissions', 'properties', 'maintenanceRequests']);
        return view('users.show', compact('user'));
    }

    // تعديل بيانات المستخدم
    public function edit(User $user)
    {
        // تحقق من الصلاحية
        if (!$this->canManageUser($user)) {
            abort(403, 'ليس لديك صلاحية لتعديل هذا المستخدم');
        }
        
        $roles = Role::all();
        
        // المالك يرى فقط دور Resident
        if (!auth()->user()->hasRole('Admin')) {
            $roles = Role::where('name', 'Resident')->get();
        }
        
        $permissions = Permission::all();
        $userPermissions = $user->getDirectPermissions()->pluck('name')->toArray();
        return view('users.edit', compact('user', 'roles', 'permissions', 'userPermissions'));
    }

    // تحديث بيانات المستخدم
    public function update(Request $request, User $user)
    {
        // تحقق من الصلاحية
        if (!$this->canManageUser($user)) {
            return back()->with('error', 'ليس لديك صلاحية لتعديل هذا المستخدم');
        }
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'role' => 'required|exists:roles,name',
            'permissions' => 'nullable|array',
        ]);

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
        ]);

        if ($validated['password']) {
            $user->update(['password' => Hash::make($validated['password'])]);
        }

        $user->syncRoles([$validated['role']]);
        $user->syncPermissions($validated['permissions'] ?? []);

        Activity::log('user_updated', "تم تحديث بيانات المستخدم: {$user->name}", $user);

        return redirect()->route('users.index')->with('success', 'تم تحديث المستخدم بنجاح');
    }

    // حذف المستخدم (مع تسجيل النشاط)
    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'لا يمكنك حذف حسابك الخاص');
        }
        
        // تحقق من الصلاحية
        if (!$this->canManageUser($user)) {
            return back()->with('error', 'ليس لديك صلاحية لحذف هذا المستخدم');
        }
        
        Activity::log('user_deleted', "تم حذف المستخدم: {$user->name}");
        $user->delete();
        return redirect()->route('users.index')->with('success', 'تم حذف المستخدم بنجاح');
    }

    // تفعيل/تعطيل حساب المستخدم
    public function toggleStatus(User $user)
    {
        // تحقق من الصلاحية
        if (!$this->canManageUser($user)) {
            return back()->with('error', 'ليس لديك صلاحية لتعديل هذا المستخدم');
        }
        
        $user->update(['is_active' => !$user->is_active]);
        
        $status = $user->is_active ? 'تفعيل' : 'تعطيل';
        Activity::log('user_status_changed', "تم {$status} حساب المستخدم: {$user->name}", $user);
        
        return back()->with('success', "تم {$status} الحساب بنجاح");
    }

    // إدارة صلاحيات المستخدم
    public function permissions(User $user)
    {
        // تحقق من الصلاحية
        if (!$this->canManageUser($user)) {
            abort(403, 'ليس لديك صلاحية لعرض صلاحيات هذا المستخدم');
        }
        
        $permissions = Permission::all()->groupBy(function($permission) {
            return explode(' ', $permission->name)[1] ?? 'other';
        });
        $userPermissions = $user->getAllPermissions()->pluck('name')->toArray();
        $userDirectPermissions = $user->getDirectPermissions()->pluck('name')->toArray();
        
        return view('users.permissions', compact('user', 'permissions', 'userPermissions', 'userDirectPermissions'));
    }

    public function updatePermissions(Request $request, User $user)
    {
        // تحقق من الصلاحية
        if (!$this->canManageUser($user)) {
            return back()->with('error', 'ليس لديك صلاحية لتعديل صلاحيات هذا المستخدم');
        }
        
        $validated = $request->validate([
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,name',
        ]);

        $user->syncPermissions($validated['permissions'] ?? []);
        
        Activity::log('permissions_updated', "تم تحديث صلاحيات المستخدم: {$user->name}", $user);

        return redirect()->route('users.show', $user)->with('success', 'تم تحديث الصلاحيات بنجاح');
    }
    
    /**
     * التحقق من صلاحية المستخدم لإدارة مستخدم آخر
     */
    private function canManageUser(User $user)
    {
        $currentUser = auth()->user();
        
        // Admin يستطيع إدارة الكل
        if ($currentUser->hasRole('Admin')) {
            return true;
        }
        
        // المالك يستطيع إدارة سكان مبانيه فقط
        $buildingIds = Building::where('manager_id', $currentUser->id)->pluck('id');
        $tenantIds = Unit::whereIn('building_id', $buildingIds)
                        ->whereNotNull('tenant_id')
                        ->pluck('tenant_id')
                        ->toArray();
        
        return in_array($user->id, $tenantIds);
    }
}
