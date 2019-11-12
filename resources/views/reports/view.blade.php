@extends('adminlte::page')
@section('title', 'Tickets Report - IT HelpDesk & Ticketing System')
@section('content_header')
<h1>Tickets Report</h1>
@stop
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="box box-info" id="accordion">
            <div class="box-header with-border">
                <h3 class="box-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseFilter">
                        <i class="fa fa-filter" aria-hidden="true"></i> Filters
                    </a>
                </h3>
            </div>
            <div id="collapseFilter" class="panel-collapse active collapse in" aria-expanded="true">
                <div class="box-body">
                    {!! Form::open(['url' => '#', 'method' => 'get', 'id' => 'sell_payment_report_form' ]) !!}
                    <div class="col-md-3">
                        {{Form::label('Ticket Status ')}}
                        <div class="form-group">
                            {!! Form::text('pay_mode_idss', $status_name, ['class' =>
                            'form-control', 'readonly']); !!}
                        </div>
                    </div>
                    <div class="col-md-3">
                        {{Form::label('Ticket Country ')}}
                        <div class="form-group">
                            {!! Form::text('pay_mode_idss', $country_name, ['class' =>
                            'form-control', 'readonly']); !!}
                        </div>
                    </div>

                    <input type="hidden" name="status" value="{{$status_id}}">
                    <input type="hidden" name="country_id" value="{{$country_id}}">

                    <div class="col-md-3">
                        <div class="form-group">
                            {!! Form::label('Ticket Creation Date') !!}
                            {!! Form::text('date_range', $start_date .' - '. $end_date, ['placeholder' => '',
                            'class' => 'form-control', 'id' => 'daterange-btn', 'readonly']); !!}
                        </div>
                    </div>

                    <div class="col-md-3">
                        <a href="/reports" style="margin-top:25px;" class="btn bg-purple pull-right"><strong><i
                                    class="fa fa-arrow-left"></i>
                                BACK</strong></a>

                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="box box-info">
            <div class="box-body">
                <div class="table-responsive">
                    <div class="box-header with-border">
                        <h3 class="box-title">
                            <b>Tickets Report for period</b>
                            {{$start_date}} - {{$end_date}}</h3>

                        <a href="/report/excel/generate?date_range=<?php echo $start_date .' - '. $end_date ?>&status_id=<?php echo $status_id ?>&country_id=<?php echo $country_id ?>"
                            class="btn btn-info btn-flat pull-right"><strong>EXPORT
                                TO EXCEL</strong></a>
                    </div>
                    <table id="example" class="table table-no-margin" style="font-size:12px">


                        {{-- // <table id="example" class="box-body table-responsive no-padding" cellspacing="0" width="100%"> --}}
                        <thead>
                            <tr>
                                {{-- <th>Ticket #</th> --}}
                                <th>Subject</th>
                                {{-- <th>Submitter</th> --}}
                                {{-- <th>Country</th> --}}
                                {{-- <th>Assignee</th> --}}
                                <th>Status</th>
                                <th>Category</th>
                                <th>Subcategory</th>
                                @if ($status_name == 'Closed')
                                <th>Service Affecting</th>
                                @endif
                                <th>RFO</th>
                                <th>Opened At</th>
                                <th>Closed At</th>
                                <th style="width:100px">Time Taken (H:m:s)</th>
                                <th>Closed By</th>
                            </tr>
                        </thead>

                        <tfoot>
                            <tr>
                                {{-- <th>Ticket #</th> --}}
                                <th>Subject</th>
                                {{-- <th>Submitter</th> --}}
                                {{-- <th>Country</th> --}}
                                {{-- <th>Assignee</th> --}}
                                <th>Status</th>
                                <th>Category</th>
                                <th>Subcategory</th>
                                @if ($status_name == 'Closed')
                                <th>Service Affecting</th>
                                @endif
                                <th>RFO</th>
                                <th>Opened At</th>
                                <th>Closed At</th>
                                <th>Time Taken</th>
                                <th>Closed By</th>
                            </tr>
                        </tfoot>

                        <tbody style="font-size:12px">
                            @foreach ($tickets as $row)
                            <tr>
                                {{-- <td><a href="/tickets/manage/&id={{$row->ticket_id}}"><b>{{$row->ticket}}</b></a>
                                </td> --}}
                                <td>{{$row->subject}}</td>
                                {{-- <td>{{$row->submitter}}</td> --}}
                                {{-- <td>{{$row->country_name}}</td> --}}
                                {{-- <td>{{$row->assigned_to}}</td> --}}
                                <td><small class="badge bg-{{$row->status_color}}">{{$row->status_name}}</small></span>
                                </td>
                                @if($row->issue_name)
                                <td>{{ $row->issue_name }}</td>
                                @else
                                <td>N/A</td>
                                @endif
                                @if($row->issue_subcategory_name)
                                <td>{{ $row->issue_subcategory_name }}</td>
                                @else
                                <td>N/A</td>
                                @endif
                                @if ($status_name == 'Closed')
                                @if ($row->service_affecting != '')
                                <td>
                                    <center>{{ $row->service_affecting }}</center>
                                </td>
                                @else
                                <td>
                                    <center>N/A</center>
                                </td>
                                @endif
                                @endif
                                @if($row->reason)
                                <td>{{$row->reason}}</td>
                                @else
                                <td>N/A</td>
                                @endif
                                <td style="width:100px">{{ $row->ticket_created_at }}</td>
                                @if($row->closed_date )
                                <td style="width:100px">{{ $row->closed_at }}</td>
                                @else
                                <td>N/A</td>
                                @endif
                                <td style="width:100px">{{$row->time_taken}}</td>
                                <td>{{$row->closed_by}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- @stop
@section('css')
<link rel="stylesheet" href="/plugins/bootstrap-daterangepicker/daterangepicker.css">
@stop
@section('js')
<script src="/plugins/jquery/dist/jquery.js"></script>
<script src="/plugins/moment/min/moment.min.js"></script>
<script src="/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>
<script src="/js/select2.full.min.js"></script>
@stop
@section('css')
<link rel="stylesheet" href="/css/admin_custom.css">
<link rel="stylesheet" href="/css/table.css">
<link rel="stylesheet" href="/css/bootstrap-datepicker.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap.css">
@stop
@section('js')

<script type="text/javascript">
    $(document).ready(function() {
       $('#example').DataTable( {
            responsive: true
        });
    });
</script>
@stop --}}




@stop
@section('css')
<link rel="stylesheet" href="/css/admin_custom.css">
<link rel="stylesheet" href="/css/bootstrap-datepicker.min.css">
@stop
@section('js')
<script src="/js/select2.full.min.js"></script>

<script type="text/javascript">
    $(".select2").select2();
    $('#example').DataTable()
</script>
@stop