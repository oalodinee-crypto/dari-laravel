<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// نموذج المحفظة المالية
class Wallet extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'balance',
        'currency',
        'status',
    ];

    // المستخدم صاحب المحفظة
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // العمليات المالية (المعاملات)
    public function transactions()
    {
        return $this->hasMany(WalletTransaction::class)->latest();
    }
}
