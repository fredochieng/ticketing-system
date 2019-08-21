<div class="modal fade" id="modal_close_ticket">
    <div class="modal-dialog">
        <div class="modal-content">
            {!!
            Form::open(['action'=>['TicketController@closeTicket',$tickets->ticket_id],'method'=>'POST','class'=>'floatit','enctype'=>'multipart/form-data'])
            !!}
            {{Form::text('ticket_id',$tickets->ticket_id,['class'=>'form-control hidden','placeholder'=>''])}}
            <input type="hidden" name="closed_by" value="<?php echo Auth::user()->id ?>">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Categorize and close the ticket</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    {{-- <div class="col-md-12">
                        <p>Are you sure you want to close ticket <span style="font-weight:bold">{{$tickets->ticket}}</span>?
                    </p>
                </div> --}}
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Issue Category</label>
                        <select class="form-control select2" required name="issue_category_id" id="categories"
                            style="width: 100%;" tabindex="-1" aria-hidden="true">
                            <option value="">Select issue category</option>
                            @foreach($issue_categories as $category)
                            <option value='{{ $category->issue_id }}'>{{ $category->issue_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Issue Subcategory</label>
                        <select class="form-control select2" name="subcategory_id" id="subcategories"
                            style="width: 100%;" tabindex="-1" aria-hidden="true">
                            <option value="0" disabled="true" selected="true">Select issue category first</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Reason for outage</label></label>
                        <textarea class="form-control summernoteTicket" value="" required rows="7.5" id="reason"
                            placeholder="Enter reason for outtage" name="reason"></textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-default btn-flat" data-dismiss="modal"><i class="fa fa-times"></i>
                No</button>
            <button type="submit" class="btn btn-danger btn-flat"><i class="fa fa-check"></i> Yes</button>
        </div>
        {!! Form::close() !!}
    </div>
    <!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
</div>
