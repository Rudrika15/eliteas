<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class WelcomeMemberEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    // public $password;
    public $contactNo;


    public function __construct($user, $contactNo)
    {
        $this->user = $user;
        $this->contactNo = $contactNo;
        // $this->password = $password;
    }

    public function build()
    {
        return $this->markdown('emails.welcome_member')
            ->subject('Welcome to UBN! '.$this->user->firstName)
            ->with([
                'username' => $this->user->email,
                // 'password' => $this->password,
                'contactNo' => $this->contactNo,
            ]);
    }
}
