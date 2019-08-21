<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class TicketInProgress extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $email;

    public $mailData1;

    public function __construct($mailData1)
    {
        $this->mailData1 = $mailData1;
    }

    public function build()
    {

        $inputs = array(
            'name'     => $this->mailData1['name'],
            'email'     => $this->mailData1['email'],
            'subject'   => $this->mailData1['subject'],
            'message'   => $this->mailData1['message'],
            'ticket'    => $this->mailData1['ticket'],
            'company'   => $this->mailData1['company']
        );

        return $this->view('emails.ticket-in-progress')
            ->with([
                'inputs' => $inputs,
            ]);
    }
}