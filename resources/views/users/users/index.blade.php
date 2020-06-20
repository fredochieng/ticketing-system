@extends('adminlte::page')
@section('title', 'Users - IT HelpDesk')
@section('content_header')
<h1 class="pull-left">Users<small>Users</small></h1>
<div style="clear:both"></div>
@stop
@section( 'content')
<div class="box box-success">
    <div class="box-header with-border">
        <h3 class="box-title">All Users</h3>
        {{-- <div class="box-tools">
            <a href="#modal_add_new_user" data-toggle="modal" class="btn btn-block btn-primary"><i class="fa fa-plus"></i>
                ADD </a>
        </div> --}}
    </div>

    <div class="box-body">
        <div class="table-responsive">
            <table id="example1" class="table no-margin">
                <thead>
                    <tr>
                        <th>S/N</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $count=> $row)
                    <tr>
                        <td>{{$count + 1}}</td>
                        <td>{{$row->name}}</td>
                        <td><a href="">{{$row->email}}</a></td>
                        <td>{{$row->role_name}}</td>
                        <td>
                            <a href="" data-backdrop="static" data-keyboard="false" data-toggle="modal"
                                data-target="#modal_edit_user_{{$row->id}}" class="btn btn-xs btn-success"><i
                                    class="glyphicon glyphicon-edit"></i> Edit</a> {{Form::hidden('_method','DELETE')}}
                            <a href="" data-backdrop="static" data-keyboard="false" data-toggle="modal"
                                data-target="#modal_delete_user_{{$row->id}}"
                                class="btn btn-xs btn-danger delete_user_button"><i
                                    class="glyphicon glyphicon-trash"></i> Delete</a>
                        </td>
                    </tr>
                    @include('modals.users.modal_edit_user')
                    @include('modals.users.modal_delete_user')
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <!-- /.box-body -->
</div>
@include('modals.users.modal_add_new_user')
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