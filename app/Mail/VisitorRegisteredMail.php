<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VisitorRegisteredMail extends Mailable
{
    use Queueable, SerializesModels;

    public $eventDetails;

    /**
     * Create a new message instance.
     *
     * @param array $eventDetails
     */
    public function __construct(array $eventDetails = [])
    {
        // Ensure all keys exist in eventDetails with fallback values
        $this->eventDetails = array_merge([
            'title' => 'Event Title',
            'event_date' => now(),
            'venue' => 'To Be Decided',
            'firstName' => 'Attendee',
            'lastName' => '',
        ], $eventDetails);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Thank You for Registering!')
            ->view('email.eventRegistrationOther')
            ->with('eventDetails', $this->eventDetails);
    }
}
