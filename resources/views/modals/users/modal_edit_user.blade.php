<div class="modal fade in" id="modal_edit_user_{{$row->id}}" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            {!!
            Form::open(['action'=>['UserController@update',$row->id],'method'=>'PATCH','class'=>'form','enctype'=>'multipart/form-data'])
            !!}
            <input type="hidden" name='user' value="{{$row->id}}">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">
                    Edit User
                </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            {{Form::label('Name *')}}<br>
                            <div class="form-group">
                                {{Form::text('name', $row->name,['class'=>'form-control', 'required', 'placeholder'=>''])}}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            {{Form::label('Email Address *')}}<br>
                            <div class="form-group">
                                {{Form::email('email', $row->email,['class'=>'form-control', 'readonly', 'placeholder'=>''])}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="roleid">Role</label>
                            <select class="form-control select2 select2-hidden-accessible" name="role_id" id="roleid"
                                name="roleid" style="width: 100%;" tabindex="-1" aria-hidden="true">
                        <option value="{{$row->role_id}}" selected>{{$row->role_name}}</option>
                        @foreach ($roles as $role)
                        <option value='{{$role->id}}'>{{$role->name}}</option>
                        @endforeach
                        </select>
                    </div>
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
