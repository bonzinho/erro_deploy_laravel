@extends('adminlte::page')
@section('content_header')
    <h1>#{{$collaborator->id}} {{$collaborator->name}}</h1>
@stop
@section('title', 'Colaboradores ativos')
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


                                <!-- Modal -->
                                <div class="modal fade" id="PhotoOption" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                    <div class="modal-dialog" style="width:30%;height:30%;">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                <h4 class="modal-title text-success" id="myModalLabel"><i class="fa fa-gear"></i> <span class="text-right">{{$collaborator->name}}</span></h4>
                                            </div>
                                            <div class="modal-body">
                                            <center><img src="https://lh5.googleusercontent.com/proxy/EkYugv9KzLUfAIpv-P4g6b0_mKxhcsfTvNmVueDn6XDHQp_SA0_hG2YFVAwB0Lbj_S-LrT-OtYsvxXMCrkZZMCmBfwelTQaAZW6GZwMQ8bRLwEvZonc0k0NxUpkhLBDuApx25K735rZfyHCIqA1RVpSdU84HF7U-j3xAwt3XLevAJtr5pwaVnRUC=w120-h120" class="img-responsive img-thumbnail"></center>
                                            </div>
                                            <div class="modal-footer">
                                                <a href="#" class="btn btn-success"><i class="fa fa-photo"></i> Upload</a>
                                                <a href="#" class="btn btn-danger"><i class="fa fa-trash"></i> Delete</a>
                                            </div>
                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                </div>
                                <!-- /.modal -->
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
                                                {!! Form::open(['route' => ['admin.collaborators.deactivate', $collaborator->id], 'class' => 'form-inline', 'method' => 'POST'] ) !!}
                                                <strong>Ativo</strong>
                                                    <button type="submit" class="btn btn-danger">Desativar</button>
                                                {!! Form::close() !!}
                                            </td>

                                                @else
                                            <td>
                                                {!! Form::open(['route' => ['admin.collaborators.activate', $collaborator->id], 'class' => 'form-inline', 'method' => 'POST'] ) !!}
                                                <strong>Inativo</strong>
                                                <button type="submit" class="btn btn-success">Ativar</button>
                                                {!! Form::close() !!}
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
                                        <tr>
                                            <td class="text-success"><i class="fa fa-envelope-o"></i>Enviar mensagem</td>
                                            <td><button class="btn btn-success"  data-toggle="modal" data-target="#msg-modal">Enviar mensagem</button></td>
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

<div class="modal" tabindex="-1" role="dialog" id="msg-modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Enviar mensagem a {{$collaborator->name}}</h5>
            </div>
            {!! Form::open(['route' => ['admin.collaborators.send-msg', $collaborator->id], 'method' => 'POST']) !!}
            <div class="modal-body">
                <div class="form-group">
                    {!! Form::text('subject', null, ['class' => 'form-control', 'placeholder' => 'Assunto']) !!}
                </div>
                <div class="form-group">
                    {!! Form::textarea('message', null, ['class' => 'form-control', 'placeholder' => 'Mensagem']) !!}
                </div>

            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Enviar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

@endsection