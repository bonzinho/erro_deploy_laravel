{!! Form::hidden('event_id', $event->id) !!}
<label for="date">Data</label>
{!! Form::text('date', null, ['class' => 'form-control', 'id' => 'date_'.$schedule->id, 'readonly']) !!}

<label for="init">Hora Início</label>
{!! Form::text('init', null, ['class' => 'form-control form-time', 'id' => 'init_'.$schedule->id, 'data-format' => 'hh:mm', 'placeholder' => 'formato -> 23:59']) !!}

<label for="end">Hora fim</label>
{!! Form::text('end', null, ['class' => 'form-control form-time', 'id' => 'end_'.$schedule->id, 'data-format' => 'hh:mm', 'placeholder' => 'formato -> 23:59']) !!}
<hr/>
@foreach($event->spaces as $espaco)
    <label for="space_id[]">
        {!! Form::checkbox('space_id[]', $espaco->id, false, ['id' => 'scheduler-'.$schedule->id.'-space-'.$espaco->id]) !!} {{$espaco->name}}
    </label>
    <br/>
@endforeach