<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// نموذج الفاتورة
class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_number', 'contract_id', 'unit_id', 'tenant_id', 'created_by',
        'type', 'description', 'amount', 'tax_amount', 'total_amount',
        'issue_date', 'due_date', 'status', 'notes'
    ];

    protected $casts = [
        'issue_date' => 'date',
        'due_date' => 'date',
    ];

    // العلاقات
    public function contract() { return $this->belongsTo(Contract::class); } // العقد
    public function unit() { return $this->belongsTo(Unit::class); } // الوحدة
    public function tenant() { return $this->belongsTo(User::class, 'tenant_id'); } // المستأجر
    public function createdBy() { return $this->belongsTo(User::class, 'created_by'); } // منشئ الفاتورة
    public function payments() { return $this->hasMany(Payment::class); } // المدفوعات (السدادات)
    
    public function getPaidAmountAttribute()
    {
        return $this->payments()->where('status', 'completed')->sum('amount');
    }
    
    public function getRemainingAmountAttribute()
    {
        return $this->total_amount - $this->paid_amount;
    }
}
