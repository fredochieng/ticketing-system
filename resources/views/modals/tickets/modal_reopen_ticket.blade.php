<div class="modal fade" id="modal_reopen_ticket_{{$tickets->ticket_id}}">
    <div class="modal-dialog">
        <div class="modal-content">
            {!!
            Form::open(['action'=>['TicketController@reopenTicket',$tickets->ticket_id],'method'=>'POST','class'=>'floatit','enctype'=>'multipart/form-data'])
            !!}

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Reopen Ticket</h4>
            </div>
            <input type="hidden" name="ticket_id" value="{{$tickets->ticket_id}}">
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <p>Are you sure you want to reopen the ticket <span
                                style="font-weight:bold">{{$tickets->ticket}}</span>?</p>
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
