<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use DB;
use Carbon\Carbon;

class DailyTicketsSummaryJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    private $date;

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
        $today = $this->date->toDateString();
        //$today = '2019-08-09';
        $start_date = $this->date->startOfMonth()->toDateString();

        $opened_tickets_summary = DB::table('tickets')
            ->select(
                DB::raw('tickets.status_id'),
                DB::raw('tickets.ticket_date'),
                DB::raw('COUNT(tickets.ticket_id) AS all_tickets'),
                DB::raw('COUNT(CASE WHEN tickets.status_id = 1 THEN 1 END) AS open_tickets'),
                DB::raw('COUNT(CASE WHEN tickets.status_id = 2 THEN 1 END) AS in_progress_tickets')
            )
            //->whereRaw("CAST(tickets.created_at as DATE) = '" . $today . "'")
            ->whereBetween('tickets.ticket_date', array($start_date, $today))
            ->groupBy('tickets.ticket_date')
            ->get();

        // echo "<pre>";
        // print_r($opened_tickets_summary);
        // exit;

        $closed_tickets_summary = DB::table('tickets')
            ->select(
                DB::raw('tickets.status_id'),
                DB::raw('ticket_details.id'),
                DB::raw('ticket_details.closed_date'),
                DB::raw('COUNT(CASE WHEN tickets.status_id = 3 THEN 1 END) AS closed_tickets')
            )
            ->leftJoin('ticket_details', 'tickets.ticket_id', 'ticket_details.id')
            //->whereRaw("ticket_details.closed_date = '" . $today . "'")
            // ->whereRaw("ticket_details.closed_date = '" . $today . "'")
            ->whereBetween('ticket_details.closed_date', array($start_date, $today))
            ->groupBy('ticket_details.closed_date')
            ->get();

        // echo "<pre>";
        // print_r($closed_tickets_summary);
        // exit;

        foreach ($opened_tickets_summary as $key => $value) {

            DB::table('daily_tickets_summary')->where('date', '=', $today)->upsert(
                [
                    'date' => $value->ticket_date, 'all_tickets' => $value->all_tickets, 'open_tickets' => $value->open_tickets,
                    'in_progress' => $value->in_progress_tickets
                ],
                ['date'],
                ['all_tickets', 'open_tickets', 'in_progress', 'updated_at']
            );
        }

        foreach ($closed_tickets_summary as $key => $value) {

            DB::table('daily_tickets_summary')->where('date', '=', $today)->upsert(
                [
                    'date' => $value->closed_date, 'closed_tickets' => $value->closed_tickets
                ],
                ['date'],
                ['closed_tickets', 'updated_at']
            );
        }
    }
}
