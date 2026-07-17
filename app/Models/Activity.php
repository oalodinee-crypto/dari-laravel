<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// نموذج سجل النشاطات (لتسجيل حركات المستخدمين)
class Activity extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'type', 'description', 'subject_type',
        'subject_id', 'properties', 'ip_address', 'user_agent'
    ];

    protected $casts = [
        'properties' => 'array',
    ];

    // العلاقات
    public function user() { return $this->belongsTo(User::class); } // المستخدم صاحب النشاط
    public function subject() { return $this->morphTo(); } // الكائن المرتبط بالنشاط (مثل فاتورة، عقد، إلخ)
    
    public static function log($type, $description, $subject = null, $properties = [])
    {
        return static::create([
            'user_id' => auth()->id(),
            'type' => $type,
            'description' => $description,
            'subject_type' => $subject ? get_class($subject) : null,
            'subject_id' => $subject?->id,
            'properties' => $properties,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
}
