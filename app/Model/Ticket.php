<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Support\Facades\Auth;

class Ticket extends Model
{
    protected $table = 'tickets';
    protected $primaryKey = 'ticket_id';

    public static function getTickets()
    {

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
                DB::raw('issue_subcategories.*'),
                DB::raw('users.*')
            )
            ->leftJoin('tickets_action', 'tickets.ticket_id', '=', 'tickets_action.id')
            ->leftJoin('tickets_status', 'tickets.status_id', '=', 'tickets_status.status_id')
            ->leftJoin('ticket_priority', 'tickets.priority_id', '=', 'ticket_priority.priority_id')
            ->leftJoin('ticket_details', 'tickets.ticket_id', '=', 'ticket_details.id')
            ->leftJoin('issues_categories', 'ticket_details.issue_type_id', '=', 'issues_categories.issue_id')
            ->leftjoin('issue_subcategories', 'ticket_details.issue_subtype_id', '=', 'issue_subcategories.issue_subcategory_id')
            ->leftJoin('users', 'tickets.user_id', '=', 'users.id')
            ->orderBy('tickets.ticket_id', 'desc')
            ->get();

        return $data['tickets'];
    }

    public static function ticketsOpen()
    {
        $status_id = 1;
        $data['tickets_open'] = DB::table('tickets')
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
                // DB::raw('issue_subcategories.*'),
                DB::raw('users.*')
            )
            ->leftJoin('tickets_action', 'tickets.ticket_id', '=', 'tickets_action.id')
            ->leftJoin('tickets_status', 'tickets.status_id', '=', 'tickets_status.status_id')
            ->leftJoin('ticket_priority', 'tickets.priority_id', '=', 'ticket_priority.priority_id')
            ->leftJoin('ticket_details', 'tickets.ticket_id', '=', 'ticket_details.id')
            ->leftJoin('issues_categories', 'ticket_details.issue_id', '=', 'issues_categories.issue_id')
            // ->leftJoin('issue_subcategories', 'issues_categories.issue_id', '=', 'issue_subcategories.issue_id')
            ->leftJoin('users', 'tickets.user_id', '=', 'users.id')
            ->where('tickets.status_id', '=', $status_id)
            ->orderBy('tickets.ticket_id', 'desc')
            ->get();

        return $data['tickets_open'];
    }
    public static function ticketsinProgress()
    {
        $user = Auth::user();
        ~$user_role = $user->getRoleNames()->first();
        if ($user_role == "Admin") {
            $compare_field = "tickets.ticket_id";
            $compare_operator = ">=";
            $compare_value = 1;
        } elseif ($user_role == "Technician") {
            $compare_field = "tickets.ticket_id";
            $compare_operator = ">=";
            $compare_value = 1;
        } elseif ($user_role == "System Admin") {
            $compare_field = "ticket_details.esc_level_id";
            $compare_operator = "=";
            $compare_value = 1;
        } elseif ($user_role == "IT Manager") {
            $compare_field = "ticket_details.esc_level_id";
            $compare_operator = "=";
            $compare_value = 2;
        } elseif ($user_role == "Standard User") {
            $compare_field = "ticket_details.esc_level_id";
            $compare_operator = "=";
            $compare_value = 1;
        }
        $status_id = 2;
        $data['tickets_in_progress'] = DB::table('tickets')
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
                // DB::raw('issue_subcategories.*'),
                DB::raw('users.*')
            )
            ->leftJoin('tickets_action', 'tickets.ticket_id', '=', 'tickets_action.id')
            ->leftJoin('tickets_status', 'tickets.status_id', '=', 'tickets_status.status_id')
            ->leftJoin('ticket_priority', 'tickets.priority_id', '=', 'ticket_priority.priority_id')
            ->leftJoin('ticket_details', 'tickets.ticket_id', '=', 'ticket_details.id')
            ->leftJoin('issues_categories', 'ticket_details.issue_id', '=', 'issues_categories.issue_id')
            // ->leftJoin('issue_subcategories', 'issues_categories.issue_id', '=', 'issue_subcategories.issue_id')
            ->leftJoin('users', 'tickets.user_id', '=', 'users.id')
            ->where('tickets.status_id', '=', $status_id)
            ->where($compare_field, $compare_operator, $compare_value)
            ->orderBy('tickets.ticket_id', 'desc')
            ->get();

        return $data['tickets_in_progress'];
    }

    public static function ticketsClosed()
    {
        $status_id = 3;
        $data['tickets_closed'] = DB::table('tickets')
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
                // DB::raw('issue_subcategories.*'),
                DB::raw('users.*')
            )
            ->leftJoin('tickets_action', 'tickets.ticket_id', '=', 'tickets_action.id')
            ->leftJoin('tickets_status', 'tickets.status_id', '=', 'tickets_status.status_id')
            ->leftJoin('ticket_priority', 'tickets.priority_id', '=', 'ticket_priority.priority_id')
            ->leftJoin('ticket_details', 'tickets.ticket_id', '=', 'ticket_details.id')
            ->leftJoin('issues_categories', 'ticket_details.issue_id', '=', 'issues_categories.issue_id')
            // ->leftJoin('issue_subcategories', 'issues_categories.issue_id', '=', 'issue_subcategories.issue_id')
            ->leftJoin('users', 'tickets.user_id', '=', 'users.id')
            ->where('tickets.status_id', '=', $status_id)
            ->orderBy('tickets.ticket_id', 'desc')
            ->get();

        return $data['tickets_closed'];
    }

    public static function myAssignedTickets()
    {
        $auth_user_id = Auth::user()->id;
        $data['my_assigned'] = DB::table('tickets')
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
                // DB::raw('issue_subcategories.*'),
                DB::raw('users.*')
            )
            ->leftJoin('tickets_action', 'tickets.ticket_id', '=', 'tickets_action.id')
            ->leftJoin('tickets_status', 'tickets.status_id', '=', 'tickets_status.status_id')
            ->leftJoin('ticket_priority', 'tickets.priority_id', '=', 'ticket_priority.priority_id')
            ->leftJoin('ticket_details', 'tickets.ticket_id', '=', 'ticket_details.id')
            ->leftJoin('issues_categories', 'ticket_details.issue_id', '=', 'issues_categories.issue_id')
            // ->leftJoin('issue_subcategories', 'issues_categories.issue_id', '=', 'issue_subcategories.issue_id')
            ->leftJoin('users', 'tickets.user_id', '=', 'users.id')
            ->where('tickets.assigned_user_id', '=', $auth_user_id)
            ->orderBy('tickets.ticket_id', 'desc')
            ->get();

        return $data['my_assigned'];
    }

    public static function getTicketDetails()
    {
        $data['tickets'] = DB::table('tickets')
            ->select(
                DB::raw('tickets.*'),
                DB::raw('tickets_action.*'),
                DB::raw('tickets_status.*'),
                DB::raw('ticket_priority.*'),
                DB::raw('ticket_priority.*'),
                DB::raw('ticket_details.*'),
                DB::raw('issues_categories.*'),
                // DB::raw('issue_subcategories.*'),
                DB::raw('users.*')
            )
            ->leftJoin('tickets_action', 'tickets.ticket_id', '=', 'tickets_action.ticket_id')
            ->leftJoin('tickets_status', 'tickets.status_id', '=', 'tickets_status.status_id')
            ->leftJoin('ticket_priority', 'tickets.priority_id', '=', 'ticket_priority.priority_id')
            ->leftJoin('ticket_details', 'tickets.ticket_id', '=', 'ticket_details.id')
            ->leftJoin('issues_categories', 'ticket_details.issue_id', '=', 'issues_categories.issue_id')
            // ->leftJoin('issue_subcategories', 'issues_categories.issue_id', '=', 'issue_subcategories.issue_id')
            ->leftJoin('users', 'tickets.user_id', '=', 'users.id')
            // ->where('tickets.ticket_id', '=', $ticket_id)
            ->orderBy('tickets.ticket_id', 'desc')
            ->first();

        return $data['tickets'];
    }
}