@extends('adminlte::page')
@section('content_header')
    @include('_common._alerts')
    @include('_common._change-state-event')
@stop

@section('title', $data['title'] .' - ' . $event->state->name)

@section('content')
    @foreach($daysArray as $day)
        <div class="row">
            <div class="col-xs-12">
                @include('collaborator.event.tasks._box-disponibilidades')
                <hr/>
            </div>
        </div>

    @endforeach
@stop

@push('js')

<script type="text/javascript">
    $(document).ready(function() {

    });
</script>
@endpush





