<div class="modal fade in" id="modal_add_new_issue_subcategory" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            {!!
            Form::open(['action'=>['IssueController@storeIssueSub', $issue_id],'method'=>'POST','class'=>'form','enctype'=>'multipart/form-data'])
            !!}

            <input type="hidden" name='issue' value="{{$issue_id}}">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">
                    Create New Issue Sub Category
                </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            {{Form::label('Issue Sub Category Name *')}}<br>
                            <div class="form-group">
                                {{Form::text('name', '',['class'=>'form-control', 'required', 'placeholder'=>''])}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    {{Form::label('Description')}}<br>
                    <div class="form-group">
                        {{Form::textarea('description', '',['class'=>'form-control', 'placeholder'=>''])}}
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-flat" aria-label="Close" data-dismiss="modal"><i
                        class="fa fa-times"></i>Cancel</button>
                <button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-check"></i> Create New
                    Sub Category</button>
            </div>
            {!! Form::close() !!}

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
