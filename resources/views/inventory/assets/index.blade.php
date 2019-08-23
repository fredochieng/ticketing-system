@extends('adminlte::page')
@section('title', 'All assets - IT HelpDesk & Ticketing System')
@section('content_header')
<h1 class="pull-left">Inventory<small>Assets</small></h1>
<div style="clear:both"></div>

@stop
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="box box-success" id="accordion">
            <div class="box-header with-border">
                <h3 class="box-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseFilter">
                        <i class="fa fa-filter" aria-hidden="true"></i> Filters
                    </a>
                </h3>
            </div>
            <div id="collapseFilter" class="panel-collapse active collapse in" aria-expanded="true">
                <div class="box-body">
                    {!!
                    Form::open(['action'=>['AssetController@getSearchedAssets'],
                    'method'=>'POST','class'=>'form','enctype'=>'multipart/form-data'])
                    !!}
                    <div class="col-md-12">
                        <div class="col-md-3">
                            {{Form::label('Asset Type')}}
                            <div class="form-group">
                                <select class="form-control select2" id="category_name" name="category_name" required
                                    style="width: 100%;" tabindex="-1" aria-hidden="true">
                                    <option selected="selected" value="">Select asset type</option>
                                    @foreach($assect_categories as $item)
                                    <option value="{{ $item->asset_cat_name }}">{{ $item->asset_cat_name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            {{Form::label('Asset Status')}}
                            <div class="form-group">
                                <select class="form-control select2" id="asset_status_id" name="asset_status_id" required
                                    style="width: 100%;" tabindex="-1" aria-hidden="true">
                                    <option selected="selected" value="">Select asset status</option>
                                    @foreach($asset_status as $item)
                                    <option value="{{ $item->asset_status_id }}">{{ $item->asset_status_name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            {{Form::label('Asset Country')}}
                            <div class="form-group">
                                <select class="form-control select2" id="country_name" name="country_name" required
                                    style="width: 100%;" tabindex="-1" aria-hidden="true">
                                    <option selected="selected" value="">Select asset country</option>
                                    @foreach($countries as $item)
                                    <option value="{{ $item->country_name }}">{{ $item->country_name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <button type="submit" style="margin-top:25px;" class="btn btn-block btn-info"><strong><i
                                        class="fa fa-fw fa-eye"></i>View Assets</strong></button>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-12">
        <div class="box box-success">
            <div class="box-header with-border">
              @if($filter == 'N')
               <h3 class="box-title">All Assets</h3>
               @else
                <h3 class="box-title"><strong>{{$asset_type}} Assets</strong></h3>
                @endif
            </div>
            <div class="box-body">
                <div class="table-responsive">
                    <table id="example1" class="table no-margin" style="font-size:12px">
                        <thead>
                            <tr role="row">
                                <th>Staff Name</th>
                                <th>Asset No</th>
                                <th>Asset Type</th>
                                <th>Model No</th>
                                <th>Serial No</th>
                                <th>Status</th>
                                {{-- <th>RAM</th>
                                <th>OS</th>
                                <th>Processor</th> --}}
                                <th>Country</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($assets as $row)
                            <tr>
                            @if(empty($row->staff_name))
                            <td>NOT AVAILABLE</td>
                            @else
                                <td>{{$row->staff_name}}</td>
                                @endif
                                @if(empty($row->asset_no))
                                 <td>NOT AVAILABLE</td>
                                 @else
                                <td>{{$row->asset_no}}</td>
                                @endif
                                @if(empty($row->asset_type))
                                 <td>NOT AVAILABLE</td>
                                 @else
                                <td>{{$row->asset_type}}</td>
                                @endif
                                @if(empty($row->model_no ))
                                  <td>NOT AVAILABLE</td>
                                  @else
                                <td>{{ $row->model_no }}</td>
                                @endif
                                @if(empty($row->serial_no))
                                 <td>NOT AVAILABLE</td>
                                 @else
                                <td>{{ $row->serial_no }}</td>
                                @endif
                                <td><small class="badge bg-{{$row->status_color}}">{{$row->asset_status_name}}</small></span></td>
                                {{-- @if(empty($row->ram ))
                                 <td>NOT AVAILABLE</td>
                                 @else
                                <td>{{ $row->ram }}</td>
                                @endif
                                @if(empty($row->os))
                                 <td>NOT AVAILABLE</td>
                                 @else
                                <td>{{ $row->os }}</td>
                                @endif
                                @if(empty($row->processor))
                                 <td>NOT AVAILABLE</td>
                                 @else
                                <td>{{ $row->processor }}</td>
                                @endif --}}
                                  @if(empty($row->country))
                                 <td>NOT AVAILABLE</td>
                                 @else
                                <td>{{ $row->country }}</td>
                                @endif
                                     <td> <a href="/assets/manage/&id={{$row->asset_id}}"
                                        class="btn btn-flat btn-info btn-sm"><i class="fa fa-eye"></i></a></td>
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
