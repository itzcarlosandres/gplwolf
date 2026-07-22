<?php

namespace App\Mail;

use App\Models\User;
use App\Models\Rank;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RankUpgradeNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $newRank;
    public $oldRank;

    /**
     * Create a new message instance.
     */
    public function __construct(User $user, Rank $newRank, ?Rank $oldRank = null)
    {
        $this->user = $user;
        $this->newRank = $newRank;
        $this->oldRank = $oldRank;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '🏆 ¡Felicidades! Alcanzaste el Rango ' . $this->newRank->name,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.rank_upgrade',
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
