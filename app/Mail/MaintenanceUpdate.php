<?php

namespace App\Mail;

use App\Models\MaintenanceRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

// بريد إلكتروني لتحديث حالة طلب الصيانة
class MaintenanceUpdate extends Mailable
{
    use Queueable, SerializesModels;

    public MaintenanceRequest $maintenance;

    public function __construct(MaintenanceRequest $maintenance)
    {
        $this->maintenance = $maintenance;
    }

    /**
     * تحديد موضوع البريد ومحتوياته
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'تحديث طلب الصيانة - ' . $this->maintenance->title,
        );
    }

    /**
     * تحديد محتوى الرسالة (View)
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.maintenance-update',
        );
    }

    /**
     * المرفقات (إن وجدت)
     */
    public function attachments(): array
    {
        return [];
    }
}
