<?php

namespace Database\Seeders;

use App\Models\Building;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Database\Seeder;

class BuildingSeeder extends Seeder
{
    public function run(): void
    {
        // البحث عن أول مستخدم بصلاحية مدير لتعيينه كمدير للمباني
        $manager = User::role('Manager')->first();
        
        // بيانات المباني الافتراضية
        $buildings = [
            ['name' => 'برج الياسمين', 'type' => 'residential', 'floors_count' => 10, 'units_per_floor' => 4],
            ['name' => 'مجمع النخيل', 'type' => 'commercial', 'floors_count' => 5, 'units_per_floor' => 6],
            ['name' => 'برج الريان', 'type' => 'mixed', 'floors_count' => 15, 'units_per_floor' => 4],
        ];

        foreach ($buildings as $buildingData) {
            // إنشاء المبنى
            $building = Building::create([
                'name' => $buildingData['name'],
                'type' => $buildingData['type'],
                'address' => 'الرياض، المملكة العربية السعودية',
                'city' => 'الرياض',
                'floors_count' => $buildingData['floors_count'],
                'units_count' => $buildingData['floors_count'] * $buildingData['units_per_floor'],
                'year_built' => rand(2015, 2023),
                'status' => 'active',
                'manager_id' => $manager?->id,
            ]);

            $unitTypes = ['apartment', 'studio', 'office', 'shop'];
            // إنشاء وحدات لكل طابق
            for ($floor = 1; $floor <= min($buildingData['floors_count'], 5); $floor++) {
                for ($unit = 1; $unit <= $buildingData['units_per_floor']; $unit++) {
                    Unit::create([
                        'building_id' => $building->id,
                        'unit_number' => $floor . str_pad($unit, 2, '0', STR_PAD_LEFT),
                        'floor' => $floor,
                        'type' => $unitTypes[array_rand($unitTypes)],
                        'bedrooms' => rand(1, 4),
                        'bathrooms' => rand(1, 3),
                        'area' => rand(80, 250),
                        'rent_amount' => rand(30000, 120000),
                        'status' => ['available', 'occupied', 'maintenance'][array_rand(['available', 'occupied', 'maintenance'])],
                    ]);
                }
            }
        }
    }
}