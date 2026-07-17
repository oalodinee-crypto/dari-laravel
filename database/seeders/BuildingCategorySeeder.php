<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\BuildingCategory;
use App\Models\BuildingType;
use App\Models\UnitType;

class BuildingCategorySeeder extends Seeder
{
    public function run(): void
    {
        // 1. إنشاء التصنيفات الرئيسية
        // 1. Categories (تصنيفات)
        $categories = [
            ['name_ar' => 'سكني', 'name_en' => 'Residential', 'sort_order' => 1],
            ['name_ar' => 'تجاري', 'name_en' => 'Commercial', 'sort_order' => 2],
            ['name_ar' => 'تعليمي', 'name_en' => 'Educational', 'sort_order' => 3],
        ];

        foreach ($categories as $cat) {
            BuildingCategory::updateOrCreate(['name_en' => $cat['name_en']], $cat);
        }

        // 2. ربط أنواع المباني بأنواع الوحدات
        // 2. Building Types & Unit Types Mapping
        // Structure: Category => [ BuildingType => [UnitType1, UnitType2, ...] ]
        
        $structure = [
            'Residential' => [
                'عمارة' => ['شقة', 'استوديو', 'روف'],
                'برج' => ['شقة', 'استوديو', 'بنثهاوس'],
                'فيلا' => ['فيلا'],
                'مجمع فلل' => ['فيلا'],
                'سكن طلاب/موظفين' => ['غرفة مشتركة', 'غرفة خاصة', 'جناح'],
                'شقق مفروشة' => ['شقة مفروشة', 'استوديو مفروش'],
            ],
            'Commercial' => [
                'مكتب' => ['مكتب'],
                'مجمع محلات' => ['محل تجاري', 'مستودع'],
                'مول' => ['معرض', 'كشك', 'مطعم', 'سينما'],
            ],
            'Educational' => [
                'مدرسة' => ['فصل دراسي', 'مكتب إداري', 'معمل'],
                'جامعة/كلية' => ['قاعة محاضرات', 'مكتب إداري', 'معمل', 'مسرح'],
                'معهد تدريب' => ['قاعة تدريب', 'مكتب إداري'],
                'حضانة' => ['فصل أطفال', 'غرفة رعاية'],
            ],
        ];

        foreach ($structure as $catEn => $bTypes) {
            $category = BuildingCategory::where('name_en', $catEn)->first();
            
            foreach ($bTypes as $typeName => $uTypes) {
                // Create Building Type
                $bType = BuildingType::updateOrCreate(
                    ['name_ar' => $typeName, 'category_id' => $category->id],
                    ['category_id' => $category->id]
                );

                foreach ($uTypes as $unitName) {
                    // Create Unit Type
                    $uType = UnitType::updateOrCreate(
                        ['name_ar' => $unitName]
                    );

                    // Attach to Building Type (Pivot)
                    // We check existence manually to avoid duplicates on seeding multiple times
                    $exists = DB::table('building_type_unit_types')
                        ->where('building_type_id', $bType->id)
                        ->where('unit_type_id', $uType->id)
                        ->exists();
                    
                    if (!$exists) {
                        DB::table('building_type_unit_types')->insert([
                            'building_type_id' => $bType->id,
                            'unit_type_id' => $uType->id,
                        ]);
                    }
                }
            }
        }
    }
}
