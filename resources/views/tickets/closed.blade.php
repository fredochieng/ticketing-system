@extends('adminlte::page')
@section('title', 'Closed Tickets - IT HelpDesk & Ticketing System')
@section('content_header')
<h1 class="pull-left">Tickets<small>Closed Tickets</small></h1>
<div style="clear:both"></div>
@stop
@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="box box-success">
            <div class="box-header">
            </div>
            <div class="box-body">
                <div class="table-responsive">
                    <table id="example1" class="table no-margin" style="font-size:12px">
                        <thead>
                            <tr role="row">
                                {{-- <th>S/N</th> --}}
                                <th>Ticket #</th>
                                <th>Subject</th>
                                <th>Service Affecting</th>
                                <th>Submitter</th>
                                <th>Email</th>
                                <th>Assignee</th>
                                <th>Status</th>
                                <th>Date Opened</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tickets_closed as $count=> $row)
                            <tr>

                                {{-- <td>{{$count + 1}}</td> --}}
                                <td><a href="/tickets/manage/&id={{$row->ticket_id}}"><b>{{$row->ticket}}</b></a></td>
                                <td>{{$row->subject}}</td>
                                @if ($row->service_affecting != '')
                                <td>
                                    <center>{{ $row->service_affecting }}</center>
                                </td>
                                @else
                                <td>
                                    <center>N/A</center>
                                </td>
                                @endif
                                <td>{{$row->submitter}}</td>
                                <td><a href="">{{$row->submitter_email}}</a></td>

                                <td>{{$row->assigned_to}}</td>

                                <td><small class="badge bg-{{$row->status_color}}">{{$row->status_name}}</small></span>
                                </td>
                                <td>{{ $row->ticket_created_at }}</td>

                                <td> <a href="/tickets/manage/&id={{$row->ticket_id}}"
                                        class="btn btn-flat btn-primary btn-sm"><i class="fa fa-eye"></i></a></td>
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
<link rel="stylesheet" href="/css/bootstrap-datepicker.min.css">
@stop
@section('js')

<script src="/js/select2.full.min.js"></script>

<script>
    $(function () {
      $(".select2").select2();
      $('#example1').DataTable();
    });
</script>
@stop