<div class="modal fade in" id="modal_edit_issue_category_{{$issue->issue_id}}" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            {!!
            Form::open(['action'=>['IssueController@update',$issue->issue_id],'method'=>'PATCH','class'=>'form','enctype'=>'multipart/form-data'])
            !!}
            <input type="hidden" name='issue_id' value="{{$issue->issue_id}}">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">
                    Edit Issue Category
                </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            {{Form::label('Issue Category Name *')}}<br>
                            <div class="form-group">
                                {{Form::text('name', $issue->issue_name,['class'=>'form-control', 'required', 'placeholder'=>''])}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    {{Form::label('Description')}}<br>
                    <div class="form-group">
                        {{Form::textarea('description', $issue->issue_description,['class'=>'form-control', 'placeholder'=>''])}}
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-flat" aria-label="Close" data-dismiss="modal"><i
                        class="fa fa-times"></i>Cancel</button>
                <button type="submit" class="btn btn-success btn-flat"><i class="fa fa-save"></i> Save
                    Changes</button>
            </div>
            {!! Form::close() !!}

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
