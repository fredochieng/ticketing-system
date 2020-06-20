@extends('adminlte::page')
@section('title', 'IP Inventory - IT HelpDesk')
@section('content_header')
<h1 class="pull-left">Inventory<small>IP inventory</small></h1>
<div class="pull-right">
    <a class="btn btn-primary btn-sm btn-flat" data-toggle="modal" data-target="#modal_add_new_ip"><i
            class="fa fa-plus"></i> NEW IP ENTRY</a>
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
                    <table id="example1" class="table no-margin" style="font-size:13px">
                        <thead>
                            <tr role="row">
                                <th>Server Name</th>
                                <th>Purpose</th>
                                <th>IP Address</th>
                                <th>Username</th>
                                <th>Password</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($ips as $ip)
                            <tr>
                                <td>{{ $ip->server_name }} </td>
                                <td>{{ $ip->server_desc }} </td>
                                <td>{{ $ip->server_ip }} </td>
                                <td>{{ $ip->server_username }} </td>
                                <td>{{ $ip->server_password }} </td>
                                <td><a class="btn btn-flat btn-info btn-sm" data-toggle="modal"
                                        data-target="#modal_edit_ip_{{ $ip->server_id }}    "><i
                                            class="fa fa-pencil"></i></a>
                                </td>
                            </tr>
                            @include('inventory.ip.modals.modal_edit_ip')
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@include('inventory.ip.modals.modal_add_new_ip')
@stop
@section('css')
<link rel="stylesheet" href="/css/admin_custom.css">
<link rel="stylesheet" href="/css/bootstrap-datepicker.min.css">
@stop
@section('js')
<script src="/js/select2.full.min.js"></script>

<script type="text/javascript">
    $(function(){

    });
    $(".select2").select2();
    $('#example1').DataTable()
</script>
@stop