@extends('adminlte::page')
@section('content_header')
    @include('_common._alerts')
@stop

@section('title', $data['title'] .' - ' . $event->state->name)

@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title">DADOS DO CLIENTE</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body">
                    <strong>Denominação:</strong> {{$event->client->name}} <br/>
                    <strong>Ac:</strong> {{$event->client->ac_name}} <br/>
                    <strong>Email:</strong> {{$event->client->email}}<br/>
                    <strong>Telefone:</strong> {{$event->client->phone}}<br/>
                    <strong>NIF / CCO:</strong> {{$event->client->nif}}<br/>
                    <strong>Morada</strong> {{$event->client->address}}<br/>
                    <strong>Cod. Postal</strong> {{$event->client->postal_code}} - {{$event->client->locality}}<br/>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title">DADOS GERAIS</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body">
                    <strong>Nome do evento: </strong> {{$event->denomination}}<br/>
                    <strong>Data e hora inicio: </strong> {{$event->date_time_init}}<br/>
                    <strong>Data e hora fim: </strong> {{$event->date_time_end}}<br/>
                    <strong>Num. de participantes: </strong> {{$event->number_participants}}<br/>
                    <strong>Natureza: </strong> {{$event->nature->name}}<br/>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title">ESPAÇOS</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body">
                    @foreach($event->spaces as $space)
                        <strong>{{$space->name}}</strong><br/>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title">MATERIAIS</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body">
                    @foreach($event->materials as $material)
                        <strong>{{$material->name}}</strong> - {{$material->pivot->quantity}} Un.<br/>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title">AUDIOVISUAL</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body">
                    @foreach($event->audiovisuals as $audiovisual)
                        <strong>{{$audiovisual->name}}</strong><br/>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title">GRÁFICO</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body">
                    @foreach($event->graphics as $graphic)
                        <strong>{{$graphic->name}}</strong><br/>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title">SUPORTE</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body">
                    @foreach($event->supports as $support)
                        <strong>{{$support->name}}</strong><br/>
                    @endforeach
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-md-6">
            <div class="box collapsed-box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title">PLANO DE TRABALHO</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body">
                    {{$event->work_plan}}
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="box collapsed-box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title">RIDER TÉCNICO</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body">
                    {{$event->technical_raider}}
                </div>
            </div>
        </div>
    </div>

    <div class="row">

        <div class="col-md-6">
            <div class="box collapsed-box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title">PROGRAMA</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body">
                    {{$event->programme}}
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="box collapsed-box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title">NOTAS</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body">
                    {{$event->notes}}
                </div>
            </div>
        </div>

    </div>

@stop