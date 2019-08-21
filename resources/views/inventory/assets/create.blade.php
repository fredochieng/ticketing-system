@extends('adminlte::page')
@section('title', 'Create Asset - IT HelpDesk')
@section('content_header')
<h1 class="pull-left">Assets<small>Manage assets</small></h1>
<div style="clear:both"></div>
@stop
@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Create New Asset</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="container-fluid">
                    <div class="row">
                        {!! Form::open(['action'=>'AssetController@store','method'=>'POST','class'=>'form','enctype'=>'multipart/form-data']) !!}
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-6">
                                    {{Form::label('Asset Tag *')}}<br>
                                    <div class="form-group">
                                        {{Form::text('asset_tag', 'WG',['class'=>'form-control'])}}
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        {{Form::label('Asset Number *')}}<br>
                                        <div class="form-group">
                                            {{Form::text('asset_no', '',['class'=>'form-control',])}}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        {{Form::label('Category')}}<br> {{ Form::select('category_id',$categories,null, ['class'
                                        => 'form-control select2', 'placeholder'=>'Please select category']) }}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        {{Form::label('Asset Status')}}<br> {{ Form::select('status_id',$asset_status,null,
                                        ['class' => 'form-control select2', 'placeholder'=>'Please select asset status'])
                                        }}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        {{Form::label('Manufacturer')}}<br> {{ Form::select('manufacturer_id',$manufacturers,null,
                                        ['class' => 'form-control select2', 'placeholder'=>'Please select manufacturer'])
                                        }}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    {{Form::label('Model *')}}<br>
                                    <div class="form-group">
                                        {{Form::text('model', '',['class'=>'form-control'])}}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        {{Form::label('RAM')}}<br> {{ Form::select('ram_id',$ram,null, ['class' => 'form-control
                                        select2', 'placeholder'=>'Please select RAM size']) }}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        {{Form::label('HDD')}}<br> {{ Form::select('hdd_id',$hdd,null, ['class' => 'form-control
                                        select2', 'placeholder'=>'Please select HDD size']) }}
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        {{Form::label('Asset User')}}<br> {{ Form::select('user_id',$users,null, ['class'
                                        => 'form-control select2', 'placeholder'=>'Please select category']) }}
                                    </div>
                                </div>
                                <div class="col-md-12"></div>
                            </div>
                        </div>

                        <div class="col-md-6">

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="purchase_date">Purchase Date</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control purchase_date" id="purchase_date" name="purchase_date">
                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="warranty_months">Warranty</label>
                                        <div class="input-group">
                                            <input type="number" class="form-control" id="warranty_months" name="warranty_months">
                                            <span class="input-group-addon">months</span>
                                        </div>
                                    </div>
                                </div>

                                {{--
                                <div class="col-md-6">
                                    <div class="form-group">
                                        {{Form::label('Warranty *')}}<br>
                                        <div class="form-group">
                                            <div class="input-group">
                                                {{Form::number('asset_no', '',['class'=>'form-control', 'id'=>'warranty_months'])}}
                                                <span class="input-group-addon"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div> --}}

                                <div class="col-md-6">
                                    <div class="form-group">
                                        {{Form::label('Serial Number *')}}<br>
                                        <div class="form-group">
                                            {{Form::text('serial_no', '',['class'=>'form-control'])}}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        {{Form::label('System Type')}}<br> {{ Form::select('system_type_id',$system_types,null,
                                        ['class' => 'form-control select2', 'placeholder'=>'Please select system type'])
                                        }}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        {{Form::label('Operating System')}}<br> {{ Form::select('os_id',$os,null, ['class'
                                        => 'form-control select2', 'placeholder'=>'Please select operating system']) }}
                                    </div>
                                </div>


                                <div class="col-md-6">
                                    <div class="form-group">
                                        {{Form::label('Processor Type')}}<br> {{ Form::select('processor_id',$processors,null,
                                        ['class' => 'form-control select2', 'placeholder'=>'Please select processor']) }}
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        {{Form::label('Microsoft Office')}}<br> {{ Form::select('office_id',$office,null,
                                        ['class' => 'form-control select2', 'placeholder'=>'Please select office package'])
                                        }}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        {{Form::label('Windows Licence')}}<br> {{ Form::select('licence_id',$windows_licence,null,
                                        ['class' => 'form-control select2', 'placeholder'=>'Please select windows licence'])
                                        }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="notes">Description</label>
                                <textarea class="form-control summernoteLarge" id="notes" name="notes"></textarea>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Create New Asset</button>
                            </div>
                        </div>
                        {!! Form::close() !!}
                        <!-- /.form -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
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
	 $('.purchase_date').datepicker( {
	 	format: 'dd-mm-yyyy',
		orientation: "bottom",
		autoclose: true,
         showDropdowns: true,
         todayHighlight: true,
         toggleActive: true,
         startDate: new Date(),
         clearBtn: true,
     })
          $(".select2").select2()
          $('#example1').DataTable()
 })
</script>



















































































@stop
