<div class="modal fade" id="modal_reply_ticket">
    <div class="modal-dialog">
        <div class="modal-content">
            {!!
            Form::open(['action'=>'TicketController@replyTicket','method'=>'POST','class'=>'form','enctype'=>'multipart/form-data'])
            !!}
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><strong>Reply to ticket ({{$tickets->ticket}})</strong></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    {{Form::text('ticket_id',$tickets->ticket_id,['class'=>'form-control hidden','placeholder'=>''])}}
                    <div class="col-xs-12">
                        <div class="form-group">
                            <textarea class="form-control" value="" rows="8.5" id="reply" name="reply"
                                required></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-flat" data-dismiss="modal"><i class="fa fa-times"></i>
                    Cancel</button>
                <button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-check"></i>Send Reply</button>

            </div>
            {!! Form::close() !!}
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
