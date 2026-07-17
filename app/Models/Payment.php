<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// نموذج الدفع (السند)
class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'payment_number', 'invoice_id', 'tenant_id', 'received_by',
        'amount', 'method', 'reference_number', 'payment_date',
        'status', 'notes', 'receipt'
    ];

    protected $casts = [
        'payment_date' => 'date',
    ];

    // العلاقات
    public function invoice() { return $this->belongsTo(Invoice::class); } // الفاتورة المسددة
    public function tenant() { return $this->belongsTo(User::class, 'tenant_id'); } // القائم بالدفع
    public function receivedBy() { return $this->belongsTo(User::class, 'received_by'); } // مستلم المبلغ
}
