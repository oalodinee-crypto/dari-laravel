<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// نموذج سجل الشكوى (للتتبع)
class ComplaintHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'complaint_id',
        'user_id',
        'type',
        'description',
    ];

    // الشكوى المرتبطة
    public function complaint()
    {
        return $this->belongsTo(Complaint::class);
    }

    // المستخدم الذي قام بالإجراء
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
