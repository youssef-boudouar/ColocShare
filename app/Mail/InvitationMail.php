<?php

namespace App\Mail;

use App\Models\Colocation;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InvitationMail extends Mailable
{
    use Queueable, SerializesModels;

    public Colocation $colocation;
    public string $url;

    public function __construct(Colocation $colocation)
    {
        $this->colocation = $colocation;
        $this->url = url('/join/' . $colocation->invite_token);
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Vous êtes invité à rejoindre une colocation',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.invitation',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
