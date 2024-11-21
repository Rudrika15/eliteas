<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ConEventRegistrationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $userId;
    public $eventDetails;

    /**
     * Create a new message instance.
     */
    public function __construct($userId, $eventDetails)
    {
        $this->userId = $userId;
        $this->eventDetails = $eventDetails;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Event Registration Confirmation')
            ->view('email.eventRegistration')
            ->with([
                'userId' => $this->userId,
                'eventDetails' => $this->eventDetails,
            ]);
    }
}
