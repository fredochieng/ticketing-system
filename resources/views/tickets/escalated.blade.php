@extends('adminlte::page')
@section('title', 'Escalated tickets - IT HelpDesk & Ticketing System')
@section('content_header')
<h1 class="pull-left">Tickets<small>Escalated Tickets</small></h1>
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
                                <th>Ticket #</th>
                                <th>Subject</th>
                                <th>Submitter</th>
                                <th>Assignee</th>
                                <th>Status</th>
                                <th>Date Opened</th>
                                <th>Escalated At</th>
                                <th>Escalated To</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tickets_escalated as $row)
                            <tr>
                                <td><a href="/tickets/manage/&id={{$row->ticket_id}}"><b>{{$row->ticket}}</b></a></td>
                                <td>{{$row->subject}}</td>
                                <td>{{$row->submitter}}</td>
                                <td>{{$row->assigned_to}}</td>

                                <td><small class="badge bg-{{$row->status_color}}">{{$row->status_name}}</small></span>
                                </td>
                                <td>{{ $row->ticket_created_at }}</td>
                                <td>{{ $row->escalated_at }}</td>
                                <td>{{ $row->esc_level_name }}</td>

                                <td>
                                    <div class="pull-right">
                                        <div class="btn-group">
                                            <a href="/tickets/manage/&id={{$row->ticket_id}}"
                                                class="btn btn-flat btn-primary btn-sm"><i class="fa fa-eye"></i></a>
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
