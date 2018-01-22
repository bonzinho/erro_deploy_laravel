@extends('adminlte::page')

@section('content_header')
    @include('_common._alerts')
@stop

@section('title', $data['title'])

@section('content')

    <div class="row">

        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3>{{$tasks}}</h3>
                    <p>Tarefas abertas</p>
                </div>
                <div class="icon">
                    <i class="fa fa-shopping-cart"></i>
                </div>
                <a href="{{route('collaborator.tasks.open')}}" class="small-box-footer">
                    Ver mais <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-green">
                <div class="inner">
                    <h3>{{$pending_tasks}}</h3>
                    <p>Tarefas não respondidas</p>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
                <a href="{{route('collaborator.tasks.not-responded')}}" class="small-box-footer">
                    Ver mais <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <!--<div class="col-lg-3 col-xs-6">
            <div class="small-box bg-yellow">
                <div class="inner">
                    <h3>44</h3>
                    <p>Confirmar Horários</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person-add"></i>
                </div>
                <a href="{{route('collaborator.tasks.confirm-schedule')}}" class="small-box-footer">
                    Ver mais <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-red">
                <div class="inner">
                    <h3>65€</h3>
                    <p>Valor a receber</p>
                </div>
                <div class="icon">
                    <i class="ion ion-pie-graph"></i>
                </div>
                <a href="#" class="small-box-footer">
                    Ver mais <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div> -->
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <strong>Próximos Eventos</strong>
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
                                            <li><a href="{{route('collaborator.events.show', [$event->id, 'collaborator'])}}">Ver</a></li>
                                            <li><a href="{{route('collaborator.events.show', [$event->id, 'collaborator'])}}">Espaços</a></li>
                                            <li><a href="{{route('collaborator.events.show', [$event->id, 'collaborator'])}}">Colaboradores</a></li>
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


@stop
