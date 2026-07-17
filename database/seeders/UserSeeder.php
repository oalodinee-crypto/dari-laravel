<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // إنشاء حساب المدير العام (Admin) مع كلمة مرور ثابتة
        // Admin - المدير العام
        $admin = User::create([
            'name' => 'وليد العنسي',
            'email' => 'Waleedalansi2023@gmail.com',
            'password' => Hash::make('lwma773157823'),
            'phone' => '773157823',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);
        $admin->assignRole('Admin');

        // Manager - مالك المبنى
        $manager = User::create([
            'name' => 'عبدالله الزبيدي',
            'email' => 'owner@dari.com',
            'password' => Hash::make('password123'),
            'phone' => '771234567',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);
        $manager->assignRole('Manager');

        // Resident - ساكن 1
        $resident1 = User::create([
            'name' => 'محمد الحميري',
            'email' => 'resident@dari.com',
            'password' => Hash::make('password123'),
            'phone' => '772345678',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);
        $resident1->assignRole('Resident');

        // Resident - ساكن 2
        $resident2 = User::create([
            'name' => 'أحمد المقطري',
            'email' => 'ahmed@dari.com',
            'password' => Hash::make('password123'),
            'phone' => '773456789',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);
        $resident2->assignRole('Resident');

        // Resident - ساكن 3
        $resident3 = User::create([
            'name' => 'خالد الشرعبي',
            'email' => 'khaled@dari.com',
            'password' => Hash::make('password123'),
            'phone' => '774567890',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);
        $resident3->assignRole('Resident');
        
        // Resident - ساكن 4
        $resident4 = User::create([
            'name' => 'علي الكبسي',
            'email' => 'ali@dari.com',
            'password' => Hash::make('password123'),
            'phone' => '775678901',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);
        $resident4->assignRole('Resident');
    }
}
