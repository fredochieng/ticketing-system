<div class="modal fade in" id="modal_edit_ticket_{{$row->ticket_id}}">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            {!!
            Form::open(['action'=>'TicketController@store','method'=>'POST','class'=>'form','enctype'=>'multipart/form-data'])
            !!}
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">
                    Create New Ticket
                </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    {{-- <div class="col-md-6">
                        <div class="form-group">
                            {{Form::label('subject', 'Subject *')}}<br>
                            <div class="form-group">
                                {{Form::text('subject', '',['class'=>'form-control', 'required', 'placeholder'=>''])}}
                            </div>
                        </div>
                    </div> --}}
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Issue Category</label>
                            <select class="form-control select2" name="issue_category_id" id="issue_category_id" style="width: 100%;" tabindex="-1" aria-hidden="true">
                                <option selected="selected">Select issue category</option>
                               @foreach($issue_categories as $category)
                                <option value='{{ $category->issue_id }}'>{{ $category->issue_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Issue Subcategory</label>
                            <select class="form-control select2" name="issue_subcategory_id"  id="issue_subcategory_id" style="width: 100%;" tabindex="-1" aria-hidden="true">
                                <option value="0">Select issue subcategory</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>User Department</label>
                            <select class="form-control select2" name="department_id" style="width: 100%;" tabindex="-1"
                                aria-hidden="true">
                                <option selected="selected">Select user department</option>
                                @foreach ( $departments as $row )
                                <option value="{{ $row->department_id }}">{{ $row->department_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>User/Email Address</label>
                            <select class="form-control select2" name="user_id" style="width: 100%;" tabindex="-1"
                                aria-hidden="true">
                                <option selected="selected">Select user of the ticket</option>
                                @foreach ( $users as $row )
                                <option value="{{ $row->id }}">{{ $row->name }}</option>
                                @endforeach
                            </select>

                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Assign To</label>
                            <select class="form-control select2" name="assigned_user_id" style="width: 100%;"
                                tabindex="-1" aria-hidden="true">
                                <option selected="selected">Select helpdesk technician</option>
                                @foreach ( $users as $row )
                                <option value="{{ $row->id }}">{{ $row->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                </div>
                <div class="form-group">
                    {{Form::label('description', 'Description')}}<br>
                    <div class="form-group">
                        {{Form::textarea('description', '',['class'=>'form-control', 'placeholder'=>''])}}
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <div class="checkbox"><label><input type="checkbox" name="notification" value="true"
                                        checked="yes"> Send New Ticket Notification</label></div>
                        </div>
                        <input type="hidden" name="notification" value="false">
                    </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <input class="fileinput" type="file" id="file" name="file[]" multiple>
                                                    </div>
                                                </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <select class="form-control select2" name="priority_id" style="width: 100%;">
                                <option value="" selected>Please select priority</option>
                                @foreach ($priorities as $row )
                                <option value="{{ $row->priority_id }}">{{ $row->priority_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-flat" aria-label="Close" data-dismiss="modal"><i
                        class="fa fa-times"></i>Cancel</button>
                <button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-check"></i> Create New
                    Ticket</button>
            </div>
            {!! Form::close() !!}

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
