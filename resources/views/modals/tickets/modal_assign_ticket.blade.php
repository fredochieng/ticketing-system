<div class="modal fade" id="modal_assign_ticket">
    <div class="modal-dialog">
        <div class="modal-content">
            {!!
            Form::open(['action'=>'TicketController@assignTicket','method'=>'POST','class'=>'form','enctype'=>'multipart/form-data'])
            !!}
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                @if(auth()->user()->isAdmin())
                <h4 class="modal-title">Assign the ticket helpdesk team</h4>
                @elseif(auth()->user()->isSysManager())
                <h4 class="modal-title">Assign the ticket system developer</h4>
                @endif
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-12">
                            {{Form::text('ticket_id',$tickets->ticket_id,['class'=>'form-control hidden','placeholder'=>''])}}
                            <div class="form-group">
                                @if(auth()->user()->isAdmin())
                                <label>Helpdesk Technicians</label>
                                @elseif(auth()->user()->isSysManager())
                                <label>System Developers</label>
                                @endif

                                <select class="form-control select2" name="helpdesk_user_id" required
                                    style="width: 100%;" tabindex="-1" aria-hidden="true">
                                    @if(auth()->user()->isAdmin())
                                    <option value="">Please select helpdesk technician</option>
                                    @elseif(auth()->user()->isSysManager())
                                    <option value="">Please select system developer</option>
                                    @endif

                                    @foreach ($helpdesk_technicians as $row )
                                    <option value="{{ $row->id }}">{{ $row->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-flat" data-dismiss="modal"><i class="fa fa-times"></i>
                    Cancel</button>
                <button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-check"></i> Assign
                    Ticket</button>

            </div>
            {!! Form::close() !!}
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>