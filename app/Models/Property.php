<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// نموذج العقار (العام)
class Property extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'type',
        'status',
        'price',
        'area',
        'bedrooms',
        'bathrooms',
        'city',
        'district',
        'address',
        'latitude',
        'longitude',
        'features',
        'images',
        'is_featured',
    ];

    protected $casts = [
        'features' => 'array',
        'images' => 'array',
        'is_featured' => 'boolean',
        'price' => 'decimal:2',
        'area' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // طلبات الصيانة المرتبطة بالعقار
    public function maintenanceRequests()
    {
        return $this->hasMany(MaintenanceRequest::class);
    }

    // الصورة الرئيسية للعقار
    public function getMainImageAttribute()
    {
        return $this->images[0] ?? 'images/default-property.jpg';
    }
}
