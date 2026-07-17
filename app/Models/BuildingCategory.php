<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// نموذج تصنيف المبنى (سكني، تجاري، إلخ)
class BuildingCategory extends Model
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
    // أنواع المباني التابعة لهذا التصنيف
    public function types()
    {
        return $this->hasMany(BuildingType::class, 'category_id');
    }

    // المباني التابعة لهذا التصنيف
    public function buildings()
    {
        return $this->hasMany(Building::class, 'category_id');
    }
}
