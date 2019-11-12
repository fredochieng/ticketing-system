@extends('adminlte::page')
@section('title', 'All Tickets - IT HelpDesk')
@section('content_header')
<h1 class="pull-left">Tickets<small>All tickets</small></h1>
<div class="pull-right">
    <a class="btn btn-primary btn-sm btn-flat" data-toggle="modal" data-target="#modal_new_ticket"><i
            class="fa fa-plus"></i> NEW TICKET</a>
</div>
<div style="clear:both"></div>
@stop
@section( 'content')

<div class="row">
    <div class="col-xs-12">
        <div class="box box-success">
            <div class="box-header">
            </div>
            <div class="box-body">
                <div class="table-responsive">
                    <table id="example1" class="table no-margin">
                        <thead>
                            <tr role="row">
                                <th>S/N</th>
                                <th>Ticket #</th>
                                <th>Subject</th>
                                <th>Submitter</th>
                                <th>Email</th>

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
</div>
@include('modals.tickets.modal_add_new_ticket')
@stop
@section('css')
<link rel="stylesheet" href="/css/admin_custom.css">
<link rel="stylesheet" href="/css/bootstrap-datepicker.min.css">
@stop
@section('js')
<script src="/js/select2.full.min.js"></script>

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