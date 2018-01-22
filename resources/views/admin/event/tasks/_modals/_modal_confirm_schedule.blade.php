<div class="modal fade" id="schedules-{{$task->id}}-{{$collaborator['id']}}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Confirmar Horário para a tarefa <strong>{{$task->description}}</strong></h4>
            </div>
            {!! Form::model($task, ['route' => ['admin.events.tasks.validate-schedule', $task->id], 'id' => 'tasks_form-'.$task->id, 'method' => 'POST']) !!}
            <div class="modal-body">
                @include('admin.event.tasks._forms._edit_confirm_schedule')
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>