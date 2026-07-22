<?php

namespace App\Mail;

use App\Models\Membership;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MembershipExpiring extends Mailable
{
    use Queueable, SerializesModels;

    public $membership;

    /**
     * Create a new message instance.
     */
    public function __construct(Membership $membership)
    {
        $this->membership = $membership;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $daysLeft = now()->diffInDays($this->membership->end_date, false);
        $daysText = $daysLeft > 0 ? "en $daysLeft días" : 'pronto';

        return new Envelope(
            subject: '⚠️ Tu Membresía expira ' . $daysText,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.membership_expiring',
        );
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