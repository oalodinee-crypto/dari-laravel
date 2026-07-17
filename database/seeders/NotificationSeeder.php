<?php

namespace Database\Seeders;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Database\Seeder;

class NotificationSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::first();
        
        if (!$admin) return;

        // بيانات إشعارات تجريبية
        $notifications = [
            [
                'type' => 'payment',
                'title' => 'دفعة جديدة مستلمة',
                'message' => 'تم استلام دفعة بقيمة 50,000 ر.ي من أحمد الحميري',
                'action_url' => '/payments',
            ],
            [
                'type' => 'contract',
                'title' => 'عقد ينتهي قريباً',
                'message' => 'عقد الوحدة 101 في برج صنعاء ينتهي خلال 15 يوم',
                'action_url' => '/contracts',
            ],
            [
                'type' => 'maintenance',
                'title' => 'طلب صيانة جديد',
                'message' => 'طلب صيانة جديد من الوحدة 205 - مشكلة في التكييف',
                'action_url' => '/maintenance',
            ],
            [
                'type' => 'system',
                'title' => 'تحديث النظام',
                'message' => 'تم تحديث نظام داري إلى الإصدار 2.0',
                'action_url' => null,
            ],
            [
                'type' => 'payment',
                'title' => 'فاتورة متأخرة',
                'message' => 'فاتورة الوحدة 304 متأخرة منذ 10 أيام',
                'action_url' => '/invoices',
            ],
        ];

        // إنشاء الإشعارات للمدير
        foreach ($notifications as $notif) {
            Notification::create([
                'user_id' => $admin->id,
                'type' => $notif['type'],
                'title' => $notif['title'],
                'message' => $notif['message'],
                'action_url' => $notif['action_url'],
                'created_at' => now()->subHours(rand(1, 48)),
            ]);
        }
    }
}
