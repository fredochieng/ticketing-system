<?php

namespace App\Http\Controllers;

use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;
use App\Model\Ticket;
use App\Model\Issue;
use App\Model\IssueSubCategory;
use App\Model\Department;
use App\Model\EscalationLevel;
use App\Model\Priority;
use App\User;
use App\Model\FetchMails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use DB;
use RealRashid\SweetAlert\Facades\Alert;
use Webklex\IMAP\Client;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\TicketCreated;
use App\Mail\ReplyToTicket;
use App\Mail\TicketEscalation;
use App\Mail\TicketAssignment;
use App\Mail\TicketAssigned;
use App\Mail\WorkOnTicket;
use App\Mail\TicketInProgress;
use App\Mail\TicketCreationAndAssignment;
use App\adLDAP;
use Illuminate\Support\Facades\Log;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    use HasRoles;
    protected $guard_name = 'web';
    public function index(Ticket $ticket)
    {
        $data['tickets'] = Ticket::getTickets();

        $data['tickets']->map(function ($item) {

            $name = DB::table('users')
                ->select(
                    DB::raw('users.name AS assigned_to_name')
                )
                ->where('users.id', '=', $item->assigned_user_id)->get();

            $item->assigned_to_name = json_encode($name);
            $item->assigned_to_name = str_replace('[{"assigned_to_name":"', '', $item->assigned_to_name);
            $item->assigned_to_name = str_replace('"}]', '', $item->assigned_to_name);


            if ($item->assigned_to_name == []) {
                $item->assigned_to_name = 'NOBODY';
            } else {
                $item->assigned_to_name = $item->assigned_to_name;
            }

            return $item;
        });

        $data['departments'] = Department::getDepartments();
        $data['priorities'] = Priority::getPriorities();
        $data['users'] = User::getHelpdeskTeam();
        $data['issue_categories'] = Issue::getIssueCategories();
        $data['countries'] = DB::table('countries')->orderBy('country_id', 'asc')->get();

        // // $obj = new FetchMails('webmail.ke.wananchi.com', 'fredrick.ochieng@ke.wananchi.com', 'Happy1995', 'imap', '143', false, true);
        // $obj = new FetchMails('webmail.ke.wananchi.com', 'ticketing@ke.wananchi.com', 'Zuku@2019!', 'imap', '143', false, true);

        // // //Connect to the Mail Box
        // $obj->connect(); //If connection fails give error message and exit

        // if ($obj->is_connected()) {
        //     // Get Total Number of Unread Email in mail box
        //     $tot = $obj->get_total_emails(); //Total Mails in Inbox Return integer value

        //     //echo "Total Mails:: " . $tot . "<br>";

        //     //     //This function will only work with IMAP.. If it is POP3 then you have to use "get_total_emails()".
        //     $unread = $obj->get_unread_emails();
        //     if (!$unread) {
        //         // echo "No Unread email found.<br>";
        //     } else {
        //         // echo "Total Unread E-Mails:: " . count($unread) . "<br>";
        //         $ticket  = new Ticket();

        //         //Displaying all unread emails.

        //         for ($i = 0; $i < count($unread); $i++) {
        //             $eml_num = $unread[$i];

        //             $last_ticket = Ticket::orderBy('ticket_id', 'desc')->first();

        //             if (!$last_ticket) {
        //                 $number = 0;
        //             } else {
        //                 $last_ticket = $last_ticket->ticket;
        //                 $number = substr($last_ticket, -3);
        //             }
        //             $next_number = sprintf('%03d', intval($number) + 1);
        //             $ticket_string = "IT";
        //             $ticket = $ticket_string . '-' . $next_number;
        //             $status_id = 1;
        //             $priority_id = 1;

        //             $head = $obj->get_email_header($eml_num);


        //             //$arrFiles3 = $obj->get_attachments($eml_num);

        //             // echo "<pre>";
        //             // print_r($head);
        //             // echo "<pre>";
        //             // exit;

        //             // if ($arrFiles3) {
        //             //     foreach ($arrFiles3 as $key => $value) {
        //             //         $files = ($value == "") ? "" : "Attached File :: " . '<a href="/"></a> ' . $value . "<br>";
        //             //     }
        //             // }
        //             //The below function will store attachment at the path passed in second argument and return Array of file names received.
        //             // $arrFiles = $obj->get_attachments($eml_num, "uploads/email_attachments/");
        //             // if ($arrFiles) {
        //             //     foreach ($arrFiles as $key => $value) {
        //             //         $files = ($value == "") ? "" : $value;
        //             //         $files1[] = 'uploads/email_attachments/' . $files;
        //             //     }
        //             //     $files3 = json_encode($files1);
        //             // } else {
        //             //     $files3 = '';
        //             // }

        //             $today = Carbon::now('Africa/Nairobi')->toDateString();

        //             if (array_key_exists('references', $head['mail_details']['full_header'])) {
        //                 $reply = $obj->get_email_body($eml_num);

        //                 $reply = substr($reply, 0, strpos($reply, "From:"));
        //                 $references =  $head['mail_details']['full_header']->references;

        //                 $variable = substr($references, 0, strpos($references, "> <"));

        //                 $var = str_replace('.com', '.com >"  ', $variable);

        //                 $var = str_replace(' "<', '<', $var);

        //                 $resp = str_replace(' >" ', '>', $var);


        //                 $original_ticket = DB::table('tickets')
        //                     ->select(
        //                         DB::raw('ticket_id'),
        //                         DB::raw('message_id'),
        //                         DB::raw('submitter')
        //                     )
        //                     ->where('message_id', '=', $resp)
        //                     ->first();

        //                 if ($original_ticket) {

        //                     $ticket_id = $original_ticket->ticket_id;
        //                     $submitter = strtolower($original_ticket->submitter);

        //                     $reply_array = array(
        //                         'ticket_id' => $ticket_id,
        //                         'submitter' => ucwords($submitter),
        //                         'message' => $reply
        //                     );

        //                     $save_reply_details = DB::table('ticket_replies')->insertGetId($reply_array);
        //                 }
        //             } else {
        //                 $message = $obj->get_email_body($eml_num);

        //                 $regards = 'Regards';
        //                 $kind_regards = 'Kind Regards';

        //                 $pos = strpos($message, $regards);
        //                 //$pos1 = strpos($message, $kind_regards);

        //                 if ($pos === false) {
        //                     $desc = $obj->get_email_body($eml_num);
        //                 } else {
        //                     $desc = substr($message, 0, strpos($message, "Regards"));
        //                 }

        //                 // if ($pos1 === false) {
        //                 //     $desc = $obj->get_email_body($eml_num);
        //                 // } else {
        //                 //     $desc = substr($message, 0, strpos($message, "Kind Regards"));
        //                 // }
        //                 $invalid = array('wood.wambugu@ke.wananchi.com');


        //                 // if (!in_array($head['mail_details']['email'], $invalid)) {
        //                 //     $tickets_array = array(
        //                 //         'ticket' => $ticket,
        //                 //         'status_id' => $status_id,
        //                 //         'priority_id' => $priority_id,
        //                 //         'ticket_date' => $today,
        //                 //         'submitter' => strtoupper($head['mail_details']['name']),
        //                 //         'email' => $head['mail_details']['email'],
        //                 //         'message_id' => $head['mail_details']['full_header']->message_id,
        //                 //         'message_no' => $head['mail_details']['full_header']->Msgno,
        //                 //         'created_at' => $head['mail_details']['created_at'],
        //                 //         'updated_at' => $head['mail_details']['updated_at']
        //                 //     );

        //                 //     $save_ticket_from_mail = DB::table('tickets')->insertGetId($tickets_array);

        //                 //     $ticket_mess_id = DB::table('tickets')
        //                 //         ->select(
        //                 //             DB::raw('tickets.*'),
        //                 //         )
        //                 //         ->where('tickets.ticket_id', '=', $save_ticket_from_mail)
        //                 //         ->first();

        //                 //     $message_id = $ticket_mess_id->message_id;

        //                 //     $ticket_details_array = array(
        //                 //         'subject' => $head['mail_details']['subject'],
        //                 //         'description' => $desc,
        //                 //         'created_at' => $head['mail_details']['created_at'],
        //                 //         'updated_at' => $head['mail_details']['updated_at'],
        //                 //         // 'attached_file' => $files3
        //                 //     );

        //                 //     $save_ticket_details = DB::table('ticket_details')->insertGetId($ticket_details_array);

        //                 //     $reply_array = array(
        //                 //         'ticket_id' => $save_ticket_from_mail,
        //                 //         'submitter' => ucwords($head['mail_details']['name']),
        //                 //         'message' => $desc
        //                 //     );

        //                 //     $save_reply_details = DB::table('ticket_replies')->insertGetId($reply_array);

        //                 //     $email =  $head['mail_details']['email'];
        //                 //     $name = $head['mail_details']['name'];
        //                 //     $company = "Wananchi Group Ltd";

        //                 //     $objEmail = new \stdClass();
        //                 //     $objEmail->name = $name;
        //                 //     $objEmail->ticket = $ticket;
        //                 //     $objEmail->subject = 'Ticket' . '#' . $ticket . 'Created';
        //                 //     $objEmail->message = "Someone will be assigned to process your ticket";
        //                 //     $objEmail->company = $company;

        //                 //     $mailData = array(
        //                 //         'name'     => $name,
        //                 //         'email'     => $email,
        //                 //         'ticket'     => $ticket,
        //                 //         'subject'    => 'Ticket' . '#' . $ticket . 'Created',
        //                 //         'message'   => 'Someone will be assigned to process your ticket',
        //                 //         'message_id' => $message_id,
        //                 //         'company'    => $company
        //                 //     );
        //                 // }


        //             }

        //             //The below function return email body.. If you want Text body from HTML formated email then pass second parameter i.e. $obj->get_email_body($eml_num,'text');
        //             // echo $obj->get_email_body($eml_num);

        //             // //The below function will store attachment at the path passed in second argument and return Array of file names received.
        //             // $arrFiles = $obj->get_attachments($eml_num, "./");
        //             // if ($arrFiles) {
        //             //     foreach ($arrFiles as $key => $value) {
        //             //         $files = ($value == "") ? "" : "Attached File :: " . '<a href="/"></a> ' . $value . "<br>";
        //             //     }
        //             // }
        //             // // The below function will mark the email as Read in the mail box but commented in example site...
        //             // $obj->markas_read_email($eml_num);

        //             // The below function will delete the email from mail box but commented in example for accidental deletion...
        //             //$obj->delete_email($eml_num);
        //         }
        //     }
        // }
        // $obj->close_mailbox(); //Close Mail Box

        return view('tickets.index')->with($data);
    }

    // Fetch issue subcategories
    public function getIssueSubcategories()
    {
        $issue_category_id = Input::get('category_id');
        $issue_subcategories = IssueSubCategory::where('issue_id', '=', $issue_category_id)->get();
        return response()->json($issue_subcategories);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tickets.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $last_ticket = Ticket::orderBy('ticket_id', 'desc')->first();

        if (!$last_ticket) {
            $number = 0;
        } else {
            $last_ticket = $last_ticket->ticket;
            $number = substr($last_ticket, -3);
        }
        $next_number = sprintf('%03d', intval($number) + 1);

        try {
            $ticket = new Ticket();
            $ticket_string = "IT";
            $ticket->ticket = $ticket_string . '-' . $next_number;
            $ticket->priority_id = $request->input('priority_id');
            $ticket->country_id = $request->input('country_id');
            $assigned_user = $request->input('assigned_user_id');
            $now = Carbon::now('Africa/Nairobi');

            if (!empty($assigned_user)) {
                $status_id = 2;
            } else {
                $status_id = 1;
            }

            $ticket_no = $ticket->ticket;

            $ticket->status_id = $status_id;
            $ticket->assigned_user_id = $assigned_user;

            $username = $request->input('username');

            $adldap = new adLDAP();

            $userinfo = $adldap->user_info($username, array("name", "samaccountname", "userPrincipalName", "mail", "description", "group"));

            if ($userinfo) {

                foreach ($userinfo as $key => $value) {
                    $userinfo = $value;
                }
                $name = $userinfo['name'][0];
                $username = $userinfo['samaccountname'][0];
                $email = $userinfo['mail'][0];

                $today = Carbon::now('Africa/Nairobi')->toDateString();
                $assigned_at = Carbon::now('Africa/Nairobi');


                $ticket->email = $email;
                $ticket->submitter = strtoupper($name);
                $ticket->ticket_date = $today;


                DB::beginTransaction();
                $ticket->save();

                $just_saved_ticket_id = $ticket->ticket_id;

                $ticket_details_data = array(
                    'id' => $just_saved_ticket_id,
                    'subject' => strtoupper($request->input('subject')),
                    'issue_id' => $request->input('issue_category_id'),
                    'sub_id' => $request->input('subcategory_id'),
                    'description' => $request->input('description')
                );
                $save_ticket_details_data = DB::table('ticket_details')->insertGetId($ticket_details_data);

                $reply_array = array(
                    'ticket_id' => $just_saved_ticket_id,
                    'submitter' => ucwords($name),
                    'message' => $request->input('description'),
                    'reply_type' => 'opened a ticket'
                );

                $save_reply_details = DB::table('ticket_replies')->insertGetId($reply_array);

                if (!empty($assigned_user)) {
                    DB::table('ticket_details')->where('id', $just_saved_ticket_id)->update(array('assigned_at' => $assigned_at));
                    $user_assigned = DB::table('users')->where('id', '=', $assigned_user)->first();
                    $assigned_name = $user_assigned->name;
                    $assigned_email = $user_assigned->email;

                    $company = "Wananchi Group IT Team";
                    $subject = 'Ticket ' . '#' . $ticket_no . ' Creation and Assignment';
                    $message = 'A new ticket has been created and assigned to you. ' . ' Ticket Number : ' . $ticket_no;

                    $mailData1 = array(
                        'name'     => $assigned_name,
                        'email'     => $assigned_email,
                        'ticket'     => $ticket_no,
                        'subject'    => $subject,
                        'message'   => $message,
                        'company'    => $company
                    );

                    $resp = Mail::to($assigned_email)->send(new TicketCreationAndAssignment($mailData1));
                }

                DB::commit();
                $name =  $name;
                $email = $email;
                $company = "Wananchi Group IT Team";

                $objEmail = new \stdClass();
                $objEmail->name = $name;
                $objEmail->ticket = $ticket_no;
                $objEmail->subject = 'Ticket' . '#' . $ticket . 'Created';
                $objEmail->message = "Someone will be assigned to process your ticket";
                $objEmail->company = $company;

                $mailData = array(
                    'name'     => $name,
                    'email'     => $email,
                    'ticket'     => $ticket_no,
                    'subject'    => 'Ticket ' . '# ' . $ticket_no . ' Created',
                    'message'   => 'Someone will be assigned to process your ticket',
                    'message_id' => 'bdfdgydtfdrt6dggvcfcttydtftd',
                    'company'    => $company
                );

                $resp = Mail::to($email)->send(new TicketCreated($mailData));
                toast('Ticket created  successfully', 'success', 'top-right');

                return back();
            } else {
                Log::warning("Ticket Creation attempt by " . Auth::user()->name . " for user: " . $username . " and subject: " . $request->input('subject') . " failed at " . $now);
                toast('No user found matching the username', 'error', 'top-right');
                return back();
            }
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            toast('Oops!!! An error ocurred while creating ticket', 'error', 'top-right');
            return back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function show(Ticket $ticket)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function edit(Ticket $ticket)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ticket $ticket)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */

    public function openTickets()
    {
        $data['tickets_open']  = Ticket::ticketsOpen();
        return view('tickets.open')->with($data);
    }

    public function ticketsInProgress()
    {
        $data['tickets_in_progress']  = Ticket::ticketsinProgress();
        $data['tickets_in_progress']->map(function ($item) {

            $name = DB::table('users')
                ->select(
                    DB::raw('users.name AS assigned_name')
                )
                ->where('users.id', '=', $item->assigned_user_id)->get();

            $item->assigned_to = json_encode($name);
            $item->assigned_to = str_replace('[{"assigned_name":"', '', $item->assigned_to);
            $item->assigned_to = str_replace('"}]', '', $item->assigned_to);

            if ($item->assigned_user_id == '') {
                $item->assigned_to = 'NOBODY';
            } else {
                $item->assigned_to = str_replace('"}]', '', $item->assigned_to);
            }
            return $item;
        });
        return view('tickets.in-progress')->with($data);
    }

    public function closedTickets()
    {
        $data['tickets_closed']  = Ticket::ticketsClosed();
        $data['tickets_closed']->map(function ($item) {

            $name = DB::table('users')
                ->select(
                    DB::raw('users.name AS assigned_name')
                )
                ->where('users.id', '=', $item->assigned_user_id)->get();

            $item->assigned_to = json_encode($name);
            $item->assigned_to = str_replace('[{"assigned_name":"', '', $item->assigned_to);
            $item->assigned_to = str_replace('"}]', '', $item->assigned_to);

            if ($item->assigned_user_id == '') {
                $item->assigned_to = 'NOBODY';
            } else {
                $item->assigned_to = str_replace('"}]', '', $item->assigned_to);
            }
            return $item;
        });
        return view('tickets.closed')->with($data);
    }

    public function myAssignedTickets()
    {
        $data['my_assigned']  = Ticket::myAssignedTickets();
        return view('tickets.assigned-to-me')->with($data);
    }

    public function escalatedTickets()
    {
        $data['tickets_escalated']  = Ticket::getTickets()->where('esc_level_id', '!=', '');
        $data['tickets_escalated']->map(function ($item) {

            $name = DB::table('users')
                ->select(
                    DB::raw('users.name AS assigned_name')
                )
                ->where('users.id', '=', $item->assigned_user_id)->get();

            $item->assigned_to = json_encode($name);
            $item->assigned_to = str_replace('[{"assigned_name":"', '', $item->assigned_to);
            $item->assigned_to = str_replace('"}]', '', $item->assigned_to);

            if ($item->assigned_user_id == '') {
                $item->assigned_to = 'NOBODY';
            } else {
                $item->assigned_to = str_replace('"}]', '', $item->assigned_to);
            }

            $esc_roles = DB::table('roles')
                ->select(
                    DB::raw('roles.name AS esc_name')
                )
                ->where('roles.id', '=', $item->esc_level_id)->get();

            $item->esc_level_name = json_encode($esc_roles);
            $item->esc_level_name = str_replace('[{"esc_name":"', '', $item->esc_level_name);
            $item->esc_level_name = str_replace('"}]', '', $item->esc_level_name);

            return $item;
        });

        return view('tickets.escalated')->with($data);
    }

    public function manageTickets($ticket_id = null)
    {
        $data['helpdesk_technicians'] = User::getHelpdeskTeam();

        $data['issue_categories'] = Issue::getIssueCategories();
        $data['esc_levels'] = EscalationLevel::getEscalationLevels();
        //dd($data['esc_levels']);
        // $data['esc_levels'] = Role::whereIn('id', array(2, 3))->get();

        $data['tickets'] = DB::table('tickets')
            ->select(
                DB::raw('tickets.*'),
                DB::raw('tickets.email AS submitter_email'),
                DB::raw('tickets.created_at AS ticket_created_at'),
                DB::raw('tickets_action.*'),
                DB::raw('tickets_status.*'),
                DB::raw('ticket_priority.*'),
                DB::raw('ticket_priority.*'),
                DB::raw('ticket_details.*'),
                DB::raw('issues_categories.*'),
                DB::raw('users.*'),
                DB::raw('ticket_replies.*'),
                DB::raw('ticket_replies.submitter as replier_submitter'),
                DB::raw('ticket_replies.created_at as reply_date'),
                DB::raw('esc_levels.*'),
                DB::raw('roles.id as role_id'),
                DB::raw('roles.name as role_name')
                // DB::raw('issue_subcategories.*'),
            )
            ->leftJoin('tickets_action', 'tickets.ticket_id', '=', 'tickets_action.id')
            ->leftJoin('tickets_status', 'tickets.status_id', '=', 'tickets_status.status_id')
            ->leftJoin('ticket_priority', 'tickets.priority_id', '=', 'ticket_priority.priority_id')
            ->leftJoin('ticket_details', 'tickets.ticket_id', '=', 'ticket_details.id')
            ->leftJoin('esc_levels', 'ticket_details.esc_level_id', '=', 'esc_levels.id')
            ->leftJoin('roles', 'ticket_details.esc_level_id', '=', 'roles.id')
            ->leftJoin('ticket_replies', 'tickets.ticket_id', '=', 'ticket_replies.ticket_id')
            ->leftJoin('issues_categories', 'ticket_details.issue_id', '=', 'issues_categories.issue_id')
            // ->leftJoin('issue_subcategories', 'issues_categories.issue_id', '=', 'issue_subcategories.issue_id')
            ->leftJoin('users', 'tickets.user_id', '=', 'users.id')
            ->where('tickets.ticket_id', '=', $ticket_id)
            ->orderBy('tickets.ticket_id', 'desc')
            ->first();

        // echo "<pre>";
        // print_r($data['tickets']);
        // exit;

        $data['ticket_replies'] = DB::table('ticket_replies')
            ->select(
                DB::raw('ticket_replies.*')
            )
            ->where('ticket_replies.ticket_id', '=', $ticket_id)
            ->orderBy('ticket_replies.reply_id', 'desc')
            ->get();

        foreach ($data['ticket_replies'] as $key => $value) {

            $message  = $value->message;
        }


        //    $variable = substr($message, 0, strpos($message, "From:"));

        // print_r($variable);


        $opening_time = $data['tickets']->ticket_created_at;
        $current_time = Carbon::now('Africa/Nairobi');
        $data['duration'] = $current_time->diffInMinutes($opening_time);

        // echo $data['duration'];
        // exit;

        $data['assigned_user'] = DB::table('users')
            ->select(
                DB::raw('users.name AS assigned_user_name')
            )
            ->leftJoin('tickets', 'users.id', '=', 'tickets.assigned_user_id')
            ->where('id', '=', $data['tickets']->assigned_user_id)->first();
        $data['created_user'] = DB::table('users')->where('id', '=', $data['tickets']->user_id)->first();
        $data['escalated_by'] = DB::table('users')->where('id', '=', $data['tickets']->assigned_user_id)->first();

        $data['attached_files'] = DB::table('ticket_details')->where('id', '=', $ticket_id)
            ->first();
        if ($data['tickets']->attached_file == '') {
            $data['attachments'] = "No attachments";
            $data['total_attachments'] = 0;
        } elseif ($data['tickets']->attached_file != '') {
            $files = explode(';',   $data['attached_files']->attached_file);
            $files = array_filter(array_map('trim', $files));
            $files = str_replace('["', '', $files);
            $files = str_replace('"]', '', $files);
            $files = str_replace('","', ',', $files);
            $files = str_replace('uploads\/email_attachments\/', '', $files);

            foreach ($files as $key => $value) {
                $files = $value;
            }
            $data['files'] = explode(',', $files);
            $data['total_attachments'] = count($data['files']);
        }
        return view('tickets.manage')->with($data);
    }

    public function workOnTicket(Request $request)
    {

        $assign_ticket_id = $request->ticket_id;
        $assign_tickets = DB::table('tickets')->select(DB::raw('tickets.*'), DB::raw('ticket_details.*'))
            ->leftJoin('ticket_details', 'tickets.ticket_id', '=', 'ticket_details.id')
            ->where('ticket_id', '=', $assign_ticket_id)->first();
        // dd($assign_tickets);
        $submitter_email = $assign_tickets->email;
        $submitter_name = $assign_tickets->submitter;
        $subject = $assign_tickets->subject;
        $ticket_no = $assign_tickets->ticket;

        $assigned_user = Auth::user();
        $assigned_user_id = $assigned_user->id;
        $assigned_name = $assigned_user->name;
        $assigned_email = $assigned_user->email;

        $status_id = 2;
        $assigned_at = Carbon::now();
        DB::table('tickets')->where('ticket_id', $assign_ticket_id)
            ->update([
                'assigned_user_id' => $assigned_user_id,
                'status_id' => $status_id
            ]);

        DB::table('ticket_details')->where('id', $assign_ticket_id)
            ->update([
                'assigned_at' => $assigned_at
            ]);

        $user = \Auth::user();

        $reply_array = array(
            'ticket_id' => $assign_ticket_id,
            'submitter' => ucwords($user->name),
            'message' => $user->name . ' confirmed working on the ticket ',
            'reply_type' => 'confirmed working on ticket'
        );

        $save_reply_details = DB::table('ticket_replies')->insertGetId($reply_array);

        // Send ack to the user
        $company = "Wananchi Group IT Team";
        $message = $assigned_name . " has been assigned/confirmed working on your ticket. We will get back to you with a resoultion.";
        $subject = 'Ticket' . '#' . $ticket_no . 'Assigned';

        $mailData = array(
            'name'     => $submitter_name,
            'email'     => $submitter_email,
            'ticket'     => $ticket_no,
            'subject'    => 'Ticket ' . '# ' . $ticket_no . ' Assigned',
            'message'   =>  $message,
            'company'    => $company
        );

        //dd($mailData);

        $resp = Mail::to($submitter_email)->send(new TicketAssignment($mailData));
        // Send ack to the user
        $company = "Wananchi Group IT Team";
        $message1 = "You have confirmed working on ticket " . $ticket_no;
        $subject = 'Ticket' . '#' . $ticket_no . 'Assignment';

        $mailData1 = array(
            'name'     => $assigned_name,
            'email'     => $assigned_email,
            'ticket'     => $ticket_no,
            'subject'    => 'Ticket ' . '# ' . $ticket_no . ' Assignment',
            'message'   =>  $message1,
            'company'    => $company
        );

        //dd($mailData);

        $resp = Mail::to($assigned_email)->send(new TicketAssigned($mailData1));

        toast('You have confirmed working on the ticket successfully', 'success', 'top-right');
        return back();
    }
    public function assignTicket(Request $request)
    {

        $assign_ticket_id = $request->ticket_id;
        $assign_tickets = DB::table('tickets')->select(DB::raw('tickets.*'), DB::raw('ticket_details.*'))
            ->leftJoin('ticket_details', 'tickets.ticket_id', '=', 'ticket_details.id')
            ->where('ticket_id', '=', $assign_ticket_id)->first();
        //dd($assign_tickets);
        $submitter_email = $assign_tickets->email;
        $submitter_name = $assign_tickets->submitter;
        $subject = $assign_tickets->subject;
        $ticket_no = $assign_tickets->ticket;


        $assigned_user_id = $request->input('helpdesk_user_id');
        $user_assigned = DB::table('users')->where('id', '=', $assigned_user_id)->first();
        $assigned_name = $user_assigned->name;
        $assigned_email = $user_assigned->email;

        //  dd($assigned_email);

        $message = "You have assigned the ticket to the helpdesk team";
        $status_id = 2;
        $assigned_at = Carbon::now();

        DB::table('tickets')->where('ticket_id', $assign_ticket_id)
            ->update([
                'assigned_user_id' => $assigned_user_id,
                'status_id' => $status_id
            ]);

        DB::table('ticket_details')->where('id', $assign_ticket_id)
            ->update([
                'assigned_at' => $assigned_at
            ]);

        $user = \Auth::user();
        $auth_name = $user->name;

        $reply_array = array(
            'ticket_id' => $assign_ticket_id,
            'submitter' => ucwords($user->name),
            'message' => 'Ticket assigned to ' . $user_assigned->name . ' by ' . $user->name,
            'reply_type' => 'assigned the ticket to team'
        );

        $save_reply_details = DB::table('ticket_replies')->insertGetId($reply_array);

        // Send ack to the technician
        $company = "Wananchi Group IT Team";
        $message = 'You have been assigned ticket ' . $ticket_no . ' by ' . $auth_name;
        $subject = 'Ticket' . '#' . $ticket_no . 'Assignment';

        $mailData = array(
            'name'     => $assigned_name,
            'email'     => $assigned_email,
            'ticket'     => $ticket_no,
            'subject'    => $subject,
            'message'   =>  $message,
            'company'    => $company
        );

        //dd($mailData);

        $resp = Mail::to($assigned_email)->send(new WorkOnTicket($mailData));
        // Send ack to the user
        $company = "Wananchi Group IT Team";
        $message1 = 'Your ticket ' . $ticket_no .  ' has been assigned to ' . $assigned_name . '. We will get back to you with a resoultion.';
        $subject = 'Ticket' . '#' . $ticket_no . 'Assignment';

        $mailData1 = array(
            'name'     => $submitter_name,
            'email'     => $submitter_email,
            'ticket'     => $ticket_no,
            'subject'    => 'Ticket ' . '# ' . $ticket_no . ' Assignment',
            'message'   =>  $message1,
            'company'    => $company
        );

        //dd($mailData);

        $resp = Mail::to($submitter_email)->send(new TicketInProgress($mailData1));

        toast('Ticket assigned successfully', 'success', 'top-right');
        return back();
    }

    public function closeTicket(Request $request)
    {
        $close_ticket = DB::table('tickets')->select(DB::raw('tickets.*'))->first();
        $issue_type_id = $request->input('issue_category_id');
        $issue_subtype_id = $request->input('subcategory_id');

        $close_ticket_id = $request->ticket_id;
        $reason = $request->input('reason');
        $closed_by = $request->input('closed_by');
        $status_id = 3;
        $closed_at = Carbon::now();
        $closed_date =  Carbon::now()->toDateString();
        DB::table('tickets')->where('ticket_id', $close_ticket_id)
            ->update(['status_id' => $status_id]);

        DB::table('ticket_details')->where('id', $close_ticket_id)
            ->update([
                'issue_type_id' => $issue_type_id, 'issue_subtype_id' => $issue_subtype_id, 'reason' => $reason,
                'closed_at' => $closed_at, 'closed_date' => $closed_date, 'closed_by' => $closed_by
            ]);

        // Save close reason has a ticket reply
        $user = \Auth::user();

        $reply_array = array(
            'ticket_id' => $close_ticket_id,
            'submitter' => ucwords($user->name),
            'message' => 'Ticket closed by ' . $user->name . ' Resaon for outage (RFO): ' . $reason,
            'reply_type' => 'closed the ticket'
        );

        $save_reply_details = DB::table('ticket_replies')->insertGetId($reply_array);

        toast('Ticket closed successfully', 'success', 'top-right');
        return back();
    }

    public function reopenTicket(Request $request)
    {
        $reopen_ticket_id = $request->ticket_id;

        $status_id = 2;

        DB::table('tickets')->where('ticket_id', $reopen_ticket_id)
            ->update(['status_id' => $status_id]);

        $user = \Auth::user();

        $reply_array = array(
            'ticket_id' => $reopen_ticket_id,
            'submitter' => ucwords($user->name),
            'message' => 'Ticket reopend by ' . $user->name,
            'reply_type' => 'reopened the ticket'
        );

        $save_reply_details = DB::table('ticket_replies')->insertGetId($reply_array);

        toast('Ticket reopened successfully', 'success', 'top-right');
        return back();
    }

    public function escalateTicket(Request $request)
    {
        $escalate_ticket = DB::table('tickets')->select(
            DB::raw('tickets.*'),
            DB::raw('ticket_details.*')
        )
            ->leftJoin('ticket_details', 'tickets.ticket_id', 'ticket_details.id')
            ->first();

        $escalate_ticket_id = $request->ticket_id;
        $esc_id = $request->input('esc_level_id');
        $esc_reason = $request->input('message');
        $reason = $request->input('message');
        $message = "You have successfully escalated the ticket to the next level";
        $escalated_at = Carbon::now();

        // Save escalation reason has a ticket reply
        $user = \Auth::user();
        $esc_level = DB::table('roles')->where('id', '=', $esc_id)->first();
        $esc_name = $esc_level->name;

        $reply_array = array(
            'ticket_id' => $escalate_ticket_id,
            'submitter' => ucwords($user->name),
            'message' => 'Ticket escalated by ' . $user->name .  ' to ' . $esc_name . ' Resaon for escalation: ' . $esc_reason,
            'reply_type' => 'escalated the ticket'
        );

        $save_reply_details = DB::table('ticket_replies')->insertGetId($reply_array);

        $esc_level_users = DB::table('users')
            ->select(
                DB::raw('users.id'),
                DB::raw('users.name as user_name'),
                DB::raw('users.email'),
                DB::raw('model_has_roles.*'),
                DB::raw('roles.id as role_idd'),
                DB::raw('roles.*')
            )
            ->leftJoin('model_has_roles', 'users.id', 'model_has_roles.model_id')
            ->leftJoin('roles', 'model_has_roles.role_id', 'roles.id')
            ->where('roles.id', '=', $esc_id)
            ->get();

        DB::table('ticket_details')->where('id', $escalate_ticket_id)
            ->update([
                'esc_level_id' => $esc_id,
                'esc_reason' => $esc_reason,
                'escalated_at' => $escalated_at
            ]);

        $ticket_number = $escalate_ticket->ticket;
        $subject = $escalate_ticket->subject;

        $subject = 'Ticket Escalation -' . $subject . ' ' . '(' . $ticket_number . ')';
        $esc_reason = $reason;
        $message = 'Ticket Number ' . ($ticket_number) . ' has been escalated to you';
        $company = "Wananchi Group IT Team";

        foreach ($esc_level_users as $users) {
            $name = $users->user_name;
            $email = $users->email;
            $escEmail = new \stdClass();
            $escEmail->name = $name;
            $escEmail->company = $company;
            $escEmail->subject = $subject;
            $escEmail->message = $message;
            $escEmail->reason = $reason;

            $mailData = array(
                'name'     => $name,
                'email'     => $email,
                'subject'    => $subject,
                'message'    => $message,
                'reason'     => $reason,
                'company'    => $company
            );
            Mail::to($users->email)->send(new TicketEscalation($mailData));
        }

        toast('Ticket escalated successfully', 'success', 'top-right');
        return back();
    }

    public function replyTicket(Request $request)
    {
        $user = \Auth::user();
        $ticket_id = $request->input('ticket_id');
        $reply = $request->input('reply');

        $ticket = DB::table('tickets')
            ->select(
                DB::raw('tickets.*'),
                DB::raw('ticket_details.*')
            )
            ->leftJoin('ticket_details', 'tickets.ticket_id', '=', 'ticket_details.id')
            ->where('tickets.ticket_id', '=', $ticket_id)
            ->first();

        $reply_array = array(
            'ticket_id' => $ticket_id,
            'submitter' => ucwords($user->name),
            'message' => $reply,
            'reply_type' => 'sent a reply'
        );

        $save_reply_details = DB::table('ticket_replies')->insertGetId($reply_array);

        $message_id = $ticket->message_id;
        $name =  $ticket->submitter;
        $email = $ticket->email;
        $ticket = $ticket->ticket;
        $subject = 'Reply to your ticket';
        // $subject = 'RE:' . $ticket->subject;
        // $subject = 'RE: ' . $subject;
        $company = "Wananchi Group IT Team";

        $replyEmail = new \stdClass();
        $replyEmail->name = $name;
        $replyEmail->ticket = $ticket;
        $replyEmail->company = $company;
        $replyEmail->subject = $subject;
        $replyEmail->message = $reply;

        $mailData = array(
            'name'     => $name,
            'email'     => $email,
            'ticket'     => $ticket,
            'subject'    => 'Reply to your ticket ' . $ticket,
            'message'   => $reply,
            'company'    => $company,
            'message_id' => $message_id
        );

        $resp = Mail::to($email)->send(new ReplyToTicket($mailData));

        toast('Reply sent successfully', 'success', 'top-right');

        return back();
    }

    public function deleteTicket($ticket)
    {
        $resp = DB::table('tickets')->where('ticket_id', $ticket)->delete();
        toast('Ticket deleted successfully', 'success', 'top-right');
        return redirect('tickets/all');
    }
}