<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class TicketCreated extends Mailable
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
        // $this->email = $email;
    }

    public function build()
    {

        $inputs = array(
            'name'     => $this->mailData['name'],
            'email'     => $this->mailData['email'],
            'subject'   => $this->mailData['subject'],
            'message'   => $this->mailData['message'],
            'ticket'    => $this->mailData['ticket'],
            'company'   => $this->mailData['company'],
            'message_id' => $this->mailData['message_id']
        );
        // echo "fred";
        // exit;
        // echo "<pre>";
        // print_r($inputs);
        // exit;

        $this->withSwiftMessage(function ($message) {
            $message->getHeaders()
                ->addTextHeader('In-Reply-To', $this->mailData['message_id']);
            $message->getHeaders()
                ->addTextHeader('References',  $this->mailData['message_id']);
            $message
                ->setSender('ticketing@ke.wananchi.com');
        });
        //->view('emails.ticket_opening_email');

        return $this->view('emails.ticket_opening_email')
            ->with([
                'inputs' => $inputs,
            ]);
    }
}