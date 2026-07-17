<?php

namespace App\Services;

use App\Models\User;
use App\Models\Invoice;
use App\Models\MaintenanceRequest;
use Illuminate\Support\Facades\Mail;
use App\Mail\PaymentReminder;
use App\Mail\MaintenanceUpdate;
use App\Mail\AnnouncementNotification;

// خدمة إشعارات البريد الإلكتروني (تذكيرات الدفع، تحديثات الصيانة)
class EmailNotificationService
{
    /**
     * إرسال تذكير بالدفع
     */
    public function sendPaymentReminder(User $user, Invoice $invoice): bool
    {
        try {
            Mail::to($user->email)->send(new PaymentReminder($user, $invoice));
            return true;
        } catch (\Exception $e) {
            \Log::error('Failed to send payment reminder: ' . $e->getMessage());
            return false;
        }
    }
    
    /**
     * إرسال تحديث حالة طلب الصيانة
     */
    public function sendMaintenanceUpdate(MaintenanceRequest $request): bool
    {
        try {
            $user = $request->user;
            if ($user && $user->email) {
                Mail::to($user->email)->send(new MaintenanceUpdate($request));
                return true;
            }
            return false;
        } catch (\Exception $e) {
            \Log::error('Failed to send maintenance update: ' . $e->getMessage());
            return false;
        }
    }
    
    /**
     * إرسال تذكيرات جماعية للفواتير المستحقة
     */
    public function sendBulkPaymentReminders(): int
    {
        $pendingInvoices = Invoice::where('status', 'pending')
            ->where('due_date', '<=', now()->addDays(7))
            ->with('tenant')
            ->get();
        
        $sent = 0;
        foreach ($pendingInvoices as $invoice) {
            if ($invoice->tenant && $this->sendPaymentReminder($invoice->tenant, $invoice)) {
                $sent++;
            }
        }
        
        return $sent;
    }
}
