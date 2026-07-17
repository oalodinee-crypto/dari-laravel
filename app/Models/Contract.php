<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// نموذج العقد
class Contract extends Model
{
    use HasFactory;

    protected $fillable = [
        'contract_number', 'unit_id', 'tenant_id', 'created_by', 'type',
        'start_date', 'end_date', 'amount', 'payment_frequency',
        'security_deposit', 'terms', 'status', 'document'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    // العلاقات
    public function unit() { return $this->belongsTo(Unit::class); } // الوحدة
    public function tenant() { return $this->belongsTo(User::class, 'tenant_id'); } // المستأجر
    public function createdBy() { return $this->belongsTo(User::class, 'created_by'); } // منشئ العقد
    public function invoices() { return $this->hasMany(Invoice::class); } // الفواتير المرتبطة بالعقد
    
    public function getIsActiveAttribute()
    {
        return $this->status === 'active' && $this->end_date >= now();
    }
    
    public function getDaysRemainingAttribute()
    {
        return now()->diffInDays($this->end_date, false);
    }
}
