<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// نموذج الإعلان
class Announcement extends Model
{
    use HasFactory;

    protected $fillable = [
        'created_by', 'building_id', 'title', 'content', 'type',
        'priority', 'target', 'publish_at', 'expires_at',
        'is_active', 'send_notification'
    ];

    protected $casts = [
        'publish_at' => 'datetime',
        'expires_at' => 'datetime',
        'is_active' => 'boolean',
        'send_notification' => 'boolean',
    ];

    // العلاقات
    public function createdBy() { return $this->belongsTo(User::class, 'created_by'); } // المنشئ
    public function building() { return $this->belongsTo(Building::class); } // المبنى المستهدف (اختياري)
    
    // Scopes (نطاقات الاستعلام)
    // الإعلانات النشطة فقط
    public function scopeActive($query)
    {
        return $query->where('is_active', true)
            ->where(function($q) {
                $q->whereNull('expires_at')
                  ->orWhere('expires_at', '>=', now());
            });
    }
}
