<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// نموذج الإشعارات
class Notification extends Model
{
    protected $fillable = [
        'user_id',
        'type',
        'title',
        'message',
        'data',
        'action_url',
        'read_at',
    ];

    protected $casts = [
        'data' => 'array',
        'read_at' => 'datetime',
    ];

    // العلاقات
    public function user() // المستخدم المستلم للإشعار
    {
        return $this->belongsTo(User::class);
    }

    // Scopes
    // الإشعارات غير المقروءة
    public function scopeUnread($query)
    {
        return $query->whereNull('read_at');
    }

    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    // Methods
    // تحديد الإشعار كمقروء
    public function markAsRead()
    {
        if (!$this->read_at) {
            $this->update(['read_at' => now()]);
        }
    }

    public function isRead()
    {
        return $this->read_at !== null;
    }
}
