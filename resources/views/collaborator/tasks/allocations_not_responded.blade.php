@extends('adminlte::page')

@section('content_header')
    @include('_common._alerts')
@stop

@section('title', 'Todas as terefas sem resposta')

@section('content')
    <div class="box">
        <div class="box-body">
            <table id="open_tasks" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>#Tarefa</th>
                    <th>Evento</th>
                    <th>Tarefa</th>
                    <th>Data & Horário</th>
                    <th>Acções</th>
                </tr>
                </thead>
                <tbody>
                @foreach($pending_tasks as $task)
                        @if($task->state == 1)
                            <tr>
                                <td>{{$task->id}}</td>
                                <td>{{$task->event->denomination}}</td>
                                <td>{{$task->description}}</td>
                                <td>{{$task->date}} das {{$task->init}} às {{$task->end}}</td>
                                <td>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-warning">Acções</button>
                                        <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown">
                                            <span class="caret"></span>
                                            <span class="sr-only">Toggle Dropdown</span>
                                        </button>
                                        <ul class="dropdown-menu" role="menu">
                                            <li><a href="{{route('collaborator.events.show', [$task->event->id, 'collaborator'])}}">Ver Evento</a></li>
                                            <li><a href="{{route('collaborator.events.tasks', [$task->event->id])}}">Ver tarefas</a></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @endif
                @endforeach

                </tbody>
                <tfoot>
                <tr>
                    <th>#</th>
                    <th>Evento</th>
                    <th>Tarefa</th>
                    <th>Data & Horário</th>
                    <th>Acções</th>
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
            $('#open_tasks').DataTable();
        })
    </script>
@endsection