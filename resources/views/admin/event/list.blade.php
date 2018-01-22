@extends('adminlte::page')
@section('content_header')
    <h1>{{$data['title']}}</h1>
@stop

@section('title', $data['title'])

@section('content')
    <div class="box">
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
                                <li><a href="#">Processar</a></li>
                                <li class="divider"></li>
                                <li><a href="#">Apagar</a></li>
                            </ul>
                        </div>
                    </td>
                </tr>
                    @endforeach
                </tbody>
                <tfoot>
                <tr>
                    <th>#</th>
                    <th>Evento</th>
                    <th>Datas</th>
                    <th>Cliente</th>
                    <th></th>
                </tr>
                </tfoot>
            </table>
        </div>
        <!-- /.box-body -->
    </div>
@stop

@section('js')
    <script>
        $(function () {
            $('#example1').DataTable()
            $('#example2').DataTable({
                'paging'      : true,
                'lengthChange': false,
                'searching'   : false,
                'ordering'    : true,
                'info'        : true,
                'autoWidth'   : false
            })
        })
    </script>
@stop


