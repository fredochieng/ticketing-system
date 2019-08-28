@extends('adminlte::page')
@section('title', 'All Tickets - IT HelpDesk')
@section('content_header')
<h1 class="pull-left">Assets<small>Asset Types</small></h1>
<div class="pull-right">
    <a class="btn btn-primary btn-sm btn-flat" data-toggle="modal" data-target="#modal_new_ticket"><i
            class="fa fa-plus"></i> New Asset Type</a>
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
                                <th>Asset Type Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($asset_types as $count=> $row)
                            <tr>

                                <td>{{$count + 1}}</td>
                                <td>{{$row->asset_cat_name}}</td>
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
{{-- @include('modals.tickets.modal_add_new_ticket') --}}
@stop
@section('css')

@stop
@section('js')

<script type="text/javascript">
    $(function(){
 
    $('#example1').DataTable();
</script>
@stop