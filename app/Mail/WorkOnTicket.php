<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class WorkOnTicket extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $email;

    public $mailData;

    public function __construct($mailData)
    {
        $this->mailData = $mailData;
    }

    public function build()
    {

        $inputs = array(
            'name'     => $this->mailData['name'],
            'email'     => $this->mailData['email'],
            'subject'   => $this->mailData['subject'],
            'message'   => $this->mailData['message'],
            'ticket'    => $this->mailData['ticket'],
            'company'   => $this->mailData['company']
        );

        return $this->view('emails.work-on-ticket')
            ->with([
                'inputs' => $inputs,
            ]);
    }
}