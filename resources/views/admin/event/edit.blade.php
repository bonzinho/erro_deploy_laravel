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
    {!! Form::model($event, ['route' => ['admin.events.update', $event->id], 'id' => 'event_form', 'method' => 'PUT', 'files' => true]) !!}
        @include('admin.event._form')
    {!! Form::close() !!}
@stop