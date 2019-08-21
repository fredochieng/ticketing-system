<div class="modal fade in" id="modal_new_ticket" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" style="width:90%">
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
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Issue Category</label>
                            <select class="form-control select2" name="issue_category_id" id="categories"
                                style="width: 100%;" tabindex="-1" aria-hidden="true">
                                <option selected="selected">Select issue category</option>
                                @foreach($issue_categories as $category)
                                <option value='{{ $category->issue_id }}'>{{ $category->issue_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Issue Subcategory</label>
                            <select class="form-control select2" name="subcategory_id" id="subcategories"
                                style="width: 100%;" tabindex="-1" aria-hidden="true">
                                <option value="0" disabled="true" selected="true">Select issue category first</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            {{Form::label('Subject *')}}<br>
                            <div class="form-group">
                                {{Form::text('subject', '',['class'=>'form-control', 'required', 'placeholder'=>''])}}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            {{Form::label('description', 'Description')}}<br>
                            <div class="form-group">
                                {{Form::textarea('description', '',['class'=>'form-control', 'placeholder'=>''])}}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            {{Form::label('Username *')}}<br>
                            <div class="form-group">
                                {{Form::text('username', '',['class'=>'form-control', 'required', 'placeholder'=>''])}}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>User Country</label>
                            <select class="form-control select2" name="country_id" style="width: 100%;" tabindex="-1"
                                required aria-hidden="true">
                                <option value="">Select user country</option>
                                @foreach ( $countries as $row )
                                <option value="{{ $row->country_id }}">{{ $row->country_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Assign To</label>
                            <select class="form-control select2" name="assigned_user_id" style="width: 100%;"
                                tabindex="-1" aria-hidden="true">
                                <option value="">Select helpdesk technician</option>
                                @foreach ( $users as $row )
                                <option value="{{ $row->id }}">{{ $row->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Ticket Priority * </label>
                            <select class="form-control select2" name="priority_id" style="width: 100%;" required>
                                <option value="" selected>Please select priority</option>
                                @foreach ($priorities as $row )
                                <option value="{{ $row->priority_id }}">{{ $row->priority_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <input class="fileinput" type="file" id="file" name="file[]" multiple>
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
