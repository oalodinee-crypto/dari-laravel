<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// نموذج نوع الوحدة
class UnitType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_ar',
        'name_en',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // العلاقات
    // أنواع المباني التي تحتوي هذا النوع من الوحدات
    public function buildingTypes()
    {
        return $this->belongsToMany(BuildingType::class, 'building_type_unit_types', 'unit_type_id', 'building_type_id');
    }
}
