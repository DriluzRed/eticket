<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Ticket;
use Illuminate\Mail\Mailables\Attachment;

class TicketRegistrationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $ticket;
    public $pdfPath;
    /**
     * Create a new message instance.
     *
     * @param \App\Models\Ticket $ticket
     * @return void
     */
    public function __construct($ticket, $pdfPath)
    {
        $this->ticket = $ticket;
        $this->pdfPath = $pdfPath;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Ticket evento para el evento: ' . $this->ticket->event->name,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.ticket',
            
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [
            Attachment::fromStorage($this->pdfPath),
        ];
    }
}
