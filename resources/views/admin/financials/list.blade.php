@extends('adminlte::page')
@section('content_header')
    <h1>Histórico de pagamentos</h1>
@stop

@section('title', 'Histórico de pagamentos')
@section('content')
    @include('_common._alerts')
    <div class="box">
        <div class="box-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Telefone</th>
                    <th>PAD</th>
                    <th>Total</th>
                    <th>Acções</th>
                </tr>
                </thead>
                <tbody>
                @foreach($financials as $f)
                    <tr>
                        <td>{{$f->id}}</td>
                        <td>{{$f->collaborator->name}}</td>
                        <td>{{$f->collaborator->email}}</td>
                        <td>{{$f->collaborator->phone}}</td>
                        <td>{{$f->pad}}</td>
                        <td>{{$f->payment}} €</td>
                        <td>
                            <div class="btn-group">
                                <button type="button" class="btn btn-warning">Acções</button>
                                <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown">
                                    <span class="caret"></span>
                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="{{route('admin.collaborators.show', [$f->collaborator_id])}}">Ver Colaborador</a></li>
                                    @if($f->receipt !== null)
                                        <li><a href="{{asset('storage/collaborator/receipts/'.$f->receipt)}}" target="_blank">Ver Recibo</a></li>
                                    @else
                                        <li><a href="#modal-{{$f->collaborator->id}}" data-toggle="modal">Adicionar Recibo</a></li>
                                    @endif
                                    <li class="divider"></li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                    @include('admin.financials.modal._add_receipt')
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


