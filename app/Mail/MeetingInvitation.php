<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MeetingInvitation extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    // public $personName;
    // public $personEmail;
    // public $invitedPersonFirstName;
    // public $invitedPersonLastName;
    // public $amount;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $amount;
    public function __construct($data)
    {
        $this->data = $data;
        // $this->personName = $personName;
        // $this->personEmail = $personEmail;
        // $this->invitedPersonFirstName = $invitedPersonFirstName;
        // $this->invitedPersonLastName = $invitedPersonLastName;
        // $this->amount = $amount;
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
            ->view('emails.invitation',['amount'=>$this->data['amount']]);

    }
}
