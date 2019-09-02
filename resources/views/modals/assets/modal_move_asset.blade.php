<div class="modal fade" id="modal_move_asset_{{$assets->asset_id}}">
    <div class="modal-dialog modal-sm" style="width:50%">
        <div class="modal-content">
            {!!
            Form::open(['action'=>['AssetController@reassignAsset'],'method'=>'POST','class'=>'floatit','enctype'=>'multipart/form-data'])
            !!}

            <input type="hidden" name='asset_id' value="{{$assets->asset_id}}">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Reassign the asset</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-6">
                            <div class="form-group">
                                {{Form::label('Assign To (Staff Name) *')}}<br>
                                <div class="form-group">
                                    {{Form::text('staff_name', '',['class'=>'form-control', 'required', 'placeholder'=>''])}}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {{Form::label('Staff Payroll No *')}}<br>
                                <div class="form-group">
                                    {{Form::text('payroll_no', '',['class'=>'form-control', 'required', 'placeholder'=>''])}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-flat" data-dismiss="modal"><i class="fa fa-times"></i>
                    No</button>
                <button type="submit" class="btn btn-success btn-flat"><i class="fa fa-check"></i> Reassign
                    Asset</button>
            </div>
            {!! Form::close() !!}
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>