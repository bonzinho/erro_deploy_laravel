{!! Form::hidden('event_id', $event->id) !!}
<label for="date">Data</label>
{!! Form::text('date', $day, ['class' => 'form-control', 'id' => 'date_', 'readonly']) !!}

<label for="init">Hora Início</label>
{!! Form::time('init', null, ['class' => 'form-control form-time', 'id' => 'init_', 'data-format' => 'hh:mm', 'placeholder' => 'formato -> 23:59']) !!}

<label for="end">Hora fim</label>
{!! Form::time('end', null, ['class' => 'form-control form-time', 'id' => 'end_', 'data-format' => 'hh:mm', 'placeholder' => 'formato -> 23:59']) !!}
<hr/>
@foreach($event->spaces as $espaco)
    <label for="space_id[]">
        {!! Form::checkbox('space_id[]', $espaco->id) !!} {{$espaco->name}}
    </label>
    <br/>
@endforeach