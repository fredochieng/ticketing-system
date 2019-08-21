@extends('adminlte::page')
@section('title', 'Roles - IT HelpDesk')
@section('content_header')
<h1 class="pull-left">Roles<small>Manage User Roles</small></h1>
<div style="clear:both"></div>

@stop
@section('content')
<div class="box box-success">
    <div class="box-header with-border">
        <h3 class="box-title">All Roles</h3>
        <div class="box-tools">
            <a href="#modal_add_new_role" data-toggle="modal" class="btn btn-block btn-primary"><i
                    class="fa fa-plus"></i>
                ADD </a>
        </div>
    </div>

    <div class="box-body">
        <div class="table-responsive">
            <table id="example1" class="table no-margin">
                <thead>
                    <tr>
                        <th>S/N</th>
                        <th>Role Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($roles as $count=> $row)
                    <tr>
                        <td>{{$count + 1}}</td>
                        <td>{{$row->name}}</td>
                        @if($row->name=='Admin')
                        <td>
                            <button class="btn btn-xs btn-success" disabled><i class="glyphicon glyphicon-edit"></i> Edit</button>
                            <button class="btn btn-xs btn-danger" disabled><i class="glyphicon glyphicon-trash"></i> Delete</button>
                        </td>
                        @else
                        <td>
                            <a href="" data-backdrop="static" data-keyboard="false" data-toggle="modal"
                                data-target="#modal_edit_role_{{$row->id}}" class="btn btn-xs btn-success"><i
                                    class="glyphicon glyphicon-edit"></i> Edit</a> {{Form::hidden('_method','DELETE')}}
                            <a href="" data-backdrop="static" data-keyboard="false" data-toggle="modal"
                                data-target="#modal_delete_role_{{$row->id}}"
                                class="btn btn-xs btn-danger delete_user_button"><i
                                    class="glyphicon glyphicon-trash"></i> Delete</a>
                        </td>
                        @endif
                    </tr>
                    @include('modals.roles.modal_delete_role')
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <!-- /.box-body -->
</div>
@include('modals.roles.modal_add_new_role')
@stop
@section('css')
<link rel="stylesheet" href="/css/admin_custom.css">
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
