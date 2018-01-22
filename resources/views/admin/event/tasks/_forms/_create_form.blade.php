{!! Form::hidden('event_id', $event->id) !!}

<label for="description">Descrição</label>
{!! Form::text('description', null, ['class' => 'form-control', 'id' => 'description_']) !!}

<label for="date">Data</label>
{!! Form::text('date', $day, ['class' => 'form-control', 'id' => 'date_', 'readonly']) !!}

<label for="init">Hora Início</label>
{!! Form::time('init', null, ['class' => 'form-control form-init form-time', 'id' => 'init_', 'data-format' => 'hh:mm', 'placeholder' => 'formato -> 23:59']) !!}

<label for="end">Hora fim</label>
{!! Form::time('end', null, ['class' => 'form-control form-end form-time', 'id' => 'end_', 'data-format' => 'hh:mm', 'placeholder' => 'formato -> 23:59']) !!}

<label for="end">Notas</label>
{!! Form::textarea('note', null, ['class' => 'form-control form-note', 'id' => 'note_', 'placeholder' => 'Notas sobre a tarefa']) !!}
<hr>
<label for="end">Notificar Colaboradores</label>
{!! Form::checkbox('notify', 1, ['class' => 'form-control form-end', 'id' => 'notify']) !!}



