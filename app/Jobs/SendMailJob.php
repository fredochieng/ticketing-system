<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use App\Mail\SendMail;
use App\Model\Messages;
use Illuminate\Support\Facades\Mail;
use App\User;


class SendMailJob
{
    use Dispatchable, Queueable;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($date = null)
    {
        if ($date == null) {
            $date = Carbon::now();
        }
        $this->date = $date;
    }
    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $users = User::getUsers();
        $message = Messages::getUnsentMessages();
        // dd($message);
        $title = $message->title;
        $body = $message->body;
        $name = $message->name;
        $email = $message->email;
        $mess_id = $message->id;

        $company = "Interweb Global Limited";
        $message = $body;
        $subject = $title;

        $mailData = array(
            'name'     => $name,
            'email'     => $email,
            'subject'    => $subject,
            'message'   =>  $message,
            'company'    => $company
        );

        $resp =  Mail::to($email)->send(new SendMail($mailData));

        //     DB::table('messages')->where('id', $mess_id)
        //         ->update([
        //             'delivered' => 'YES'
        //         ]);
    }
}