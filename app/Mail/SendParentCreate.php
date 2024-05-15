<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendParentCreate extends Mailable
{
    use Queueable, SerializesModels;

    public $parentData;

    /**
     * Create a new message instance.
     */
    public function __construct(array $parentData)
    {
        $this->parentData = $parentData;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Enregistrer en tant que parent d\'éleve',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return (new Content())->with([
            'parentData' => $this->parentData,
            'loginUrl' => 'https://google.com',
            ])->view('mail.messageParentCreate');

        // return new Content(
        //     view: 'mail.parentCreate',

        // );

    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
