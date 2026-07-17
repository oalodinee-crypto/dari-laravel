<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// نموذج المبنى
class Building extends Model
{
    use HasFactory;

    // الحقول القابلة للتعبئة
    protected $fillable = [
        'name', 'code', 'description', 'address', 'city', 'district',
        'floors_count', 'units_count', 'year_built', 'total_area',
        'amenities', 'images', 'status', 'manager_id',
        'category_id', 'type_id', 'building_type'
    ];

    protected $casts = [
        'amenities' => 'array',
        'images' => 'array',
    ];

    // العلاقات
    public function manager() { return $this->belongsTo(User::class, 'manager_id'); } // مدير المبنى
    public function category() { return $this->belongsTo(BuildingCategory::class, 'category_id'); }
    public function type() { return $this->belongsTo(BuildingType::class, 'type_id'); }
    public function units() { return $this->hasMany(Unit::class); } // الوحدات السكنية في المبنى
    public function announcements() { return $this->hasMany(Announcement::class); } // الإعلانات الخاصة بالمبنى
    
    // حساب نسبة الإشغال (Attribute)
    public function getOccupancyRateAttribute()
    {
        $total = $this->units()->count();
        if ($total === 0) return 0;
        $occupied = $this->units()->where('status', 'occupied')->count();
        return round(($occupied / $total) * 100, 1);
    }
}