<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// نموذج نوع المبنى/الوحدة (شقة، فيلا، مكتب، إلخ)
class BuildingType extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name_ar',
        'name_en',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // العلاقات
    // التصنيف الرئيسي
    public function category()
    {
        return $this->belongsTo(BuildingCategory::class, 'category_id');
    }

    // أنواع الوحدات المتاحة لهذا النوع من المباني
    public function unitTypes()
    {
        return $this->belongsToMany(UnitType::class, 'building_type_unit_types', 'building_type_id', 'unit_type_id');
    }

    // المباني التابعة لهذا النوع
    public function buildings()
    {
        return $this->hasMany(Building::class, 'type_id');
    }
}
