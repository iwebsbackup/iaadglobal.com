<?php

namespace App\Mail;

use App\Models\Registration;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class PaymentConfirmation extends Mailable
{
    public function __construct(public Registration $registration)
    {
        $this->registration->loadMissing('user');
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Registration confirmed | DiCD 2026 | ' . $this->registration->registration_number,
            cc: ['info@dreamztravel.net'],
        );
    }

    public function content(): Content
    {
        return new Content(view: 'emails.payment-confirmation');
    }

    public function attachments(): array
    {
        $pdf = Pdf::loadView('pdf.receipt', ['registration' => $this->registration])->output();

        return [
            Attachment::fromData(fn() => $pdf, 'Receipt-' . $this->registration->registration_number . '.pdf')
                ->withMime('application/pdf'),
        ];
    }
}
