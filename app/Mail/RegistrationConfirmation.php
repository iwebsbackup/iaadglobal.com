<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class RegistrationConfirmation extends Mailable
{
    public function __construct(public User $user, public string $plainPassword) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Accont created successful | DiCD 2026',
            cc: ['info@dreamztravel.net'],
        );
    }

    public function content(): Content
    {
        return new Content(view: 'emails.registration');
    }
}
