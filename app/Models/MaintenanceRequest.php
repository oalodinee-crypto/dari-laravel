<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// نموذج طلب الصيانة
class MaintenanceRequest extends Model
{
    use HasFactory;

    // الحقول القابلة للتعبئة
    protected $fillable = [
        'user_id',
        'property_id',
        'unit_id',
        'assigned_to',
        'title',
        'description',
        'priority',
        'status',
        'images',
        'notes',
        'completed_at',
    ];

    protected $casts = [
        'images' => 'array',
        'completed_at' => 'datetime',
    ];

    // العلاقات
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // العقار
    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    // الوحدة
    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    // الموظف المسند إليه الطلب
    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    // نص حالة الطلب
    public function getStatusLabelAttribute()
    {
        return match($this->status) {
            'pending' => 'قيد الانتظار',
            'in_progress' => 'قيد التنفيذ',
            'completed' => 'مكتمل',
            'cancelled' => 'ملغي',
            default => $this->status,
        };
    }

    // نص الأولوية
    public function getPriorityLabelAttribute()
    {
        return match($this->priority) {
            'low' => 'منخفضة',
            'medium' => 'متوسطة',
            'high' => 'عالية',
            'urgent' => 'عاجلة',
            default => $this->priority,
        };
    }
}
