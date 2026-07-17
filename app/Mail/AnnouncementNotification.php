<?php

namespace App\Mail;

use App\Models\Announcement;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

// بريد إلكتروني لإشعار بالإعلانات الجديدة
class AnnouncementNotification extends Mailable
{
    use Queueable, SerializesModels;

    public Announcement $announcement;

    public function __construct(Announcement $announcement)
    {
        $this->announcement = $announcement;
    }

    /**
     * تحديد موضوع البريد ومحتوياته
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'إعلان جديد: ' . $this->announcement->title,
        );
    }

    /**
     * تحديد محتوى الرسالة (View)
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.announcement',
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
