@extends('adminlte::page')
@section('content_header')
    <h1>{{ $data['title'] }}</h1>
@stop

@section('title', 'Centro de Eventos FEUP')

@section('content')
    <div class="box">
        <div class="box-body">
            <table id="event_list" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Evento</th>
                    <th>Datas</th>
                    <th>Natureza</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($events as $event)
                <tr>
                    <td>{{$event->id}}</td>
                    <td>{{$event->denomination}}</td>
                    <td>De <strong>{{$event->date_time_init}}</strong> até <strong>{{$event->date_time_end}}</strong></td>
                    <td>{{$event->nature->name}}</td>
                    <td>
                        <div class="btn-group">
                            <button type="button" class="btn btn-warning">Acções</button>
                            <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown">
                                <span class="caret"></span>
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{route('client.events.show', [$event->id, 'client'])}}">Ver</a></li>
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
            $('#event_list').DataTable({
                'paging'      : false,
                'lengthChange': false,
                'searching'   : true,
                'ordering'    : true,
                'info'        : true,
                'autoWidth'   : true
            })
        })
    </script>
@stop


