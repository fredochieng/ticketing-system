@extends('adminlte::page')
@section('title', 'Open Tickets - IT HelpDesk & Ticketing System')
@section('content_header')
<h1 class="pull-left">Tickets<small>Open tickets</small></h1>
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
                    <table id="example1" class="table no-margin" style="font-size:13px">
                        <thead>
                            <tr role="row">
                                {{-- <th>S/N</th> --}}
                                <th>Ticket #</th>
                                <th>Subject</th>
                                <th>Submitter</th>
                                <th>Email</th>
                                {{--  <th>Assignee</th>  --}}
                                <th>Status</th>
                                <th>Date Opened</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tickets_open as $count=> $row)
                            <tr>

                                {{-- <td>{{$count + 1}}</td> --}}
                                <td><a href="/tickets/manage/&id={{$row->ticket_id}}"><b>{{$row->ticket}}</b></a></td>
                                <td>{{$row->subject}}</td>
                                <td>{{$row->submitter}}</td>
                                <td><a href="">{{$row->submitter_email}}</a></td>
                                {{--  @if($row->assigned_user_id == '')  --}}
                                {{--  <td>Nobody</td>
                                @else
                                <td><a href="">{{$assigned_user->name}}</a></td>
                                @endif --}}
                                <td><small class="badge bg-{{$row->status_color}}">{{$row->status_name}}</small></span>
                                </td>
                                <td>{{ $row->ticket_created_at }}</td>
                                {{--  <td>
                                    <a href="modal_edit_ticket_{{$row->ticket_id}}" class="btn btn-xs btn-primary"><i
                                    class="glyphicon glyphicon-eye-open"></i> View</a>
                                <a href="" data-backdrop="static" data-keyboard="false" data-toggle="modal"
                                    data-target="#modal_edit_ticket_{{$row->ticket_id}}"
                                    class="btn btn-xs btn-success"><i class="glyphicon glyphicon-edit"></i> Edit</a>
                                {{Form::hidden('_method','DELETE')}}
                                <a href="" data-backdrop="static" data-keyboard="false" data-toggle="modal"
                                    data-target="#modal_delete_ticket"
                                    class="btn btn-xs btn-danger delete_user_button"><i
                                        class="glyphicon glyphicon-trash"></i> Delete</a>
                                </td> --}}
                                </td>
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

@stop
@section('js')


<script type="text/javascript">
    $(function(){
      $(".select2").select2();
    $('#example1').DataTable();
    });
</script>
@stop