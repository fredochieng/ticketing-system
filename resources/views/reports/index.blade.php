@extends('adminlte::page')
@section('title', 'Tickets Report - IT Helpdesk')
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
                    {!!
                    Form::open(['action'=>['ReportController@displayReports'],
                    'method'=>'POST','class'=>'form','enctype'=>'multipart/form-data'])
                    !!}
                    <div class="col-md-12">
                        <div class="col-md-4">
                            {{Form::label('Ticket Status')}}
                            <div class="form-group">
                                <select class="form-control select2" id="status_id" name="status_id"
                                    style="width: 100%;" tabindex="-1" aria-hidden="true">
                                    <option selected="selected" value="">Select ticket status</option>
                                    @foreach($ticket_status as $item)
                                    <option value="{{ $item->status_id }}">{{ $item->status_name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {!! Form::label('Date Range') !!}
                                {!! Form::text('date_range', null, ['placeholder' => 'Select date range', 'class' =>
                                'form-control', 'id' => 'daterange-btn', 'readonly']); !!}
                            </div>
                        </div>

                        <div class="col-md-2">
                            <button type="submit" style="margin-top:25px;" class="btn btn-block btn-info"><strong><i
                                        class="fa fa-fw fa-search"></i>Generate Report</strong></button>
                        </div>
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
                <div class="table-responsive" style="font-size:14px;">
                    <table class="table table-hover" id="sell_payment_report_table">
                        <thead>
                            <tr style="font-size:12px;">
                                <th>S/N</th>
                                <th>Ticket #</th>
                                <th>Subject</th>
                                <th>Submitter</th>
                                <th>Email</th>
                                <th>Assignee</th>
                                <th>Status</th>
                                <th>Date Opened</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tickets as $count=> $row)
                            <tr>

                                <td>{{$count + 1}}</td>
                                <td><a href="/tickets/manage/&id={{$row->ticket_id}}"><b>{{$row->ticket}}</b></a></td>
                                <td>{{$row->subject}}</td>
                                <td>{{$row->submitter}}</td>
                                <td><a href="">{{$row->submitter_email}}</a></td>
                                <td>{{$row->assigned_to}}</td>
                                <td><small class="badge bg-{{$row->status_color}}">{{$row->status_name}}</small></span>
                                </td>
                                <td>{{ $row->ticket_created_at }}</td>

                </div>
                </td>
                </tr>
                @endforeach
                </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</div>
@stop
@section('css')
<link rel="stylesheet" href="/plugins/bootstrap-daterangepicker/daterangepicker.css">
@stop
@section('js')
<script src="/plugins/jquery/dist/jquery.js"></script>
<script src="/plugins/moment/min/moment.min.js"></script>
<script src="/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>
<script src="/js/select2.full.min.js"></script>

<script>
    $(function () {
      $(".select2").select2();
      $('#example1').DataTable();
    });
</script>
<script>
    $(function () {

     //Initialize Select2 Elements
   // $('#example1').DataTable()
     $('.select2').select2()
     //Date range as a button
     $('#daterange-btn').daterangepicker(
       {
         ranges   : {
           'Today'       : [moment(), moment()],
           'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
           'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
           'Last 30 Days': [moment().subtract(29, 'days'), moment()],
           'This Month'  : [moment().startOf('month'), moment().endOf('month')],
           'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
         },
         startDate: moment().subtract(29, 'days'),
         endDate  : moment()
       },
       function (start, end) {
         $('#daterange-btn span').html(start.format('YYYY, MMMM, D') + ' - ' + end.format('YYYY, MMMM, D'))
       }
     )

     var start = "";
     var end = "";
     if ($("input#daterange-btn").val()) {
         start = $("input#daterange-btn")
             .data("daterangepicker")
             .startDate.format("YYYY-MM-DD");
         end = $("input#daterange-btn")
             .data("daterangepicker")
             .endDate.format("YYYY-MM-DD");
     }
     start_date = start;
     end_date = end;
   })
</script>
@stop
