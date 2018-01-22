@extends('adminlte::page')
@section('content_header')
    @include('_common._alerts')
    <div class="row">
        <div class="col-xs-2"><a href="{{route('collaborator.events.show', [$event->id, 'collaborator'])}}" type="button" class="btn btn-block btn-default btn-xs">Voltar</a></div>
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
                    <strong><h4>{{trim($day)}}</h4></strong>
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
                                    </p>
                                    {{$schedule->space->name}}<br>
                                </li>
                            @endif
                        @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endforeach
@stop