@extends('adminlte::page')
@section('content_header')
    @include('_common._alerts')
    <h3>Adicionar novo adminitrador</h3>
@stop

@section('title', 'Adicionar novo administrador')

@section('content')
    {!! Form::open(['route' => ['admin.configs.add-admin'], 'id' => 'add_admin_form', 'method' => 'POST']) !!}
        @include('admin.configs.admin._form')
    {!! Form::close() !!}
@stop