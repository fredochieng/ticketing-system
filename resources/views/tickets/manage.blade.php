@extends('adminlte::page')
@section('title', 'Manage Tickets - IT HelpDesk')
@section('content_header')
<h1 class="pull-left"><b>#{{$tickets->ticket}} - {{$tickets->subject}}</b></h1>
<div style="clear:both"></div>
@stop
@section( 'content')
<div class="row">
    <div class="col-md-7">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab-ticket" data-toggle="tab" class="ticket-tab-button"
                        aria-expanded="true">Ticket Description</a></li>
                <li class=""><a href="#tab-attachments" data-toggle="tab" aria-expanded="false">Attachments <span
                            class="badge bg-green"> {{ $total_attachments }}</span></a></li>
                <div class="btn-group pull-right" style="padding:6px;">
                    <div class="btn-group">
                        <a href="" data-toggle="modal" data-target="#modal_reply_ticket" class="btn btn-primary">Reply
                            ticket</a>

                        @if(!auth()->user()->isUser() )
                        @if($tickets->status_id==3)
                        <a href="" data-toggle="modal" data-target="#modal_reopen_ticket_{{$tickets->ticket_id}}" a
                            href="" data-toggle="modal" data-target="#modal_reopen_ticket"
                            class="btn btn-info">Reopen</a>
                        @endif
                        @endif

                        @if(auth()->user()->isAdmin())
                        @if($tickets->status_id==1)
                        <a href="" data-toggle="modal" data-target="#modal_assign_ticket" a href="" data-toggle="modal"
                            data-target="#modal_assign_ticket" class="btn btn-info">Assign</a>
                        @endif
                        @endif

                        @if(auth()->user()->isTechnician() || auth()->user()->isAdmin() ||
                        auth()->user()->isITManager())
                        @if($tickets->status_id==1)
                        <a href="" data-toggle="modal" data-target="#modal_work_on_ticket_{{$tickets->ticket_id}}"
                            class="btn btn-warning">Work on
                            ticket</a>
                        @endif
                        @endif
                        @if(auth()->user()->isTechnician() || auth()->user()->isAdmin() ||
                        auth()->user()->isITManager())
                        @if(($tickets->status_id==2) && ($tickets->esc_level_id=='') &&
                        ($tickets->assigned_user_id==Auth::user()->id))
                        <a href="" data-toggle="modal" data-target="#modal_escalate_ticket"
                            class="btn btn-warning">Escalate</a>
                        @endif
                        @endif

                        @if(($tickets->status_id==2) && ($tickets->esc_level_id=='') &&
                        ($tickets->assigned_user_id==Auth::user()->id))
                        <a href="" data-toggle="modal" data-target="#modal_close_ticket"
                            class="btn btn-success">Close</a>
                        @endif

                        @if(auth()->user()->isSysAdmin())
                        @if(($tickets->status_id==2) && ($tickets->esc_level_id=='1'))
                        <a href="" data-toggle="modal" data-target="#modal_close_ticket"
                            class="btn btn-success">Close</a>
                        @endif
                        @endif

                        @if(auth()->user()->isAdmin())
                        @if(($tickets->status_id==2) && $tickets->assigned_user_id !=Auth::user()->id)
                        <a href="" data-toggle="modal" data-target="#modal_close_ticket"
                            class="btn btn-success">Close</a>
                        @endif
                        @endif

                        @if(auth()->user()->isITManager())
                        @if(($tickets->status_id==2) && ($tickets->esc_level_id=='2'))
                        <a href="" data-toggle="modal" data-target="#modal_close_ticket"
                            class="btn btn-success">Close</a>
                        @endif
                        @endif
                        @if(auth()->user()->isCIO())
                        @if(($tickets->status_id==2) && ($tickets->esc_level_id=='7'))
                        <a href="" data-toggle="modal" data-target="#modal_close_ticket"
                            class="btn btn-success">Close</a>
                        @endif
                        @endif
                        @if(auth()->user()->isSysManager())
                        @if(($tickets->status_id==2) && ($tickets->esc_level_id=='4'))
                        <a href="" data-toggle="modal" data-target="#modal_close_ticket"
                            class="btn btn-success">Close</a>
                        @endif
                        @endif

                        @if(auth()->user()->isAdmin() || auth()->user()->isITManager())
                        <a href="" data-toggle="modal" data-target="#modal_delete_ticket_{{ $tickets->ticket_id }}"
                            class="btn btn-danger">Delete</a>
                        @endif

                    </div>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab-ticket">

                    <div class="row">
                        <div class="col-xs-12">
                            <div class="form-group">
                                <textarea class="form-control summernoteTicket" value="" readonly rows="19.5"
                                    id="message" name="message">{{ $tickets->description }}</textarea>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="tab-pane" id="tab-attachments">
                    <div class="table-responsive">
                        <table class="table table-no-margin">
                            </thead>
                            <tbody>
                                <h5>Attachments for this ticket</h5>
                                @if($tickets->attached_file !='')
                                <ul class="nav nav-stacked">
                                    @foreach ($files as $count=> $file)
                                    <li><a href="/uploads/email_attachments/{{$file}}" target="_blank"><span
                                                class="text-blue">{{$file}}</span> <i
                                                class="fa fa-fw fa-download"></i></a>
                                    </li>
                                    @endforeach
                                </ul>
                                @else
                                <h3>No attachments</h3>
                                @endif
                            </tbody>
                        </table>
                    </div>

                </div>
                <!-- /.tab-pane -->
            </div>
        </div>
    </div>

    <div class="col-md-5">
        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title"><b>Ticket Details</b></h3>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                @if($duration > 15 && $duration < 30 && $tickets->status_id==1)
                    <span class=" badge bg-orange pull-center"><b>Exceeded 15 Mins</b></span>
                    @elseif($duration >30 && $tickets->status_id==1)
                    <span class=" badge bg-red pull-center"><b>Exceeded 30 Mins</b></span>
                    @else
                    @endif
                    @if($tickets->esc_level_id !='')<span class=" badge bg-aqua pull-right"><b>ESCALATED</b></span>@else
                    @endif

            </div><!-- /.box-header -->
            <div class="box-body">
                <table id="ticketDetailsTable" class="table table-no-margin">
                    <tbody>
                        <tr>
                            <td><b>Ticket #</b></td>
                            <td><span style="font-weight:bold">{{ $tickets->ticket}}</span></td>
                        </tr>
                        <tr>
                            <td><b>Subject</b></td>
                            @if(!$tickets->issue_name)
                            <td><b>{{ $tickets->subject }}</b></td>
                            @else
                            <td><b>{{$tickets->issue_name}}</b></td>
                            @endif
                        </tr>
                        <tr>
                            <td><b>Status</b></td>
                            <td><span class="badge bg-{{$tickets->status_color}}">{{$tickets->status_name}}</span></td>
                        </tr>
                        <!-- <tr>
                            <td><b>Priority</b></td>
                            <td>{{$tickets->priority_name}}</td>
                        </tr> -->
                        <tr>
                            <td><b>Attachemnts</b></td>
                            @if($tickets->attached_file !='')
                            <td>{{ $total_attachments }} </td>
                            @elseif($tickets->attached_file =='')
                            <td>{{ $attachments }} </td>
                            @endif
                        </tr>
                        <tr>
                            <td><b>Created</b></td>
                            <td>{{ $tickets->ticket_created_at }}</td>
                        </tr>
                        <tr>
                            <td><b>Closed</b></td>
                            @if($tickets->closed_at=='')
                            <td>N/A</td>
                            @else
                            <td>{{ $tickets->closed_at }}</td>
                            @endif
                        </tr>
                        <tr>
                            <td><b>Opened By</b></td>
                            @if(!$created_user)
                            <td><b>{{ $tickets->submitter }}</b></td>
                            @else
                            <td><b>{{ $created_user->name }}</b></td>
                            @endif
                        </tr>
                        <tr>
                            <td><b>User Email</b></td>
                            @if(!$created_user)
                            <td>{{ $tickets->submitter_email }}</td>
                            @else
                            <td>{{ $created_user->email }}</td>
                            @endif
                        </tr>
                        <tr>
                            <td><b>Assigned To</b></td>
                            @if($tickets->assigned_user_id=='')
                            <td>Not assigned</td>
                            @elseif($tickets->assigned_user_id==Auth::user()->id)
                            <td>ME</td>
                            @else
                            <td>{{ $assigned_user->assigned_user_name }}</td>
                            @endif
                        </tr>
                        <tr>
                            <td><b>Escalation</b></td>
                            @if(auth()->user()->isTechnician())
                            @if($tickets->esc_level_id !='')
                            <td>Escalation to <b>{{ $tickets->role_name }}</b></td>
                            @else
                            <td>NO ESCALATION</td>
                            @endif
                            @elseif(auth()->user()->isSysAdmin() && ($tickets->esc_level_id !=''))
                            <td>Escalated by <b>{{ $escalated_by->name }}</b></td>
                            @elseif(auth()->user()->isSysAdmin() && ($tickets->esc_level_id ==''))
                            <td>NO ESCALATION</td>
                            @elseif(auth()->user()->isITManager() && ($tickets->esc_level_id !=''))
                            <td>Escalated by <b>{{ $escalated_by->name }}</b></td>
                            @elseif(auth()->user()->isITManager() && ($tickets->esc_level_id ==''))
                            <td>NO ESCALATION</td>
                            @elseif(auth()->user()->isAdmin())
                            @if($tickets->esc_level_id !='')
                            <td>From <b>{{ $escalated_by->name }}</b> to <b>{{ $tickets->role_name }}</b></td>
                            @else
                            <td>NO ESCALATION</td>
                            @endif
                            @endif
                        </tr>
                        <tr>
                            <td><b>Escalation Time</b></td>
                            <td>{{ $tickets->escalated_at }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<div class="row">
    <div class="col-md-12">
        <div class="box box-success">

            <div class="box-header with-border">
                <h3 class="box-title"><b>Ticket Replies</b></h3>

            </div>
            <div class="box-body">
                <ul class="timeline timeline-inverse">

                    @foreach ($ticket_replies as $replies)
                    {{--  <li class="time-label">
                        <span class="bg-red">
                            10 Feb. 2014
                        </span>
                    </li>  --}}
                    <li>
                        <img src="/images/no-user.png" class="img-circle timeline-image"
                            style="height:32px;width:32px;">

                        <div class="timeline-item">
                            <span class="time"><i class="fa fa-clock-o"></i> {{$replies->created_at}}</span>

                            @if($replies->reply_type == '')
                            <h3 class="timeline-header"><a href="#">{{$replies->submitter}}</a> opened a ticket</h3>
                            @else
                            <h3 class="timeline-header"><a href="#">{{$replies->submitter}}</a> {{$replies->reply_type}}
                            </h3>
                            @endif
                            <div class="timeline-body">
                                {{ $replies->message }}
                            </div>
                        </div>
                    </li>
                    @endforeach
                    <li><i class="fa fa-arrow-up bg-gray"></i></li>

                </ul>
            </div>
        </div>
    </div>
</div>
@include('modals.tickets.modal_assign_ticket')
@include('modals.tickets.modal_work_on_ticket')
@include('modals.tickets.modal_delete_ticket')
@include('modals.tickets.modal_close_ticket')
@include('modals.tickets.modal_reopen_ticket')
@include('modals.tickets.modal_escalate_ticket')
@include('modals.tickets.modal_reply_ticket')
@stop
@section('css')
<link rel="stylesheet" href="/css/admin_custom.css">
<link rel="stylesheet" href="/css/custom.css">
@stop
@section('js')
<script type="text/javascript">
    $(function(){
$('#categories').on('change', function(e){
console.log(e);
var category_id = e.target.value;
$.get('/get-issue-subcategories?category_id=' + category_id,function(data) {
console.log(data);
$('#subcategories').empty();
$('#subcategories').append('<option value="0" disable="true" selected="true">Select issue subcategory</option>');

$.each(data, function(index, subcategoriesObj){
$('#subcategories').append('<option value="'+ subcategoriesObj.issue_subcategory_id +'">'+
    subcategoriesObj.issue_subcategory_name +'</option>');
})
});
});
});
      $(".select2").select2();
    $('#example1').DataTable()
</script>
@stop