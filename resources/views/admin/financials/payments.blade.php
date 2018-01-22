@extends('adminlte::page')
@section('content_header')
    <h1>Lista de pagamentos por fazer</h1>
@stop
@section('title', 'Pagamentos pendentes')

@section('content')
    <div class="box">
        <div class="box-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Telefone</th>
                    <th class="text-center">Pago</th>
                    <th class="text-center">T. H. Extras</th>
                    <th class="text-center">T. H. Normais</th>
                    <th class="text-center">A pagar</th>
                    <th>Acções</th>
                </tr>
                </thead>
                <tbody>
                @foreach($collaborators as $collaborator)
                    @if($collaborator->toPay > 0)
                    <tr>
                        @include('admin.financials.modal._pay')
                        <td>{{$collaborator->id}}</td>
                        <td>{{$collaborator->name}}</td>
                        <td>{{$collaborator->email}}</td>
                        <td class="text-center">{{$collaborator->pay}} €</td>
                        <td class="text-center">{{$collaborator->horasExtras}}</td>
                        <td class="text-center">{{$collaborator->horasNormais}}</td>
                        <td class="text-center text-bold">{{$collaborator->toPay}} €</td>
                        <td>
                            <div class="btn-group">
                                <button type="button" class="btn btn-warning">Acções</button>
                                <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown">
                                    <span class="caret"></span>
                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="{{route('admin.collaborators.show', [$collaborator->id])}}">Ver</a></li>
                                    <li>
                                        <a type="submit" href="#modal-{{$collaborator->id}}" data-toggle="modal">Pagar</a>
                                    </li>
                                    <li class="divider"></li>
                                    <li><a href="#">Desativar</a></li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                    @endif
                @endforeach
                </tbody>
            </table>
        </div>
        <!-- /.box-body -->
    </div>
@stop
@section('js')
    <script>
        $(function () {
            $('#example1').DataTable({
                'paging'      : false,
                'lengthChange': false,
                'searching'   : true,
                'ordering'    : true,
                'info'        : true,
                'autoWidth'   : true
            });
        });
    </script>
@stop


