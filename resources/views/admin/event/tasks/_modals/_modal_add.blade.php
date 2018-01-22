<div class="modal fade" id="modal_horario_{{trim($day)}}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Adicionar horário ao dia ({{$day}})</h4>
            </div>
            {!! Form::open(['route' => 'admin.events.tasks-created', 'method' => 'post']) !!}
            <div class="modal-body">
                @include('admin.event.tasks._forms._create_form')
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>