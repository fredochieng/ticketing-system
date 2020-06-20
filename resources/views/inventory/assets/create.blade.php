@extends('adminlte::page')
@section('title', 'Create Asset - IT HelpDesk')
@section('content_header')
<h1 class="pull-left">Assets<small>Create new asset</small></h1>
<div style="clear:both"></div>
@stop
@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Create New Asset</h3>
                <div class="col-md-3 pull-right">
                    <a href="#" data-toggle="modal" data-target="#modal_import_assets"
                        class="btn btn-block btn-info btn-sm btn-flat"><i class="fa fa-refresh fa-refresh"></i> Import
                        Assets
                    </a>
                </div>
            </div>

            <!-- /.box-header -->
            <div class="box-body">
                <div class="container-fluid">
                    <div class="row">
                        {!!
                        Form::open(['action'=>'AssetController@store','method'=>'POST','class'=>'form','enctype'=>'multipart/form-data'])
                        !!}
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    {{Form::label('Asset Number')}}<br>
                                    <div class="form-group">
                                        {{Form::text('asset_no', '',['class'=>'form-control', 'required', 'placeholder'=>''])}}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    {{Form::label('Staff Name')}}<br>
                                    <div class="form-group">
                                        {{Form::text('staff_name', '',['class'=>'form-control', 'placeholder'=>''])}}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    {{Form::label('Payroll No')}}<br>
                                    <div class="form-group">
                                        {{Form::text('payroll_no', '',['class'=>'form-control', 'placeholder'=>''])}}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    {{Form::label('Asset Type')}}<br>
                                    <div class="form-group">
                                        <select class="form-control select2" id="asset_type_id" name="asset_type"
                                            style="width: 100%;" required>
                                            <option selected="selected">Select asset type</option>
                                            @foreach($asset_categories as $item)
                                            <option value="{{ $item->asset_cat_name }}">{{ $item->asset_cat_name }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    {{Form::label('Serial Number')}}<br>
                                    <div class="form-group">
                                        {{Form::text('serial_no', '',['class'=>'form-control', 'placeholder'=>''])}}
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    {{Form::label('Model Number')}}<br>
                                    <div class="form-group">
                                        {{Form::text('model_no', '',['class'=>'form-control', 'placeholder'=>''])}}
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4 hide" id="os_div">
                                <div class="form-group">
                                    {{Form::label('Operating System')}}<br>
                                    <div class="form-group">
                                        {{Form::text('os', '',['class'=>'form-control', 'placeholder'=>''])}}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 hide" id="ram_div">
                                <div class="form-group">
                                    {{Form::label('RAM')}}<br>
                                    <div class="form-group">
                                        {{Form::text('ram', '',['class'=>'form-control', 'placeholder'=>''])}}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 hide" id="hdd_div">
                                <div class="form-group">
                                    {{Form::label('Hard Drive')}}<br>
                                    <div class="form-group">
                                        {{Form::text('hdd', '',['class'=>'form-control', 'placeholder'=>''])}}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 hide" id="sys_type_div">
                                <div class="form-group">
                                    {{Form::label('System Type')}}<br>
                                    <div class="form-group">
                                        {{Form::text('system_type', '',['class'=>'form-control', 'placeholder'=>''])}}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 hide" id="processor_div">
                                <div class="form-group">
                                    {{Form::label('Processor')}}<br>
                                    <div class="form-group">
                                        {{Form::text('processor', '',['class'=>'form-control', 'placeholder'=>''])}}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 hide" id="office_div">
                                <div class="form-group">
                                    {{Form::label('Office')}}<br>
                                    <div class="form-group">
                                        {{Form::text('office', '',['class'=>'form-control', 'placeholder'=>''])}}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 hide" id="antivirus_div">
                                <div class="form-group">
                                    {{Form::label('Antivirus')}}<br>
                                    <div class="form-group">
                                        {{Form::text('antivirus', '',['class'=>'form-control', 'placeholder'=>''])}}
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3 hide" id="win_license_div">
                                <div class="form-group">
                                    {{Form::label('Windows License')}}<br>
                                    <div class="form-group">
                                        {{Form::text('win_license', '',['class'=>'form-control', 'placeholder'=>''])}}
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    {{Form::label('User Region')}}<br>
                                    <div class="form-group">
                                        <select class="form-control select2" name="country" style="width: 100%;"
                                            required>
                                            <option selected="selected" value="NAIROBI DSM PLACE">NAIROBI DSM PLACE
                                            </option>
                                            {{-- @foreach($countries as $item)
                                            <option value="{{ $item->country_name }}">{{ $item->country_name }}
                                            </option>
                                            @endforeach --}}
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 pull-right">
                                <button type="submit" class="btn btn-block btn-primary"><i class="fa fa-check"></i>
                                    Create New
                                    Asset</button>
                            </div>
                            {!! Form::close() !!}
                        </div>

                    </div>
                </div>
                <!-- /.tab-pane -->
            </div>
            <!-- /.form -->
        </div>
    </div>
</div>
</div>
</div>
</div>
@include('modals.assets.modal_import_assets')
@stop
@section('css')
<link rel="stylesheet" href="/css/admin_custom.css">
<link rel="stylesheet" href="/css/bootstrap-datepicker.min.css">
@stop
@section('js')
<script src="/js/bootstrap-datepicker.min.js"></script>
<script src="/js/select2.full.min.js"></script>
<script>
    $(function () {
        $("#asset_type_id").change(function() {
        var val = $(this).val();
        if (val == 'LAPTOP' || val == 'DESKTOP') {
           $("#os_div").removeClass("hide");
           $("#ram_div").removeClass("hide");
           $("#hdd_div").removeClass("hide");
           $("#sys_type_div").removeClass("hide");
           $("#processor_div").removeClass("hide");
           $("#office_div").removeClass("hide");
           $("#antivirus_div").removeClass("hide");
           $("#win_license_div").removeClass("hide");
        }else{
           $("#ram_div").addClass("hide");
           $("#hdd_div").addClass("hide");
           $("#sys_type_div").addClass("hide");
           $("#processor_div").addClass("hide");
           $("#office_div").addClass("hide");
           $("#antivirus_div").addClass("hide");
           $("#win_license_div").addClass("hide");
        }
        });
          $(".select2").select2()
 })
</script>
@stop