@extends('adminlte::page')
@section('content_header')
    <h1>Colaboradores ativos</h1>
@stop

@section('title', 'Colaboradores ativos')

@section('content')
    <div class="box">
        <div class="box-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Telefone</th>
                    <th>Pago</th>
                    <th>A pagar</th>
                    <th>Acções</th>
                </tr>
                </thead>
                <tbody>
                @foreach($collaborators as $collaborator)
                    <tr>
                        <td>{{$collaborator->id}}</td>
                        <td>{{$collaborator->name}}</td>
                        <td>{{$collaborator->email}}</td>
                        <td>{{$collaborator->phone}}</td>
                        <td>0 €</td>
                        <td>0 €</td>
                        <td>
                            <div class="btn-group">
                                <button type="button" class="btn btn-warning">Acções</button>
                                <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown">
                                    <span class="caret"></span>
                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="{{route('admin.collaborators.show', [$collaborator->id])}}">Ver</a></li>
                                    <li><a href="#">Pagar</a></li>
                                    <li class="divider"></li>
                                    <li><a href="#">Desativar</a></li>
                                </ul>
                            </div>
                        </td>
                    </tr>
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


