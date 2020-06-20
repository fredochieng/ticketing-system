<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ReplyToTicket extends Mailable
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

        //dd($inputs);

        $this->withSwiftMessage(function ($message) {
            $message->getHeaders()
                ->addTextHeader('In-Reply-To', $this->mailData['message_id']);
            $message->getHeaders()
                ->addTextHeader('References',  $this->mailData['message_id']);
            $message
                ->setSender('fredrick.ochieng@mediamax.co.ke');
            // ->setReplyTo($this->mailData['email']);
        })->view('emails.reply-ticket');

        return $this->view('emails.reply-ticket')
            ->with([
                'inputs' => $inputs,
            ]);
    }
}
