<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MemberSubscription extends Mailable
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
    // public $amount;


    public function __construct($data)
    {
        $this->data = $data;

        // $this->personName = $personName;
        // $this->personEmail = $personEmail;
        // $this->invitedPersonFirstName = $invitedPersonFirstName;
        // $this->invitedPersonLastName = $invitedPersonLastName;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        return $this
            ->subject('Membership Payment')
            ->view('emails.memberSubscription',['amount'=>$this->data['amount'],'email'=>$this->data['email']]);

    }
}
