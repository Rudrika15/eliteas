<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MembershipSubcriptionRenewed extends Mailable
{
    use Queueable, SerializesModels;
    public $user;
    public $subscription;

    /**
     * Get the message envelope.
     */
    /**
     * Create a new message instance.
     */
    public function __construct($user, $subscription)
    {
        $this->user = $user;
        $this->subscription = $subscription;
    }
    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */

    public function build()
    {
        return $this->view('emails.membershipSubscriptionRenewed')
            ->with(['user' => $this->user, 'subscription' => $this->subscription]);
    }
}
