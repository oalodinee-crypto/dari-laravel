<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// نموذج الزائر (تصريح الدخول)
class Visitor extends Model
{
    use HasFactory;

    protected $fillable = [
        'unit_id', 'tenant_id', 'approved_by', 'visitor_name',
        'visitor_id_number', 'visitor_phone', 'vehicle_number',
        'purpose', 'expected_arrival', 'actual_arrival',
        'departure_time', 'status', 'notes'
    ];

    protected $casts = [
        'expected_arrival' => 'datetime',
        'actual_arrival' => 'datetime',
        'departure_time' => 'datetime',
    ];

    // العلاقات
    public function unit() { return $this->belongsTo(Unit::class); } // الوحدة التي يزورها
    public function tenant() { return $this->belongsTo(User::class, 'tenant_id'); } // المستأجر المضيف
    public function approvedBy() { return $this->belongsTo(User::class, 'approved_by'); } // من وافق على التصريح
}
