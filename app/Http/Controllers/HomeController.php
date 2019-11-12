<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Model\Ticket;
use App\Model\DailyTicketsSummary;
use App\User;
use DB;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        // dd($request->user()->getAllPermissions(), $request->user()->hasPermissionTo('newperm'));

        // $per = DB::table('permissions')->get();
        // dd($per);
        $today = Carbon::now('Africa/Nairobi')->toDateString();
        $data['total_tickets'] = count(Ticket::getTickets());
        $data['esc_tickets'] = count(Ticket::getTickets()->where('esc_level_id', '!=', ''));
        $data['today_tickets'] = count(Ticket::getTickets()->where('ticket_date', '==', $today));
        $data['today_closed_tickets'] = count(Ticket::getTickets()->where('closed_date', '==', $today));
        $data['open_tickets'] = count(Ticket::ticketsOpen());
        $data['in_progress'] = count(Ticket::ticketsinProgress());
        $data['closed'] = count(Ticket::ticketsClosed());
        $data['total_users'] = count(User::getUsers());

        if ($data['total_tickets'] == 0) {
            $data['total_tickets'] = 0;
            $data['open_per'] = 0;
            $data['in_progress_per'] = 0;
            $data['closed_per'] = 0;
        } else {

            $data['open_per'] = ($data['open_tickets'] * 100) / $data['total_tickets'];
            $data['in_progress_per'] = ($data['in_progress'] * 100) / $data['total_tickets'];
            $data['closed_per'] = ($data['closed'] * 100) / $data['total_tickets'];
        }

        $tickets_summary = DailyTicketsSummary::getTicketsSumamry();

        $all_dates = array();
        $all_tickets = array();
        $all_open = array();
        $all_in_progress = array();
        $all_closed = array();

        foreach ($tickets_summary as $key => $value) {
            $all_dates[] = $value->date;
            $all_tickets[] = $value->all_tickets;
            $all_open[] = $value->open_tickets;
            $all_in_progress[] = $value->in_progress;
            $all_closed[] = $value->closed_tickets;
        }

        $data['all_dates'] = json_encode($all_dates, true);
        $data['all_tickets'] = json_encode($all_tickets, true);
        $data['all_open'] = json_encode($all_open, true);
        $data['all_in_progress'] = json_encode($all_in_progress, true);
        $data['all_closed'] = json_encode($all_closed, true);

        return view('home')->with($data);
    }
}