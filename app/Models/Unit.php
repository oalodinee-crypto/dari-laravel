<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// نموذج الوحدة السكنية
class Unit extends Model
{
    use HasFactory;

    // الحقول القابلة للتعبئة
    protected $fillable = [
        'building_id', 'tenant_id', 'unit_number', 'floor_number', 'type',
        'area', 'bedrooms', 'bathrooms', 'rent_amount', 'status',
        'lease_start', 'lease_end', 'features', 'images', 'notes', 'qr_code'
    ];

    protected $casts = [
        'features' => 'array',
        'images' => 'array',
        'lease_start' => 'date',
        'lease_end' => 'date',
    ];

    // العلاقات
    public function building() { return $this->belongsTo(Building::class); } // المبنى التابع له
    public function tenant() { return $this->belongsTo(User::class, 'tenant_id'); } // المستأجر الحالي
    public function contracts() { return $this->hasMany(Contract::class); } // العقود المرتبطة
    public function invoices() { return $this->hasMany(Invoice::class); } // الفواتير المرتبطة
    public function visitors() { return $this->hasMany(Visitor::class); } // الزيارات
    public function maintenanceRequests() { return $this->hasMany(MaintenanceRequest::class); } // طلبات الصيانة
    
    public function getFullNameAttribute()
    {
        return $this->building->name . ' - ' . $this->unit_number;
    }
}
