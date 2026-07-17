<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// نموذج الشكوى
class Complaint extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'assigned_to',
        'title',
        'description',
        'type',
        'priority',
        'status',
        'response',
        'rejection_reason',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // العلاقات
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function history()
    {
        return $this->hasMany(ComplaintHistory::class)->latest();
    }

    // Helpers
    // نص النوع (شكوى / اقتراح)
    public function getTypeLabelAttribute()
    {
        return match($this->type) {
            'complaint' => 'شكوى',
            'suggestion' => 'اقتراح',
            default => $this->type,
        };
    }

    // نص الحالة
    public function getStatusLabelAttribute()
    {
        return match($this->status) {
            'pending' => 'قيد الانتظار',
            'in_progress' => 'قيد المعالجة',
            'resolved' => 'تم الحل',
            'closed' => 'مغلقة',
            'rejected' => 'مرفوضة',
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
            default => $this->priority,
        };
    }
}
