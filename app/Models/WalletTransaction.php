<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// نموذج حركة المحفظة (إيداع/سحب)
class WalletTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'wallet_id',
        'user_id',
        'type',
        'amount',
        'balance_before',
        'balance_after',
        'description',
        'reference_type',
        'reference_id',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'balance_before' => 'decimal:2',
        'balance_after' => 'decimal:2',
    ];

    // المحفظة المرتبطة
    public function wallet()
    {
        return $this->belongsTo(Wallet::class);
    }

    // المستخدم
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // المرجع (فاتورة، عقد، إلخ)
    public function reference()
    {
        return $this->morphTo();
    }

    // نص نوع العملية
    public function getTypeLabelAttribute()
    {
        return $this->type === 'credit' ? 'إيداع' : 'سحب';
    }
}