<label for="init">Hora Início</label>
{!! Form::time('init_time_correction',$collaborator['pivot']['init_time_correction'], ['class' => 'form-control form-init form-time', 'id' => 'init_'.$task->id.'-'.$collaborator['id'], 'placeholder' => 'formato -> 23:59']) !!}

<label for="end">Hora fim</label>
{!! Form::time('end_time_correction', $collaborator['pivot']['end_time_correction'], ['class' => 'form-control form-end form-time', 'id' => 'end_'.$task->id.'-'.$collaborator['id'], 'placeholder' => 'formato -> 23:59']) !!}
{!! Form::hidden('task_id', $task->id) !!}
{!! Form::hidden('collaborator_id', $collaborator['id']) !!}
