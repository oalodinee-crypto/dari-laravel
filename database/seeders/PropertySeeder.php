<?php

namespace Database\Seeders;

use App\Models\Property;
use App\Models\User;
use Illuminate\Database\Seeder;

class PropertySeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('email', 'admin@dari.com')->first() ?? User::first();

        // عقارات تجريبية للعرض
        $properties = [
            [
                'title' => 'شقة فاخرة في حي النرجس',
                'description' => 'شقة فاخرة بتشطيبات عالية الجودة، موقع متميز قريب من جميع الخدمات',
                'type' => 'apartment',
                'status' => 'available',
                'price' => 850000,
                'area' => 180,
                'bedrooms' => 3,
                'bathrooms' => 2,
                'city' => 'الرياض',
                'district' => 'النرجس',
                'features' => ['موقف سيارة', 'مصعد', 'حارس أمن', 'حديقة'],
            ],
            [
                'title' => 'فيلا مودرن في حي الملقا',
                'description' => 'فيلا حديثة بتصميم عصري، مساحة واسعة مع حديقة خاصة ومسبح',
                'type' => 'villa',
                'status' => 'available',
                'price' => 2500000,
                'area' => 450,
                'bedrooms' => 5,
                'bathrooms' => 4,
                'city' => 'الرياض',
                'district' => 'الملقا',
                'features' => ['مسبح', 'حديقة خاصة', 'غرفة سائق', 'مجلس خارجي'],
            ],
            [
                'title' => 'مكتب تجاري في برج المملكة',
                'description' => 'مكتب تجاري بإطلالة مميزة، مجهز بالكامل وجاهز للاستخدام',
                'type' => 'office',
                'status' => 'rented',
                'price' => 150000,
                'area' => 120,
                'bedrooms' => 0,
                'bathrooms' => 2,
                'city' => 'الرياض',
                'district' => 'العليا',
                'features' => ['تكييف مركزي', 'موقف خاص', 'قاعة اجتماعات', 'استقبال'],
            ],
        ];

        foreach ($properties as $property) {
            Property::create(array_merge($property, ['user_id' => $admin->id]));
        }
    }
}
