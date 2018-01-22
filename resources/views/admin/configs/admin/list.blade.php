@extends('adminlte::page')
@section('content_header')
    @include('_common._alerts')
    <h3>Adicionar novo adminitrador</h3>
@stop

@section('title', 'Adicionar novo administrador')

@section('content')
    <div class="row">
        <div class="col-md-8">
            <table id="table" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>phone</th>
                    <th>Nivel</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($admins as $admin)
                    <tr>
                        <td>{{$admin->id}}</td>
                        <td>{{$admin->nome}}</td>
                        <td>{{$admin->email}}</td>
                        <td>{{$admin->phone}}</td>
                        <td>
                            @foreach($admin->roles as $role)
                                {{$role->name}}
                            @endforeach
                        </td>
                        <td>
                            <div class="btn-group">
                                <button type="button" class="btn btn-warning">Acções</button>
                                <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown">
                                    <span class="caret"></span>
                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <ul class="dropdown-menu" role="menu">
                                    {!! Form::model($admin, ['route' => ['admin.configs.deactivate-admin', 'id' => $admin->id], 'method' => 'PUT']) !!}
                                    {!! Form::hidden('state', 0) !!}
                                    <li><button class="btn" type="submit">Apagar</button>
                                    {!! Form::close() !!}
                                </ul>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="col-md-4">
            {!! Form::open(['route' => ['admin.configs.add-admin'], 'id' => 'add_admin_form', 'method' => 'POST']) !!}
            @include('admin.configs.admin._form')
            {!! Form::close() !!}
        </div>
    </div>
@stop

@section('js')
    <script>
        $(function () {
            $('#table').DataTable({
                'paging'      : false,
                'lengthChange': false,
                'searching'   : false,
                'ordering'    : true,
                'info'        : false,
                'autoWidth'   : false
            })
        })
    </script>
@stop