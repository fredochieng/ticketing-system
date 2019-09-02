<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Model\FetchMails;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\TicketCreated;
use App\Mail\ReplyToTicket;
use App\Mail\TicketEscalation;
use App\adLDAP;
use App\Model\Ticket;
use App\Model\Issue;
use App\Model\IssueSubCategory;
use App\Model\Department;
use App\Model\EscalationLevel;
use App\Model\Priority;
use Illuminate\Support\Facades\Log;
use function GuzzleHttp\json_encode;
use DB;

class FetchTicketsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // $obj = new FetchMails('webmail.ke.wananchi.com', 'fredrick.ochieng@ke.wananchi.com', 'Happy1995', 'imap', '143', false, true);
        $obj = new FetchMails('webmail.ke.wananchi.com', 'ticketing@ke.wananchi.com', 'Zuku@2019!', 'imap', '143', false, true);

        // //Connect to the Mail Box
        $obj->connect(); //If connection fails give error message and exit

        if ($obj->is_connected()) {
            // Get Total Number of Unread Email in mail box
            $tot = $obj->get_total_emails(); //Total Mails in Inbox Return integer value

            //echo "Total Mails:: " . $tot . "<br>";

            //     //This function will only work with IMAP.. If it is POP3 then you have to use "get_total_emails()".
            $unread = $obj->get_unread_emails();

            if (!$unread) {
                // echo "No Unread email found.<br>";
            } else {
                // echo "Total Unread E-Mails:: " . count($unread) . "<br>";
                $ticket  = new Ticket();

                //Displaying all unread emails.
                Log::info("Found unread mails: " . json_encode($unread));
                for ($i = 0; $i < count($unread); $i++) {
                    $eml_num = $unread[$i];

                    $last_ticket = Ticket::orderBy('ticket_id', 'desc')->first();

                    if (!$last_ticket) {
                        $number = 0;
                    } else {
                        $last_ticket = $last_ticket->ticket;
                        $number = explode('-', $last_ticket)[1];
                    }
                    $next_number = sprintf('%03d', intval($number) + 1);

                    $ticket_string = "IT";
                    $ticket = $ticket_string . '-' . $next_number;
                    $status_id = 1;
                    $priority_id = 1;

                    $head = $obj->get_email_header($eml_num);

                    if (count($head) == 0) {
                        continue;
                    }
                    Log::info("Header: ->" . json_encode($head));
                    // $arrFiles3 = $obj->get_attachments($eml_num);

                    // // echo "<pre>";
                    // // print_r($head);
                    // // exit;

                    // if ($arrFiles3) {
                    //     foreach ($arrFiles3 as $key => $value) {
                    //         $files = ($value == "") ? "" : "Attached File :: " . '<a href="/"></a> ' . $value . "<br>";
                    //     }
                    // }
                    // // The below function will store attachment at the path passed in second argument and return Array of file names received.
                    // $arrFiles = $obj->get_attachments($eml_num, "uploads/email_attachments/");
                    // if ($arrFiles) {
                    //     foreach ($arrFiles as $key => $value) {
                    //         $files = ($value == "") ? "" : $value;
                    //         $files1[] = 'uploads/email_attachments/' . $files;
                    //     }
                    //     $files3 = json_encode($files1);
                    // } else {
                    //     $files3 = '';
                    // }

                    $today = Carbon::now('Africa/Nairobi')->toDateString();

                    if (array_key_exists('references', $head['mail_details']['full_header'])) {
                        $reply = $obj->get_email_body($eml_num);

                        //$reply = substr($reply, 0, strpos($reply, "From:"));

                        $regards = 'Regards';
                        $kind_regards = 'Kind Regards';

                        $pos = strpos($reply, $regards);
                        //$pos1 = strpos($reply, $kind_regards);

                        if ($pos === false) {
                            $desc = $obj->get_email_body($eml_num);
                        } else {
                            $desc = substr($reply, 0, strpos($reply, "From:"));
                        }

                        $references =  $head['mail_details']['full_header']->references;
                        $submitter = $head['mail_details']['name'];


                        $variable = substr($references, 0, strpos($references, "> <"));

                        $var = str_replace('.com', '.com >"  ', $variable);

                        $var = str_replace(' "<', '<', $var);

                        $resp = str_replace(' >" ', '>', $var);


                        $original_ticket = DB::table('tickets')
                            ->select(
                                DB::raw('ticket_id'),
                                DB::raw('message_id'),
                                DB::raw('submitter')
                            )
                            ->where('message_id', '=', $resp)
                            ->first();

                        if ($original_ticket) {

                            $ticket_id = $original_ticket->ticket_id;
                            // $submitter = strtolower($original_ticket->submitter);

                            $reply_array = array(
                                'ticket_id' => $ticket_id,
                                'submitter' => ucwords($submitter),
                                'message' => $desc,
                                'reply_type' => 'sent a reply'
                            );

                            $save_reply_details = DB::table('ticket_replies')->insertGetId($reply_array);
                        }
                    } else {
                        $message = $obj->get_email_body($eml_num);

                        $regards = 'Regards';
                        $kind_regards = 'Kind Regards';

                        $pos = strpos($message, $regards);
                        //$pos1 = strpos($message, $kind_regards);

                        if ($pos === false) {
                            $desc = $obj->get_email_body($eml_num);
                        } else {
                            $desc = substr($message, 0, strpos($message, "Regards"));
                        }

                        // if ($pos1 === false) {
                        //     $desc = $obj->get_email_body($eml_num);
                        // } else {
                        //     $desc = substr($message, 0, strpos($message, "Kind Regards"));
                        // }
                        $invalid = array(
                            'no-reply@manage.trendmicro.com', 'root@nbi.simbanet.co.ke', 'noreply@dmarc.yahoo.com', 'noreply@simbanet.co.tz', 'no-reply@infobip.com',
                            'cpanel@mga-legal.com', 'cpanel@webhost.simbanet.co.ke', 'noreply-dmarc@zoho.com', 'networksolutions@notifications.networksolutions.com',
                            'noreply-dmarc-support@google.com', 'cpanel@cartridgeworldkenya.com', 'no-reply@mx67.antispamcloud.com', 'noreply@mxtoolbox.com',
                            'dmarc@spamtitan.com', 'no-reply@foxitsoftware.com', 'TrendMicroExternalAdvisoryService@support.trendmicro.com', 'trendmicroexternaladvisoryservice@support.trendmicro.com', 'mgeups@ke.wananchi.com'
                        );

                        // no-reply@infobip.com, janetbain@epbfi.com;

                        if (!in_array($head['mail_details']['email'], $invalid)) {

                            $country = $head['mail_details']['full_header']->from[0]->host;
                            $kenya = 'ke';
                            $tanzania = 'tz';
                            $uganda = 'ug';
                            $zambia = 'zm';
                            $malawi = 'mw';

                            if (strpos($country, $kenya) !== false) {
                                $country_id = 1;
                            } elseif (strpos($country, $tanzania) !== false) {
                                $country_id = 2;
                            } elseif (strpos($country, $uganda) !== false) {
                                $country_id = 3;
                            } elseif (strpos($country, $malawi) !== false) {
                                $country_id = 4;
                            } elseif (strpos($country, $zambia) !== false) {
                                $country_id = 5;
                            } else {
                                $country_id = 1;
                            }
                            // dd($country_id);
                            $tickets_array = array(
                                'ticket' => $ticket,
                                'status_id' => $status_id,
                                'priority_id' => $priority_id,
                                'ticket_date' => $today,
                                'submitter' => strtoupper($head['mail_details']['name']),
                                'email' => $head['mail_details']['email'],
                                'message_id' => $head['mail_details']['full_header']->message_id,
                                'message_no' => $head['mail_details']['full_header']->Msgno,
                                'country_id' => $country_id,
                                'created_at' => $head['mail_details']['created_at'],
                                'updated_at' => $head['mail_details']['updated_at']
                            );

                            $save_ticket_from_mail = DB::table('tickets')->insertGetId($tickets_array);

                            $ticket_mess_id = DB::table('tickets')
                                ->select(
                                    DB::raw('tickets.*')
                                )
                                ->where('tickets.ticket_id', '=', $save_ticket_from_mail)
                                ->first();

                            $message_id = $ticket_mess_id->message_id;

                            $ticket_details_array = array(
                                'subject' => $head['mail_details']['subject'],
                                'description' => $desc,
                                'created_at' => $head['mail_details']['created_at'],
                                'updated_at' => $head['mail_details']['updated_at'],
                                //'attached_file' => $files3
                            );

                            $save_ticket_details = DB::table('ticket_details')->insertGetId($ticket_details_array);

                            $reply_array = array(
                                'ticket_id' => $save_ticket_from_mail,
                                'submitter' => ucwords($head['mail_details']['name']),
                                'message' => $desc,
                                'reply_type' => ' opened ticket '
                            );

                            $save_reply_details = DB::table('ticket_replies')->insertGetId($reply_array);

                            $email =  $head['mail_details']['email'];
                            $name = $head['mail_details']['name'];
                            $company = "Wananchi Group IT Team";

                            $objEmail = new \stdClass();
                            $objEmail->name = $name;
                            $objEmail->ticket = $ticket;
                            $objEmail->subject = 'Ticket' . '#' . $ticket . 'Created';
                            $objEmail->message = "Someone will be assigned to process your ticket";
                            $objEmail->company = $company;

                            $mailData = array(
                                'name'     => $name,
                                'email'     => $email,
                                'ticket'     => $ticket,
                                'subject'    => 'Ticket' . '#' . $ticket . 'Created',
                                'message'   => 'Someone will be assigned to process your ticket',
                                'message_id' => $message_id,
                                'company'    => $company
                            );
                            $resp = Mail::to($email)->send(new TicketCreated($mailData));
                        }
                    }


                    //The below function return email body.. If you want Text body from HTML formated email then pass second parameter i.e. $obj->get_email_body($eml_num,'text');
                    // echo $obj->get_email_body($eml_num);

                    // //The below function will store attachment at the path passed in second argument and return Array of file names received.
                    // $arrFiles = $obj->get_attachments($eml_num, "./");
                    // if ($arrFiles) {
                    //     foreach ($arrFiles as $key => $value) {
                    //         $files = ($value == "") ? "" : "Attached File :: " . '<a href="/"></a> ' . $value . "<br>";
                    //     }
                    // }
                    // // The below function will mark the email as Read in the mail box but commented in example site...
                    $obj->markas_read_email($eml_num);

                    // The below function will delete the email from mail box but commented in example for accidental deletion...
                    //$obj->delete_email($eml_num);
                }
            }
        }
        $obj->close_mailbox(); //Close Mail Box
    }
}