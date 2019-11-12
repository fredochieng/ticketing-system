@extends('adminlte::page')
@section('title', 'Reports - Tickets Assignment')
@section('content_header')
<h1 class="pull-left">Reports<small>Tickets Assignment</small></h1>

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
                                <th>Assignee Name</th>
                                <th>Assignee Email</th>
                                <th>Total Tickets In Progress</th>
                                <th>Total Tickets Closed</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tickets as $count=> $row)
                            <tr>
                                <td>{{$count + 1}}</td>
                                <td>{{$row->user_name}}</td>
                                <td>{{$row->user_email}}</td>
                                <td>{{$row->tickets_in_progress}}</td>
                                <td>{{$row->tickets_closed}}</td>
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
@stop
