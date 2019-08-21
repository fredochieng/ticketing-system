<div class="modal fade" id="modal_escalate_ticket">
    <div class="modal-dialog">
        <div class="modal-content">
            {!!
            Form::open(['action'=>['TicketController@escalateTicket',$tickets->ticket_id],'method'=>'POST','class'=>'floatit','enctype'=>'multipart/form-data'])
            !!}
            {{Form::text('ticket_id',$tickets->ticket_id,['class'=>'form-control hidden','placeholder'=>''])}}
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Escalate ticket to the next level</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Escalation Level</label>
                            <select class="form-control select2" required name="esc_level_id" style="width: 100%;"
                                tabindex="-1" aria-hidden="true">
                                <option value="">Select escalation level</option>
                                @foreach($esc_levels as $row)
                                <option value='{{ $row->id }}'>{{ $row->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-xs-12">
                        <div class="form-group">
                            <textarea class="form-control summernoteTicket" required
                                placeholder="Reason for escalation of the ticket" rows="4" name="message"></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-flat" data-dismiss="modal"><i class="fa fa-times"></i>
                    No</button>
                <button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-check"></i> Escalate</button>
            </div>
            {!! Form::close() !!}
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
