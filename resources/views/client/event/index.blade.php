@extends('adminlte::create_event')
<div class="row">
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li class="error-message">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="alert alert-danger" id="error" style="display:none;">
        <ul id="error-message"></ul>
    </div>
    <div class="col-md-10 col-md-offset-1">
        <h3 class="text-center">CENTRO DE EVENTOS FEUP - <strong>PROPOR NOVO EVENTO</strong></h3>
    </div>
    <div class="col-md-10 col-md-offset-1">
        <form method="POST" action="" accept-charset="UTF-8" enctype="multipart/form-data" id="event_form">
            {{ method_field('PUT') }}
            {{ csrf_field() }}
            @include('client.event._form')
        </form>
    </div>
</div>

