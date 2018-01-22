@extends('adminlte::page')

@section('content_header')
    @include('_common._alerts')
@stop

@section('title', 'Bem-vindo à Plataforma Centro de Eventos')
@section('content')
    <div class="row">
        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3>{{$penddingEvents}}</h3>
                    <p>Eventos Pendentes</p>
                </div>
                <div class="icon">
                    <i class="fa fa-eye-slash"></i>
                </div>
                <a href="{{url('admin/events/list/pending/admin')}}" class="small-box-footer">
                    Ver mais <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-green">
                <div class="inner">
                    <h3>{{$aprovedEvents}}</h3>
                    <p>Eventos Aprovados</p>
                </div>
                <div class="icon">
                    <i class="fa fa-calendar-check-o"></i>
                </div>
                <a href="{{url('admin/events/list/approved/admin')}}" class="small-box-footer">
                    Ver mais <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-yellow">
                <div class="inner">
                    <h3>{{$completeEvents}}</h3>
                    <p>Eventos Concluídos</p>
                </div>
                <div class="icon">
                    <i class="fa fa-calendar-times-o"></i>
                </div>
                <a href="{{url('admin/events/list/completed/admin')}}" class="small-box-footer">
                    Ver mais <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-red">
                <div class="inner">
                    <h3>{{$filledEvents}}</h3>
                    <p>Eventos Arquivados</p>
                </div>
                <div class="icon">
                    <i class="fa fa-euro"></i>
                </div>
                <a href="{{url('admin/events/list/filled/admin')}}" class="small-box-footer">
                    Ver mais <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <strong>Eventos nos próximos 7 dias</strong>
                </div>
                <div class="box-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Evento</th>
                            <th>Datas</th>
                            <th>Cliente</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($events as $event)
                            <tr>
                                <td>{{$event->id}}</td>
                                <td>{{$event->denomination}}</td>
                                <td>De <strong>{{$event->date_time_init}}</strong> até <strong>{{$event->date_time_end}}</strong></td>
                                <td>{{$event->client->name}}</td>
                                <td>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-warning">Acções</button>
                                        <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown">
                                            <span class="caret"></span>
                                            <span class="sr-only">Toggle Dropdown</span>
                                        </button>
                                        <ul class="dropdown-menu" role="menu">
                                            <li><a href="{{route('admin.events.show', [$event->id, 'admin'])}}">Ver</a></li>
                                            <li><a href="{{route('admin.events.show', [$event->id, 'admin'])}}">Espaços</a></li>
                                            <li><a href="{{route('admin.events.show', [$event->id, 'admin'])}}">Colaboradores</a></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection