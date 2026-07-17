<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // مسح التخزين المؤقت (Cache) للصلاحيات
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // =====================
        // تعريف جميع الصلاحيات
        // =====================
        $permissions = [
            // إدارة المستخدمين
            'view users', 'create users', 'edit users', 'delete users',
            'toggle user status', 'change user password',
            
            // إدارة الصلاحيات
            'manage roles', 'assign roles', 'revoke roles',
            
            // إدارة الإعدادات
            'manage settings', 'change logo', 'change system name',
            
            // المباني والوحدات
            'view buildings', 'create buildings', 'edit buildings', 'delete buildings',
            'view units', 'create units', 'edit units', 'delete units',
            
            // العقود
            'view contracts', 'create contracts', 'edit contracts', 'delete contracts', 'view all contracts',
            
            // الفواتير والمدفوعات
            'view invoices', 'create invoices', 'edit invoices', 'delete invoices', 'view all invoices',
            'view payments', 'create payments', 'view all payments',
            
            // الصيانة
            'view maintenance', 'create maintenance', 'edit maintenance', 'delete maintenance',
            'assign maintenance', 'view all maintenance',
            
            // الإعلانات
            'view announcements', 'create announcements', 'edit announcements', 'delete announcements',
            
            // الشكاوى
            'view complaints', 'create complaints', 'respond complaints', 'view all complaints',
            
            // التقارير
            'view reports', 'view statistics', 'view all statistics',
            
            // السجلات
            'view logs',
            
            // الملف الشخصي
            'edit own profile', 'view own data',
            
            // المستندات
            'upload documents', 'view own documents',
        ];

        // إنشاء الصلاحيات في قاعدة البيانات
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // 👑 Admin - صلاحيات كاملة
        $adminRole = Role::firstOrCreate(['name' => 'Admin']);
        $adminRole->givePermissionTo(Permission::all());

        // 🏢 Manager - صلاحيات مالك المبنى
        $managerRole = Role::firstOrCreate(['name' => 'Manager']);
        $managerRole->givePermissionTo([
            'view users', 'create users', 'edit users',
            'view buildings', 'create buildings', 'edit buildings',
            'view units', 'create units', 'edit units',
            'view contracts', 'create contracts', 'edit contracts', 'view all contracts',
            'view invoices', 'create invoices', 'edit invoices', 'view all invoices',
            'view payments', 'create payments', 'view all payments',
            'view maintenance', 'create maintenance', 'edit maintenance', 'assign maintenance', 'view all maintenance',
            'view announcements', 'create announcements', 'edit announcements',
            'view complaints', 'respond complaints', 'view all complaints',
            'view reports', 'view statistics',
            'edit own profile',
        ]);

        // 🏠 Resident - صلاحيات الساكن
        $residentRole = Role::firstOrCreate(['name' => 'Resident']);
        $residentRole->givePermissionTo([
            'view own data', 'edit own profile',
            'view maintenance', 'create maintenance',
            'view invoices', 'view payments', 'create payments',
            'view complaints', 'create complaints',
            'view announcements',
            'upload documents', 'view own documents',
        ]);

        // 🔧 Technician - صلاحيات موظف الصيانة
        $technicianRole = Role::firstOrCreate(['name' => 'Technician']);
        $technicianRole->givePermissionTo([
            'view maintenance', 'edit maintenance', // Can view and update status
            'view own data', 'edit own profile',
        ]);
    }
}
