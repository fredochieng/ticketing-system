<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Model\Ticket;
use App\Model\Asset;
use App\Model\Issue;
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
        $data['countries'] = DB::table('countries')->orderBy('country_id', 'asc')->get();
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
        $data['countries'] = DB::table('countries')->orderBy('country_id', 'asc')->get();

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
                $item->time_taken = Carbon::parse($item->closed_at)->diffInSeconds(Carbon::parse($item->ticket_created_at));
                $seconds = $item->time_taken;
                $hours = floor($seconds / 3600);
                $minutes = floor(($seconds / 60) % 60);
                $seconds = $seconds % 60;

                $item->time_taken = sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
            }

            return $item;
        });

        $status_id = $request->input('status_id');
        $country_id = $request->input('country_id');

        $date_range = $request->input('date_range');
        $date_range = (array) $date_range;
        $date_range = str_replace(' - ', ',', $date_range);

        $data['status_id'] = $status_id;
        $data['country_id'] = $country_id;

        foreach ($date_range as $key => $value) {
            $date_range = $value;
        }

        $date_range = explode(',', $date_range);
        $data['start_date'] = date('Y-m-d', strtotime($date_range[0]));
        $data['end_date'] = date('Y-m-d', strtotime($date_range[1]));

        $data['status_name'] = $data['ticket_status']->where('status_id', '=', $status_id)->pluck('status_name')->first();
        if (!empty($country_id)) {
            $data['country_name'] = $data['countries']->where('country_id', '=', $country_id)->pluck('country_name')->first();
        } else {
            $data['country_name'] = 'ALL COUNTRIES';
        }

        if ($status_id == 4 && $country_id != '') {
            $data['tickets'] = $data['tickets']
                ->whereBetween('ticket_date', array($data['start_date'], $data['end_date']))
                ->where('country_id', $country_id);
        } elseif ($status_id == 4 && $country_id == '') {
            $data['tickets'] = $data['tickets']
                ->whereBetween('ticket_date', array($data['start_date'], $data['end_date']));
        } elseif ($status_id != 4 && $country_id != '') {
            $data['tickets'] = $data['tickets']->where('status_id', '=>', $status_id)
                ->whereBetween(
                    'ticket_date',
                    array($data['start_date'], $data['end_date'])
                )
                ->where('country_id', $country_id);
        } elseif ($status_id != 4 && $country_id == '') {
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

                $item->time_taken = Carbon::parse($item->closed_at)->diffInSeconds(Carbon::parse($item->ticket_created_at));
                $seconds = $item->time_taken;
                $hours = floor($seconds / 3600);
                $minutes = floor(($seconds / 60) % 60);
                $seconds = $seconds % 60;
                $item->time_taken = sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
            }

            return $item;
        });

        $status_id = $request->input('status_id');
        $country_id = $request->input('country_id');

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

        if ($status_id == 4 && $country_id != '') {
            $data['tickets_report'] = $data['tickets']->whereBetween(
                'ticket_date',
                array($data['start_date'], $data['end_date'])
            )
                ->where('country_id', $country_id);

            $data_array[] = array('Ticket', 'Subject', 'Date Opened', 'Status', 'Assigned To', 'Country', 'Issue Category', 'Issue Subcategory', 'RFO', 'Date Closed', 'Time Taken', 'Closed By');
            $text_title_disp = "Tickets_Report_" . $data['start_date'] . " to " . $data['end_date'];

            foreach ($data['tickets_report'] as $value) {
                if ($value->status_id == 1) {
                    $status = 'Open';
                } elseif ($value->status_id == 2) {
                    $status = 'In Progress';
                } elseif ($value->status_id == 3) {
                    $status = 'Closed';
                } elseif ($value->status_id == 5) {
                    $status = 'Deleted';
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
                    $value->ticket_created_at,
                    $status,
                    $value->assigned_to,
                    $value->country_name,
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
        } elseif ($status_id == 4 && $country_id == '') {
            $data['tickets_report'] = $data['tickets']->whereBetween(
                'ticket_date',
                array($data['start_date'], $data['end_date'])
            );

            $data_array[] = array('Ticket', 'Subject', 'Date Opened', 'Status', 'Assigned To', 'Country', 'Issue Category', 'Issue Subcategory', 'RFO', 'Date Closed', 'Time Taken', 'Closed By');
            $text_title_disp = "Tickets_Report_" . $data['start_date'] . " to " . $data['end_date'];

            foreach ($data['tickets_report'] as $value) {
                if ($value->status_id == 1) {
                    $status = 'Open';
                } elseif ($value->status_id == 2) {
                    $status = 'In Progress';
                } elseif ($value->status_id == 3) {
                    $status = 'Closed';
                } elseif ($value->status_id == 5) {
                    $status = 'Deleted';
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
                    // $value->submitter,
                    $value->ticket_created_at,
                    $status,
                    $value->assigned_to,
                    $value->country_name,
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
        } elseif ($status_id != 4 && $country_id != '') {

            $data['tickets_report'] = $data['tickets']->where('status_id', '=>', $status_id)
                ->whereBetween(
                    'ticket_date',
                    array($data['start_date'], $data['end_date'])
                )
                ->where('country_id', $country_id);

            dd($data['tickets_report']);

            $data_array[] = array('Ticket', 'Subject', 'Date Opened', 'Status', 'Assigned To', 'Country', 'Issue Category', 'Issue Subcategory', 'RFO', 'Date Closed', 'Time Taken', 'Closed By');
            $text_title_disp = "Tickets_Report_" . $data['start_date'] . " to " . $data['end_date'];

            foreach ($data['tickets_report'] as $value) {
                if ($value->status_id == 1) {
                    $status = 'Open';
                } elseif ($value->status_id == 2) {
                    $status = 'In Progress';
                } elseif ($value->status_id == 3) {
                    $status = 'Closed';
                } elseif ($value->status_id == 5) {
                    $status = 'Deleted';
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
                    //$value->submitter,
                    $value->ticket_created_at,
                    $status,
                    $value->assigned_to,
                    $value->country_name,
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
        } elseif ($status_id != 4 && $country_id == '') {

            $data['tickets_report'] = $data['tickets']->where('status_id', '=>', $status_id)
                ->whereBetween(
                    'ticket_date',
                    array($data['start_date'], $data['end_date'])
                );

            $data_array[] = array('Ticket', 'Subject', 'Date Opened', 'Status', 'Assigned To', 'Country', 'Issue Category', 'Issue Subcategory', 'RFO', 'Date Closed', 'Time Taken', 'Closed By');
            $text_title_disp = "Tickets_Report_" . $data['start_date'] . " to " . $data['end_date'];

            foreach ($data['tickets_report'] as $value) {
                if ($value->status_id == 1) {
                    $status = 'Open';
                } elseif ($value->status_id == 2) {
                    $status = 'In Progress';
                } elseif ($value->status_id == 3) {
                    $status = 'Closed';
                } elseif ($value->status_id == 5) {
                    $status = 'Deleted';
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
                    //$submitter,
                    $value->ticket_created_at,
                    $status,
                    $value->assigned_to,
                    $value->country_name,
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

        return view('reports.ticket_assignment_report')->with($data);
    }

    public function categoryReport(Request $request)
    {
        $date_range = $request->input('date_range');
        if (!empty($date_range)) {
            $date_range = (array) $date_range;
            $date_range = str_replace(' - ', ',', $date_range);

            foreach ($date_range as $key => $value) {
                $date_range = $value;
            }

            $date_range = explode(',', $date_range);
            $data['start_date'] = date('Y-m-d', strtotime($date_range[0]));
            $data['end_date'] = date('Y-m-d', strtotime($date_range[1]));
            $data['date_filtered'] = 'Y';

            $category_report = DB::table('tickets')
                ->select(
                    DB::raw('tickets.ticket_id'),
                    DB::raw('tickets.status_id'),
                    DB::raw('ticket_details.id'),
                    DB::raw('ticket_details.issue_type_id'),
                    DB::raw('ticket_details.closed_date'),
                    DB::raw('COUNT(CASE WHEN ticket_details.issue_type_id = 2 THEN 1 END) AS hardware'),
                    DB::raw('COUNT(CASE WHEN ticket_details.issue_type_id = 3 THEN 1 END) AS pass_reset'),
                    DB::raw('COUNT(CASE WHEN ticket_details.issue_type_id = 4 THEN 1 END) AS sms'),
                    DB::raw('COUNT(CASE WHEN ticket_details.issue_type_id = 5 THEN 1 END) AS software'),
                    DB::raw('COUNT(CASE WHEN ticket_details.issue_type_id = 6 THEN 1 END) AS e1_lines'),
                    DB::raw('COUNT(CASE WHEN ticket_details.issue_type_id = 7 THEN 1 END) AS lan'),
                    DB::raw('COUNT(CASE WHEN ticket_details.issue_type_id = 8 THEN 1 END) AS new_user_setup'),
                    DB::raw('COUNT(CASE WHEN ticket_details.issue_type_id = 9 THEN 1 END) AS sys_maintenance'),
                    DB::raw('COUNT(CASE WHEN ticket_details.issue_type_id = 10 THEN 1 END) AS systems'),
                    DB::raw('COUNT(CASE WHEN ticket_details.issue_type_id = 11 THEN 1 END) AS internet_conn'),
                    DB::raw('COUNT(CASE WHEN ticket_details.issue_type_id = 12 THEN 1 END) AS user_exit'),
                    DB::raw('COUNT(CASE WHEN ticket_details.issue_type_id = 13 THEN 1 END) AS power_failure'),
                    DB::raw('COUNT(CASE WHEN ticket_details.issue_type_id = 14 THEN 1 END) AS general'),
                    DB::raw('COUNT(tickets.status_id = 3) AS total_closed'),
                    DB::raw('issues_categories.issue_id'),
                    DB::raw('issues_categories.issue_name')
                )
                ->Join('ticket_details', 'tickets.ticket_id', '=', 'ticket_details.id')
                ->Join('issues_categories', 'ticket_details.issue_type_id', 'issues_categories.issue_id')
                ->where('tickets.status_id', '=', 3)
                ->orderBy('ticket_details.closed_date', 'asc')
                ->whereBetween(
                    'ticket_details.closed_date',
                    array($data['start_date'], $data['end_date'])
                )
                ->get();

            $all_dates = array();
            $all_closed = array();
            $all_issues = array();

            $all_hardware = array();
            $all_pass_reset = array();
            $all_sms = array();
            $all_software = array();
            $all_e1_lines = array();
            $all_lan = array();
            $all_new_user_setup = array();
            $all_sys_maintenance = array();
            $all_systems = array();
            $all_internet_conn = array();
            $all_user_exit = array();
            $all_power_failure = array();
            $all_general = array();

            foreach ($category_report as $key => $value) {
                $all_dates[] = $value->closed_date;
                $all_issues[] = $value->issue_name;

                $all_hardware[] = $value->hardware;
                $all_pass_reset[] = $value->pass_reset;
                $all_sms[] = $value->sms;
                $all_software[] = $value->software;
                $all_e1_lines[] = $value->e1_lines;
                $all_lan[] = $value->lan;
                $all_new_user_setup[] = $value->new_user_setup;
                $all_sys_maintenance[] = $value->sys_maintenance;
                $all_systems[] = $value->systems;
                $all_internet_conn[] = $value->internet_conn;
                $all_user_exit[] = $value->user_exit;
                $all_power_failure[] = $value->power_failure;
                $all_general[] = $value->general;
            }
            $data['all_dates'] = json_encode($all_dates, true);
            // $data['all_closed'] = json_encode($all_closed, true);
            $data['all_issues'] = json_encode($all_issues, true);

            $data['all_hardware'] = json_encode($all_hardware, true);
            $data['all_pass_reset'] = json_encode($all_pass_reset, true);
            $data['all_sms'] = json_encode($all_sms, true);
            $data['all_software'] = json_encode($all_software, true);
            $data['all_e1_lines'] = json_encode($all_e1_lines, true);
            $data['all_lan'] = json_encode($all_lan, true);
            $data['all_new_user_setup'] = json_encode($all_new_user_setup, true);
            $data['all_sys_maintenance'] = json_encode($all_sys_maintenance, true);
            $data['all_systems'] = json_encode($all_systems, true);
            $data['all_internet_conn'] = json_encode($all_internet_conn, true);
            $data['all_user_exit'] = json_encode($all_user_exit, true);
            $data['all_power_failure'] = json_encode($all_power_failure, true);
            $data['all_general'] = json_encode($all_general, true);
        } else {
            $data['date_filtered'] = 'N';
            $data['all_dates'] = 1;
            $data['all_issues'] = 1;

            $data['all_hardware'] = 1;
            $data['all_pass_reset'] = 1;
            $data['all_sms'] = 1;
            $data['all_software'] = 1;
            $data['all_e1_lines'] = 1;
            $data['all_lan'] = 1;
            $data['all_new_user_setup'] = 1;
            $data['all_sys_maintenance'] = 1;
            $data['all_systems'] = 1;
            $data['all_internet_conn'] = 1;
            $data['all_user_exit'] = 1;
            $data['all_power_failure'] = 1;
            $data['all_general'] = 1;
        }

        return view('reports.category_report')->with($data);
    }

    public function subcategoryReport(Request $request)
    {
        $data['issue_categories'] = Issue::getIssueCategories();

        $issues = array();
        $issue_id = array();
        foreach ($data['issue_categories'] as $value) {
            $issues[] = $value->issue_name;
            $issue_id[] = $value->issue_id;
        }
        $data['subs'] = DB::table('issue_subcategories')
            ->where('issue_id', '=', $issue_id)->get();

        return view('reports.subcategory_report')->with($data);
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