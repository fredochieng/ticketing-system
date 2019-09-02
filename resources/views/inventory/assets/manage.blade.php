@extends('adminlte::page')
@section('title', 'Manage Tickets - IT HelpDesk')
@section('content_header')
<h1 class="pull-left"><b>Asset Details</b></h1>
<div style="clear:both"></div>
@stop
@section( 'content')
<div class="row">
    <div class="col-md-5">
        <div class="box box-success">
            <div class="box-body">
                <table id="ticketDetailsTable" class="table table-striped table-hover">
                    <tbody>
                        <tr>
                            <td><b>Asset No</b></td>
                            <td>{{ $assets->asset_no }}</td>

                        </tr>
                        <tr>
                            <td><b>Status</b></td>
                            <td><small
                                    class="badge bg-{{$assets->status_color}}">{{$assets->asset_status_name}}</small></span>
                            </td>

                        </tr>
                        <tr>
                            <td><b>Staff Name</b></td>
                            <td>{{ $assets->staff_name}}</td>

                        </tr>
                        <tr>
                            <td><b>Payroll No</b></td>
                            <td>{{ $assets->payroll_no}}</td>

                        </tr>
                        <tr>
                            <td><b>Asset Type</b></td>
                            <td>{{ $assets->asset_type }}</td>

                        </tr>

                        <tr>
                            <td><b>Model No</b></td>
                            <td>{{ $assets->model_no }}</td>

                        </tr>
                        <tr>
                            <td><b>Serial No</b></td>
                            <td>{{ $assets->serial_no }}</td>

                        </tr>
                        @if ($assets->asset_type == 'LAPTOP' || $assets->asset_type == 'DESKTOP')
                        <tr>
                            <td><b>Operating System</b></td>
                            <td>{{ $assets->os }}</td>

                        </tr>
                        <tr>
                            <td><b>RAM</b></td>
                            <td>{{ $assets->ram }}</td>

                        </tr>
                        <tr>
                            <td><b>Hard Drive (HDD)</b></td>
                            <td>{{ $assets->hdd}}</td>
                        </tr>
                        <tr>
                            <td><b>System Type</b></td>
                            <td>{{ $assets->system_type }}</td>

                        </tr>
                        <tr>
                            <td><b>Antivirus</b></td>
                            <td>{{ $assets->antivirus }}</td>

                        </tr>
                        <tr>
                            <td><b>Windows License</b></td>
                            <td>{{ $assets->win_license }}</td>

                        </tr>
                        @endif
                        <tr>
                            <td><b>User Country</b></td>
                            <td>{{ $assets->country }}</td>

                        </tr>
                        <tr>
                            <td><b>Date Added</b></td>
                            <td>{{ $assets->created_at }}</td>

                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-7">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab-ticket" data-toggle="tab" class="ticket-tab-button"
                        aria-expanded="true">Edit Asset</a></li>
                <div class="btn-group pull-right" style="padding:6px;">
                    <div class="btn-group pull-right" style="padding:6px;">

                        <a href="#" data-toggle="modal" data-target="#modal_change_asset_status_{{$assets->asset_id}}"
                            class="btn btn-info btn-sm btn-flat"><i class="fa fa-refresh fa-refresh"></i> Change Asset
                            Status</a>

                    </div>

                </div>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab-ticket">
                    <div class="row">
                        {!!
                        Form::open(['action'=>['AssetController@updateAsset'],'method'=>'POST','class'=>'floatit','enctype'=>'multipart/form-data'])
                        !!}
                        <div class="col-md-4">
                            <div class="form-group">
                                {{Form::label('Asset Number')}}<br>
                                <div class="form-group">
                                    {{Form::text('asset_no', $assets->asset_no,['class'=>'form-control', 'required', 'placeholder'=>''])}}
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="asset_id" value="{{$assets->asset_id}}">
                        <div class="col-md-4">
                            <div class="form-group">
                                {{Form::label('Staff Name')}}<br>
                                <div class="form-group">
                                    {{Form::text('staff_name', $assets->staff_name,['class'=>'form-control', 'required', 'placeholder'=>''])}}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                {{Form::label('Payroll No')}}<br>
                                <div class="form-group">
                                    {{Form::text('payroll_no', $assets->payroll_no,['class'=>'form-control', 'required', 'placeholder'=>''])}}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {{Form::label('Asset Type')}}<br>
                                <div class="form-group">
                                    <select class="form-control select2" name="asset_type" style="width: 100%;">
                                        <option selected="selected">{{$assets->asset_type}}</option>
                                        @foreach($assect_categories as $item)
                                        <option value="{{ $item->asset_cat_name }}">{{ $item->asset_cat_name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {{Form::label('Serial Number')}}<br>
                                <div class="form-group">
                                    {{Form::text('serial_no', $assets->serial_no,['class'=>'form-control', 'required', 'placeholder'=>''])}}
                                </div>
                            </div>
                        </div>
                        @if ($assets->asset_type == 'LAPTOP' || $assets->asset_type == 'DESKTOP')
                        <div class="col-md-6">
                            @else
                            <div class="col-md-4">
                                @endif
                                <div class="form-group">
                                    {{Form::label('Model Number')}}<br>
                                    <div class="form-group">
                                        {{Form::text('model_no', $assets->model_no,['class'=>'form-control', 'placeholder'=>''])}}
                                    </div>
                                </div>
                            </div>
                            @if ($assets->asset_type == 'LAPTOP' || $assets->asset_type == 'DESKTOP')
                            <div class="col-md-6">
                                <div class="form-group">
                                    {{Form::label('Operating System')}}<br>
                                    <div class="form-group">
                                        {{Form::text('os', $assets->os,['class'=>'form-control', 'required', 'placeholder'=>''])}}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    {{Form::label('RAM')}}<br>
                                    <div class="form-group">
                                        {{Form::text('ram', $assets->ram,['class'=>'form-control', 'placeholder'=>''])}}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    {{Form::label('Hard Drive')}}<br>
                                    <div class="form-group">
                                        {{Form::text('hdd', $assets->hdd,['class'=>'form-control', 'placeholder'=>''])}}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    {{Form::label('Processor')}}<br>
                                    <div class="form-group">
                                        {{Form::text('processor', $assets->processor,['class'=>'form-control', 'placeholder'=>''])}}
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    {{Form::label('System Type')}}<br>
                                    <div class="form-group">
                                        {{Form::text('system_type', $assets->system_type,['class'=>'form-control', 'placeholder'=>''])}}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    {{Form::label('Office')}}<br>
                                    <div class="form-group">
                                        {{Form::text('office', $assets->office,['class'=>'form-control', 'placeholder'=>''])}}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    {{Form::label('Antivirus')}}<br>
                                    <div class="form-group">
                                        {{Form::text('antivirus', $assets->antivirus,['class'=>'form-control', 'placeholder'=>''])}}
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    {{Form::label('Windows License')}}<br>
                                    <div class="form-group">
                                        {{Form::text('win_license', $assets->win_license,['class'=>'form-control', 'placeholder'=>''])}}
                                    </div>
                                </div>
                            </div>
                            @endif
                            @if ($assets->asset_type == 'LAPTOP' || $assets->asset_type == 'DESKTOP')
                            <div class="col-md-4">
                                @else
                                <div class="col-md-4">
                                    @endif
                                    <div class="form-group">
                                        {{Form::label('User Country')}}<br>
                                        <div class="form-group">
                                            <select class="form-control select2" name="country" style="width: 100%;">
                                                <option selected="selected">{{$assets->country}}</option>
                                                @foreach($countries as $item)
                                                <option value="{{ $item->country_name }}">{{ $item->country_name }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                @if ($assets->asset_type == 'LAPTOP' || $assets->asset_type == 'DESKTOP')
                                <div class="col-md-4">
                                    @else
                                    <div class="col-md-4">
                                        @endif
                                        <div class="form-group">
                                            {{Form::label('Created At')}}<br>
                                            <div class="form-group">
                                                {{Form::text('created_at', $assets->created_at,['class'=>'form-control', 'readonly', 'placeholder'=>''])}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3 pull-right">
                                        <button type="submit" style="margin-top:25px;"
                                            class="btn btn-block btn-success"><strong><i
                                                    class="fa fa-fw fa-save"></i>Save
                                                Changes</strong></button>
                                    </div>
                                    {!! Form::close() !!}
                                </div>
                            </div>
                        </div>
                        <!-- /.tab-pane -->
                    </div>
                </div>
            </div>

        </div>
        @include('modals.assets.modal_change_asset_status')
        @stop
        @section('css')
        <link rel="stylesheet" href="/css/admin_custom.css">
        <link rel="stylesheet" href="/css/custom.css">
        @stop
        @section('js')
        <script type="text/javascript">
            $(function(){
      $(".select2").select2();
    $('#example1').DataTable()
        </script>
        @stop