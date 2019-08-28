<div class="modal fade" id="modal_import_assets">
    <div class="modal-dialog modal-sm" style="width:50%">
        <div class="modal-content">
            {!!
            Form::open(['action'=>['AssetController@importExcel'],
            'method'=>'POST','class'=>'form','enctype'=>'multipart/form-data'])
            !!}
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Import Assets (File types xlsx, csv)</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-12">
                            <div class="form-group">
                                {{Form::label('Import Asssets')}}<br>
                                <div class="form-group">
                                    {{-- <input type="file" name="import_file" /> --}}
                                    {{Form::file('import_file',['class'=>'form-control', 'required'])}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-flat" data-dismiss="modal"><i class="fa fa-times"></i>
                    No</button>
                <button type="submit" class="btn btn-success btn-flat"><i class="fa fa-check"></i> Import
                </button>
            </div>
            {!! Form::close() !!}
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>