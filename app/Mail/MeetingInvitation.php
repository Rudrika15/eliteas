<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MeetingInvitation extends Mailable
{
    use Queueable, SerializesModels;

    public $personName;
    public $personEmail;
    public $invitedPerson;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($personName, $personEmail, $invitedPerson)
    {
        $this->personName = $personName;
        $this->personEmail = $personEmail;
        $this->invitedPerson = $invitedPerson;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject('Meeting Invitation')
            ->view('emails.invitation');
    }
}
