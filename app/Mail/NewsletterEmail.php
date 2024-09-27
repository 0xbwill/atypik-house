<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Content;

class NewsletterEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $subscriber;

    public function __construct($subscriber)
    {
        $this->subscriber = $subscriber;
    }

    public function envelope()
    {
        return new Envelope(
            subject: 'Merci pour votre abonnement, ' . $this->subscriber->email,
        );
    }

    public function content()
    {
        return new Content(
            view: 'emails.subscribers', // Vue générée par Maizzle
            with: ['subscriber' => $this->subscriber],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}

