<?php

namespace App\Model;

use DB;
use Carbon\Carbon;
use DateInterval;
use DatePeriod;
use DateTime;

use Illuminate\Database\Eloquent\Model;

class DailyTicketsSummary extends Model
{
    protected $table = 'daily_tickets_summary';

    public static function getTicketsSumamry()
    {
        $today = Carbon::now('Africa/Nairobi')->toDateString();
        $start = Carbon::now('Africa/Nairobi')->subDays(6)->toDateString();

        $start_date = new DateTime($start);
        $end_date   = new DateTime($today);

        $dates = array();
        for ($i = $start_date; $i <= $end_date; $i->modify('+1 day')) {

            $dates[] = $i->format("Y-m-d");
        }

        $ticket_summary = DB::table('daily_tickets_summary')
            ->whereIn('date', $dates)->get();

        return $ticket_summary;
    }
}