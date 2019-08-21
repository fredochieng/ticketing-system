<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Model\Ticket;
use DB;
use ExcelReport;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['ticket_status'] = DB::table('tickets_status')->orderBy('status_id', 'asc')->get();
        $data['tickets'] = Ticket::getTickets();
        $data['tickets']->map(function ($item) {

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

        return view('reports.index')->with($data);
    }

    public function displayReports(Request $request)
    {
        $data['ticket_status'] = DB::table('tickets_status')->orderBy('status_id', 'asc')->get();
        $data['tickets'] = Ticket::getTickets();
        $data['tickets']->map(function ($item) {

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

            $closed_name = DB::table('users')
                ->select(
                    DB::raw('users.name AS closed_name')
                )
                ->where('users.id', '=', $item->closed_by)->get();

            $item->closed_by = json_encode($closed_name);
            $item->closed_by = str_replace('[{"closed_name":"', '', $item->closed_by);
            $item->closed_by = str_replace('"}]', '', $item->closed_by);

            if ($item->closed_by == '[]') {
                $item->closed_by = 'N/A';
            } else {

                $item->closed_by = str_replace('"}]', '', $item->closed_by);
            }
            if ($item->closed_at == '') {
                $item->time_taken = 'N/A';
            } else {

                $item->time_taken = Carbon::parse($item->closed_at)->diffInHours(Carbon::parse($item->ticket_created_at));
            }

            return $item;
        });

        // echo "<pre>";
        // print_r($data['tickets']);
        // exit;

        $status_id = $request->input('status_id');

        $date_range = $request->input('date_range');
        $date_range = (array) $date_range;
        $date_range = str_replace(' - ', ',', $date_range);

        $data['status_id'] = $status_id;

        foreach ($date_range as $key => $value) {
            $date_range = $value;
        }

        $date_range = explode(',', $date_range);
        $data['start_date'] = date('Y-m-d', strtotime($date_range[0]));
        $data['end_date'] = date('Y-m-d', strtotime($date_range[1]));

        $data['status_name'] = $data['ticket_status']->where('status_id', '=', $status_id)->pluck('status_name')->first();

        if ($status_id == 4) {
            $data['tickets'] = $data['tickets']->whereBetween(
                'ticket_date',
                array($data['start_date'], $data['end_date'])
            );
        } else {

            $data['tickets'] = $data['tickets']->where('status_id', '=>', $status_id)
                ->whereBetween(
                    'ticket_date',
                    array($data['start_date'], $data['end_date'])
                );
        }

        return view('reports.view')->with($data);
    }

    public function ExportReports(Request $request)
    {
        $data['ticket_status'] = DB::table('tickets_status')->orderBy('status_id', 'asc')->get();
        $data['tickets'] = Ticket::getTickets();
        $data['tickets']->map(function ($item) {

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

            $closed_name = DB::table('users')
                ->select(
                    DB::raw('users.name AS closed_name')
                )
                ->where('users.id', '=', $item->closed_by)->get();

            $item->closed_by = json_encode($closed_name);
            $item->closed_by = str_replace('[{"closed_name":"', '', $item->closed_by);
            $item->closed_by = str_replace('"}]', '', $item->closed_by);

            if ($item->closed_by == '[]') {
                $item->closed_by = 'N/A';
            } else {

                $item->closed_by = str_replace('"}]', '', $item->closed_by);
            }
            if ($item->closed_at == '') {
                $item->time_taken = 'N/A';
            } else {

                $item->time_taken = Carbon::parse($item->closed_at)->diffInHours(Carbon::parse($item->ticket_created_at));
            }

            return $item;
        });

        $status_id = $request->input('status_id');

        $date_range = $request->input('date_range');
        $date_range = (array) $date_range;
        $date_range = str_replace(' - ', ',', $date_range);

        $data['status_id'] = $status_id;

        foreach ($date_range as $key => $value) {
            $date_range = $value;
        }

        $date_range = explode(',', $date_range);
        $data['start_date'] = date('Y-m-d', strtotime($date_range[0]));
        $data['end_date'] = date('Y-m-d', strtotime($date_range[1]));

        $data['status_name'] = $data['ticket_status']->where('status_id', '=', $status_id)->pluck('status_name')->first();

        if ($status_id == 4) {
            $data['tickets_report'] = $data['tickets']->whereBetween(
                'ticket_date',
                array($data['start_date'], $data['end_date'])
            );

            $data_array[] = array('Ticket', 'Subject', 'Submitter', 'Date Opened', 'Status', 'Assigned To', 'Issue Category', 'Issue Subcategory', 'RFO', 'Date Closed', 'Time Taken', 'Closed By');
            $text_title_disp = "Tickets_Report_" . $data['start_date'] . " to " . $data['end_date'];

            foreach ($data['tickets_report'] as $value) {
                if ($value->status_id == 1) {
                    $status = 'Open';
                } elseif ($value->status_id == 2) {
                    $status = 'In Progress';
                } elseif ($value->status_id == 3) {
                    $status = 'Closed';
                }

                if ($value->issue_name == '') {
                    $issue_name = 'N/A';
                } else {
                    $issue_name = $value->issue_name;
                }
                if ($value->issue_subcategory_name == '') {
                    $issue_subcategory_name = 'N/A';
                } else {
                    $issue_subcategory_name = $value->issue_subcategory_name;
                }

                if ($value->reason == '') {
                    $reason = 'N/A';
                } else {
                    $reason = $value->reason;
                }
                if ($value->time_taken == '') {
                    $time_taken = 'N/A';
                } else {
                    $time_taken = $value->time_taken;
                }
                if ($value->closed_at == '') {
                    $closed_at = 'N/A';
                } else {
                    $closed_at = $value->closed_at;
                }
                if ($value->closed_by == '') {
                    $closed_by = 'N/A';
                } else {
                    $closed_by = $value->closed_by;
                }

                $data_array[] = array(
                    $value->ticket,
                    $value->subject,
                    $value->submitter,
                    $value->ticket_created_at,
                    $status,
                    $value->assigned_to,
                    $issue_name,
                    $issue_subcategory_name,
                    $reason,
                    $closed_at,
                    $time_taken,
                    $closed_by
                );
            }
            $GLOBALS['data_array'] = $data_array;
            \Excel::create(str_replace(' ', '_', $text_title_disp), function ($excel) {
                $excel->sheet('Sheetname', function ($sheet) {
                    $sheet->fromArray($GLOBALS['data_array']);
                });
            })->export('xlsx');
        } else {

            $data['tickets_report'] = $data['tickets']->where('status_id', '=>', $status_id)
                ->whereBetween(
                    'ticket_date',
                    array($data['start_date'], $data['end_date'])
                );

            $data_array[] = array('Ticket', 'Subject', 'Submitter', 'Date Opened', 'Status', 'Assigned To', 'Issue Category', 'Issue Subcategory', 'RFO', 'Date Closed', 'Time Taken', 'Closed By');
            $text_title_disp = "Tickets_Report_" . $data['start_date'] . " to " . $data['end_date'];

            foreach ($data['tickets_report'] as $value) {
                if ($value->status_id == 1) {
                    $status = 'Open';
                } elseif ($value->status_id == 2) {
                    $status = 'In Progress';
                } elseif ($value->status_id == 3) {
                    $status = 'Closed';
                }

                if ($value->issue_name == '') {
                    $issue_name = 'N/A';
                } else {
                    $issue_name = $value->issue_name;
                }
                if ($value->issue_subcategory_name == '') {
                    $issue_subcategory_name = 'N/A';
                } else {
                    $issue_subcategory_name = $value->issue_subcategory_name;
                }

                if ($value->reason == '') {
                    $reason = 'N/A';
                } else {
                    $reason = $value->reason;
                }
                if ($value->time_taken == '') {
                    $time_taken = 'N/A';
                } else {
                    $time_taken = $value->time_taken;
                }
                if ($value->closed_at == '') {
                    $closed_at = 'N/A';
                } else {
                    $closed_at = $value->closed_at;
                }
                if ($value->closed_by == '') {
                    $closed_by = 'N/A';
                } else {
                    $closed_by = $value->closed_by;
                }

                $data_array[] = array(
                    $value->ticket,
                    $value->subject,
                    $value->submitter,
                    $value->ticket_created_at,
                    $status,
                    $value->assigned_to,
                    $issue_name,
                    $issue_subcategory_name,
                    $reason,
                    $closed_at,
                    $time_taken,
                    $closed_by
                );
            }
            $GLOBALS['data_array'] = $data_array;
            \Excel::create(str_replace(' ', '_', $text_title_disp), function ($excel) {
                $excel->sheet('Sheetname', function ($sheet) {
                    $sheet->fromArray($GLOBALS['data_array']);
                });
            })->export('xlsx');
        }
    }

    public function ticketAssignmentReport()
    {
        $data['tickets'] = DB::table('tickets')
            ->select(
                DB::raw('tickets.status_id'),
                DB::raw('tickets.assigned_user_id'),
                DB::raw('COUNT(CASE WHEN tickets.status_id = 2 THEN 1 END) AS tickets_in_progress'),
                DB::raw('COUNT(CASE WHEN tickets.status_id = 3 THEN 1 END) AS tickets_closed')
            )
            ->whereIn('tickets.status_id', array(2, 3))
            ->groupBy('tickets.assigned_user_id')
            ->get();

        $data['tickets']->map(function ($item) {

            $user = DB::table('users')
                ->select(
                    DB::raw('users.name AS assigned_name'),
                    DB::raw('users.email AS assigned_email')
                )
                ->where('users.id', '=', $item->assigned_user_id)->first();

            $item->user_name = $user->assigned_name;
            $item->user_email = $user->assigned_email;

            return $item;
        });
        // echo "<pre>";
        // print_r($data['tickets']);
        // exit;

        return view('reports.ticket_assignment_report')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}