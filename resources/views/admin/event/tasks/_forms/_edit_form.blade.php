{!! Form::hidden('event_id', $event->id) !!}
<label for="date">Descrição</label>
{!! Form::text('description', null, ['class' => 'form-control', 'id' => 'description_'.$task->id]) !!}

<label for="date">Data</label>
{!! Form::text('date', null, ['class' => 'form-control', 'id' => 'date_'.$task->id, 'readonly']) !!}

<label for="init">Hora Início</label>
{!! Form::time('init', null, ['class' => 'form-control form-time', 'id' => 'init_'.$task->id, 'data-format' => 'hh:mm', 'placeholder' => 'formato -> 23:59']) !!}

<label for="end">Hora fim</label>
{!! Form::time('end', null, ['class' => 'form-control form-time', 'id' => 'end_'.$task->id, 'data-format' => 'hh:mm', 'placeholder' => 'formato -> 23:59']) !!}
<!--<hr/>
<label for="end">Notificar Colaboradores</label>
{!! Form::checkbox('notify', 1, ['class' => 'form-control form-end', 'id' => 'notify']) !!} -->




