<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

// نموذج المستخدم (المدير، المالك، الساكن، الموظف)
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    // الحقول القابلة للتعبئة في قاعدة البيانات
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'phone',
        'country',
        'governorate',
        'city',
        'birthdate',
        'gender',
        'avatar',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_active' => 'boolean',
    ];

    // ===========================
    // العلاقات (Relationships)
    // ===========================

    // العقارات المملوكة للمستخدم
    public function properties()
    {
        return $this->hasMany(Property::class);
    }

    // طلبات الصيانة المقدمة من المستخدم
    public function maintenanceRequests()
    {
        return $this->hasMany(MaintenanceRequest::class);
    }

    // طلبات الصيانة المسندة للمستخدم (كفني أو موظف)
    public function assignedMaintenance()
    {
        return $this->hasMany(MaintenanceRequest::class, 'assigned_to');
    }

    // الرسائل المرسلة
    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    // الرسائل المستلمة
    public function receivedMessages()
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    // الرسائل غير المقروءة
    public function unreadMessages()
    {
        return $this->receivedMessages()->where('is_read', false);
    }

    // الإعلانات المنشأة
    public function announcements()
    {
        return $this->hasMany(Announcement::class, 'created_by');
    }

    // الشكاوى
    public function complaints()
    {
        return $this->hasMany(Complaint::class);
    }

    // العقود (للساكن)
    public function contracts()
    {
        return $this->hasMany(Contract::class, 'tenant_id');
    }

    // الإشعارات المخصصة
    public function customNotifications()
    {
        return $this->hasMany(Notification::class);
    }

    // الإشعارات غير المقروءة
    public function unreadNotifications()
    {
        return $this->customNotifications()->whereNull('read_at');
    }
}
