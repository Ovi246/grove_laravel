<?php

namespace App\Mail;

use App\Models\Sponsorship;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SponsorshipReviewMail extends Mailable
{
    use Queueable, SerializesModels;

    public $sponsorship;

    /**
     * Create a new message instance.
     */
    public function __construct(Sponsorship $sponsorship)
    {
        $this->sponsorship = $sponsorship;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Sponsorship Review Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'view.name',
        );
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->markdown('emails.sponsorship.review')
                    ->with('sponsorship', $this->sponsorship);
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
