@extends('adminlte::page')
@section('content_header')
    <h1>A minha conta</h1>
@stop
@section('title', 'Minha Conta')
@section('content')
<div class="row panel panel-success" style="margin-top:2%;">
    @include('_common._alerts')
    <div class="panel-body">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="row">
                    <div class="col-lg-3 col-md-3">
                        <center>
                            <span class="text-left">
                            <img src="{{asset('storage/'.$collaborator->photo)}}" class="img-responsive img-thumbnail">
                        </span></center>
                        <div class="table-responsive panel">
                            <table class="table">
                                <tbody>
                                <tr>
                                    <td class="text-center">
                                        <!-- <a href="#" class="btn btn-success btn-block" data-toggle="modal" data-target="#PhotoOption"><i class="fa fa-photo"></i> Alterar</a> -->
                                    </td>
                                </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-lg-9 col-md-9">
                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#Summery" class="text-success"><i class="fa fa-indent"></i> Sumário</a></li>
                            <li><a data-toggle="tab" href="#Contact" class="text-success"><i class="fa fa-bookmark-o"></i> Info. de Contacto</a></li>
                            <li><a data-toggle="tab" href="#Address" class="text-success"><i class="fa fa-home"></i> Morada</a></li>
                            <li><a data-toggle="tab" href="#General" class="text-success"><i class="fa fa-info"></i> Info. Geral</a></li>
                            <li><a data-toggle="tab" href="#Payments" class="text-success"><i class="fa fa-euro"></i> Pagamentos</a></li>
                        </ul>

                        <div class="tab-content">
                            <div id="Summery" class="tab-pane fade in active">

                                <div class="table-responsive panel">
                                    <table class="table">
                                        <tbody>
                                        <tr>
                                            <td class="text-success"><i class="fa fa-user"></i> ID</td>
                                            <td>#{{$collaborator->id}}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-success"><i class="fa fa-user"></i> Nome</td>
                                            <td>{{$collaborator->name}}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-success"><i class="fa fa-book"></i> Tipo</td>
                                            @if($collaborator->type == 0)
                                                <td>Técnico(a)</td>
                                            @elseif($collaborator->type == 1)
                                                <td>Hospedeiro(a)</td>
                                            @else
                                                <td>Misto</td>
                                            @endif
                                        </tr>
                                        <tr>
                                            <td class="text-success"><i class="fa fa-group"></i> Estado</td>
                                            @if($collaborator->state == 1)
                                            <td>
                                                <strong>Ativo</strong>
                                            </td>
                                                @else
                                            <td>
                                                <strong>Inativo</strong>
                                            </td>
                                            @endif
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div id="Payments" class="tab-pane fade">
                                <div class="table-responsive panel">
                                    <table class="table">
                                        <tbody>
                                        <tr>
                                            <td class="text-success"><i class="fa fa-home"></i> Total</td>
                                            <td>{{$collaborator->total}} €</td>
                                        </tr>
                                        <tr>
                                            <td class="text-success"><i class="fa fa-home"></i> Total {{\Carbon\Carbon::now()->format('Y')}}</td>
                                            <td>{{$collaborator->totalYear}} €</td>
                                        </tr>
                                        <tr>
                                            <td class="text-success"><i class="fa fa-home"></i> Pendente</td>
                                            <td>{{$collaborator->totalPaymentPending}} €</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div id="Address" class="tab-pane fade">
                                <div class="table-responsive panel">
                                    <table class="table">
                                        <tbody>
                                        <tr>
                                            <td class="text-success"><i class="fa fa-home"></i> Address</td>
                                            <td>
                                                <address>
                                                    {{$collaborator->address}} <br>
                                                    {{$collaborator->postal_code}} - {{$collaborator->locality}}
                                                </address>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div id="Contact" class="tab-pane fade">
                                <div class="table-responsive panel">
                                    <table class="table">
                                        <tbody>

                                        <tr>
                                            <td class="text-success"><i class="fa fa-envelope-o"></i> Email</td>
                                            <td><a href="mailto:{{$collaborator->email}}">{{$collaborator->email}}</a></td>
                                        </tr>
                                        <tr>
                                            <td class="text-success"><i class="glyphicon glyphicon-phone"></i> Telefone</td>
                                            <td>{{$collaborator->phone}}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div id="General" class="tab-pane fade">
                                <div class="table-responsive panel">
                                    <table class="table">
                                        <tbody>
                                        <tr>
                                            <td class="text-success"><i class="fa fa-university"></i> cc</td>
                                            <td>{{$collaborator->cc}}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-success"><i class="fa fa-calendar"></i> NIF</td>
                                            <td>{{$collaborator->nif}}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-success"><i class="fa fa-home"></i> IBAN</td>
                                            <td>{{$collaborator->iban}}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-success"><i class="fa fa-calendar"></i> CV</td>
                                            <td><a href="{{asset($collaborator->cv)}}" target="_blank">Download</a></td>
                                        </tr>
                                        <tr>
                                            <td class="text-success"><i class="fa fa-medkit"></i> Total Pago este ano</td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td class="text-success"><i class="fa fa-thumbs-up"></i> Grande Total</td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td class="text-success"><i class="glyphicon glyphicon-time"></i> Por pagar</td>
                                            <td></td>
                                        </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>

                    </div>

                </div>
            </div>
        </div>
        <!-- /.table-responsive -->

    </div>
</div>

@endsection