@extends('adminlte::page')
@section('content_header')
    @include('_common._alerts')
    <div class="row">
        <div class="col-xs-2"><a href="{{route('admin.events.show', [$event->id, 'admin'])}}" type="button" class="btn btn-block btn-default btn-xs">Voltar</a></div>
        <div class="col-xs-4"></div>
        <div class="col-xs-3"></div>
        <div class="col-xs-3"></div>
    </div>
@stop

@section('title', $data['title'] .' - ' . $event->state->name)

@section('content')
    @foreach($daysArray as $day)
        <div class="col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-aqua" style="padding-top: 5px; width: 100%; height: 50px;">
                    <strong>
                        <h4>
                            {{trim($day)}}
                            @if($event->state_id < \App\Entities\Event::CONCULIDO)
                                <a href="" style="float: right; margin-right: 20px; color:#fff;" data-toggle="modal" data-target="#modal_horario_{{trim($day)}}">
                                <i class="fa fa-plus"></i>
                            </a>
                            @endif
                        </h4>
                    </strong>
                </span>
                <div class="info-box-content">
                    @if($event->schedules->contains('date', \Carbon\Carbon::parse($day)->format('Y-m-d')))
                            <div class="row">
                                <div class="col-md-12">
                                    <ul class="list-group">
                        @foreach($event->schedules as $schedule)
                            @if($schedule->date === \Carbon\Carbon::parse($day)->format('Y-m-d'))
                                <li class="list-group-item" schedule-delete="{{$schedule->id}}" style="background-color: #dedede; margin-top: 10px;">
                                    <p>
                                        <strong>{{$schedule->init}}</strong> às <strong>{{$schedule->end}}</strong>
                                        <span style="float: right">
                                            <a href="#schedules-{{$schedule->id}}" data-toggle="modal" class="edit-modal btn btn-default" id="{{$schedule->id}}"><i class="fa fa-edit"></i> Editar </a>
                                            <a href="#" class="destroy btn btn-danger" data-destroy="{{$schedule->id}}" id="destroy-{{$schedule->id}}"><i class="fa fa-trash"></i> Apagar</a>
                                        </span>
                                    </p>
                                    {{$schedule->space->name}}<br>
                                </li>
                            @endif
                                @if($event->state_id < \App\Entities\Event::CONCULIDO)
                                    @include('admin.event.spaces._modals._modal_edit')
                                @endif
                        @endforeach
                                    </ul>
                                </div>
                            </div>
                    @endif
                </div>
            </div>
            @if($event->state_id < \App\Entities\Event::CONCULIDO)
                @include('admin.event.spaces._modals._modal_add')
            @endif
        </div>
    @endforeach
@stop

@if($event->state_id < \App\Entities\Event::CONCULIDO)
@push('js')
<script type="text/javascript">
    $(document).ready(function() {
        $('.edit-modal').on('click', function() {
            let id = this.id;
            let event_id = {{$event->id}};
            let date = $('#date_'+id).val();
            let init = $('#init_'+id).val();
            let end =  $('#end_'+id).val();
            $.ajax({
                type: "GET",
                dataType: 'json',
                url: 'http://localhost:8000/admin/events/schedules/spaces/'+date+'/'+init+'/'+end+'/'+event_id,
                success: function( data ) {
                    $.each(data, function( key, value ) {
                        console.log('#scheduler-'+id+'-space-'+value.space_id);
                        $('#scheduler-'+id+'-space-'+value.space_id).prop('checked', true);
                    });
                }
            });
        });

        //DESTROY
        $('.destroy').on('click', function() {
            id = $('#'+this.id).attr('data-destroy');
            $.ajax({
                type: "POST",
                data:{"id":id, "_token": "{{ csrf_token() }}", "_method": 'DELETE' },
                dataType: 'json',
                url: 'http://localhost:8000/admin/events/schedules/'+id+'/destroy/',
                success: function( data ) {
                    $('li[schedule-delete="'+id+'"]').remove();
                }
            });
        });
    });

    $('.form-time').timepicker({
        timeFormat: 'HH:mm',
        interval: 15,
        minTime: '0',
        maxTime: '23',
        defaultTime: '07',
        startTime: '00',
        dynamic: false,
        dropdown: false,
        scrollbar: false
    });

</script>
@endpush
@endif





