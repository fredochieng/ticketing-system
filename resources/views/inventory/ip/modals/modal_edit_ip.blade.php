<div class="modal fade in" id="modal_edit_ip_{{ $ip->server_id }}" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" style="width:90%">
        <div class="modal-content">
            {!!
            Form::open(['action'=>'IPInventoryController@store','method'=>'POST','class'=>'form'])
            !!}
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">
                    Edit Server - {{ $ip->server_ip }} ({{ $ip->server_name}} )
                </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            {{Form::label('Server Name *')}}<br>
                            <div class="form-group">
                                {{Form::text('server_name', $ip->server_name,['class'=>'form-control', 'required', 'placeholder'=>'Enter server name'])}}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            {{Form::label('Server IP *')}}<br>
                            <div class="form-group">
                                {{Form::text('server_ip', $ip->server_ip,['class'=>'form-control', 'required', 'placeholder'=>'Enter server IP'])}}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            {{Form::label('Server Description *')}}<br>
                            <div class="form-group">
                                {{Form::text('server_desc', $ip->server_desc,['class'=>'form-control', 'required', 'placeholder'=>'Enter server description'])}}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            {{Form::label('Username *')}}<br>
                            <div class="form-group">
                                {{Form::text('server_username', $ip->server_username,['class'=>'form-control', 'required', 'placeholder'=>'Enter server username'])}}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            {{Form::label('Password *')}}<br>
                            <div class="form-group">
                                <input type="text" name="server_password" class="form-control"
                                    value="{{$ip->server_password}}" placeholder="Enter server password" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Server Location (Floor)</label>
                            <select class="form-control select2" name="server_floor" style="width: 100%;" tabindex="-1"
                                required aria-hidden="true">
                                <option value="{{$ip->server_floor}}">{{$ip->server_floor}}</option>
                                <option value="First Floor">First Floor</option>
                                <option value="Second Floor">Second Floor</option>
                                <option value="Third Floor">Third Floor</option>
                                <option value="Fourth Floor">Fourth Floor</option>
                                <option value="Fifth Floor">Fifth Floor</option>

                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-flat" aria-label="Close" data-dismiss="modal"><i
                        class="fa fa-times"></i>Cancel</button>
                <button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-check"></i> Save Changes
                </button>
            </div>
            {!! Form::close() !!}

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>