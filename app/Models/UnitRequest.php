<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// نموذج طلب الوحدة (للسكان الجدد)
class UnitRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'building_id', 'unit_type', 'rooms_count',
        'budget_min', 'budget_max', 'notes', 'status',
        'reviewed_by', 'admin_notes', 'reviewed_at'
    ];

    protected $casts = [
        'reviewed_at' => 'datetime',
    ];

    // المستخدم (مقدم الطلب)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // المبنى المطلوب (اختياري)
    public function building()
    {
        return $this->belongsTo(Building::class);
    }

    // الموظف الذي راجع الطلب
    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    // نص الحالة بالعربية
    public function getStatusArabicAttribute()
    {
        return match($this->status) {
            'pending' => 'قيد المراجعة',
            'approved' => 'مقبول',
            'rejected' => 'مرفوض',
            default => $this->status
        };
    }

    // لون الحالة (للواجهة الأمامية)
    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'pending' => 'warning',
            'approved' => 'success',
            'rejected' => 'danger',
            default => 'secondary'
        };
    }
}