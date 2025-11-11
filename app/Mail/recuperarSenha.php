<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RecuperarSenha extends Mailable
{
    use Queueable, SerializesModels;

    public $novaSenha;

    /**
     * Create a new message instance.
     */
    public function __construct($novaSenha)
    {
        $this->novaSenha = $novaSenha;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Sua nova senha',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.recuperar_senha',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
