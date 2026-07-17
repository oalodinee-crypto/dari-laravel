<?php

namespace App\Mail;

use App\Models\User;
use App\Models\Invoice;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

// بريد إلكتروني لتذكير بموعد الدفع
class PaymentReminder extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public User $user,
        public Invoice $invoice
    ) {}

    /**
     * تحديد موضوع البريد ومحتوياته
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'تذكير بموعد الدفع - نظام داري',
        );
    }

    /**
     * تحديد محتوى الرسالة (View)
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.payment-reminder',
        );
    }
}
