<div class="modal fade" id="schedules-{{$schedule->id}}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Editar horário do dia ({{$schedule->date}})</h4>
            </div>
            {!! Form::model($schedule, ['route' => ['admin.events.schedules-update', $schedule->id], 'id' => 'schedules_form-'.$schedule->id, 'method' => 'POST']) !!}
            <div class="modal-body">
                @include('admin.event.spaces._forms._edit_form')
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>