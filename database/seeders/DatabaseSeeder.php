<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // استدعاء ملفات البذر (Seeding) لملء قاعدة البيانات بالبيانات الأولية
        $this->call([
            RolePermissionSeeder::class,
            BuildingCategorySeeder::class,
            UserSeeder::class,
            // PropertySeeder::class,
            // BuildingSeeder::class,
            NotificationSeeder::class,
            FullDataSeeder::class,
        ]);
    }
}
