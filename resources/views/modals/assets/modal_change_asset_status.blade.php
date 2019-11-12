<div class="modal fade" id="modal_change_asset_status_{{$assets->asset_id}}">
    <div class="modal-dialog modal-sm" style="width:50%">
        <div class="modal-content">
            {!!
            Form::open(['action'=>['AssetController@changeStatus'],'method'=>'POST','class'=>'floatit','enctype'=>'multipart/form-data'])
            !!}

            <input type="hidden" name='asset_id' value="{{$assets->asset_id}}">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Change Asset Status</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-12">
                            <div class="form-group">
                                {{Form::label('Assset Status')}}<br>
                                <div class="form-group">
                                    <select class="form-control select2 status_id" id="asset_status_id" name="status_id"
                                        style="width: 100%;">
                                        <option selected="selected">{{$status_name}}</option>
                                        @foreach($asset_status as $item)
                                        <option value="{{ $item->asset_status_id}}">{{ $item->asset_status_name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 hide" id="staff_name_div">
                            <div class="form-group">
                                {{Form::label('Assign To (Staff Name) *')}}<br>
                                <div class="form-group">
                                    {{Form::text('staff_name', '',['class'=>'form-control', 'placeholder'=>''])}}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 hide" id="payroll_no_div">
                            <div class="form-group">
                                {{Form::label('Staff Payroll No *')}}<br>
                                <div class="form-group">
                                    {{Form::text('payroll_no', '',['class'=>'form-control', 'placeholder'=>''])}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-flat" data-dismiss="modal"><i class="fa fa-times"></i>
                    No</button>
                <button type="submit" class="btn btn-success btn-flat"><i class="fa fa-check"></i> Change
                    Status</button>
            </div>
            {!! Form::close() !!}
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>