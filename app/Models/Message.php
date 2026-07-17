<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// نموذج الرسالة (نظام المراسلة الداخلي)
class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'sender_id',
        'receiver_id',
        'subject',
        'body',
        'is_read',
        'read_at',
        'parent_id',
        'type',
        'related_id',
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'read_at' => 'datetime',
    ];

    // العلاقات
    // المرسل
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    // المستقبل
    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    // الرسالة الأصلية (للردود)
    public function parent()
    {
        return $this->belongsTo(Message::class, 'parent_id');
    }

    // الردود على الرسالة
    public function replies()
    {
        return $this->hasMany(Message::class, 'parent_id');
    }

    // Scopes
    // الرسائل غير المقروءة
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    // المحادثة بين مستخدمين
    public function scopeConversation($query, $userId1, $userId2)
    {
        return $query->where(function ($q) use ($userId1, $userId2) {
            $q->where('sender_id', $userId1)->where('receiver_id', $userId2);
        })->orWhere(function ($q) use ($userId1, $userId2) {
            $q->where('sender_id', $userId2)->where('receiver_id', $userId1);
        });
    }

    // Methods
    // تحديد الرسالة كمقروءة
    public function markAsRead()
    {
        if (!$this->is_read) {
            $this->update([
                'is_read' => true,
                'read_at' => now(),
            ]);
        }
    }

    // Helper للحصول على العنصر المرتبط
    public function getRelatedModel()
    {
        return match($this->type) {
            'maintenance' => MaintenanceRequest::find($this->related_id),
            'complaint' => Complaint::find($this->related_id),
            'payment' => Payment::find($this->related_id),
            'contract' => Contract::find($this->related_id),
            default => null,
        };
    }
}
