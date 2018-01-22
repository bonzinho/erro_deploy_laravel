@extends('adminlte::page')

@section('content_header')
    @include('_common._alerts')
@stop

@section('title', 'Todos as tarefas abertas')

@section('content')
    <div class="info-box" style="margin-bottom: 20px; margin-top: 20px">
                <span class="info-box-icon bg-aqua" style="padding-top: 5px; width: 100%; height: 50px;">
                    <strong><h4>{{$task->id}} | {{$task->description}} | {{$task->date}}</h4></strong>
                </span>
        <div class="info-box-content">
            @if(isset($collaboratorTasks[$task->id]))
                @if($collaboratorTasks[$task->id])
                    <strong class="text-green">
                        <small class="label bg-green">Tens disponibilidade</small>
                        @if($task->state)
                            {!! Form::open(['route' => ['collaborator.events.task-response-update', $task->id], 'method' => 'put', 'style' => 'display: unset; position: absolute; margin-left: 1%;']) !!}
                            {!! Form::hidden('task', $task->id) !!}
                            {!! Form::hidden('value', $collaboratorTasks[$task->id]) !!}
                            <a href="#" onclick="$(this).closest('form').submit()" id="taskResponseUpdate-{{$task->id}}" data-id="{{$task->id}}" class="submitTaskResponseUpdate"><i class="fa fa-exchange" aria-hidden="true"></i></a>
                            {!! Form::close() !!}
                            </a>
                        @else
                            @if($collaboratorAllocation[$task->id] === null)
                                @if($task->state === 0)
                                    <small class="label bg-red">Não foi alocado!</small>
                                @else
                                    <small class="label bg-aqua">Aguarde que sejam feitas as alocações!</small>
                                @endif

                            @elseif($collaboratorAllocation[$task->id] === 0)
                                <small class="label bg-red">Não foi alocado</small>
                            @else
                                <small cla ss="label  bg-green">Foi alocado</small>
                                @if($collaboratorConfirm[$task->id] === 0)
                                    {!! Form::open(['route' => ['collaborator.events.task-allocation-confirm'], 'method' => 'put', 'style' => 'display: unset; position: absolute; margin-left: 1%;']) !!}
                                    {!! Form::hidden('task', $task->id) !!}
                                    <button type="submit" class="btn btn-adn">Confirmar Alocação</button>
                                    {!! Form::close() !!}
                                @else
                                    <small class="label bg-green" style="margin-top: 15px;">Alocação confirmada</small>
                                @endif
                            @endif
                        @endif
                    </strong>
                @else
                    <strong class="text-red">
                        <small class="label bg-red" style="margin-top: 15px;">Não tens disponibilidade</small>
                        @if($task->state)
                            {!! Form::open(['route' => ['collaborator.events.task-response-update', $task->id], 'method' => 'put', 'style' => 'display: unset; position: absolute; margin-left: 1%;']) !!}
                            {!! Form::hidden('task', $task->id) !!}
                            {!! Form::hidden('value', $collaboratorTasks[$task->id]) !!}
                            <a href="#" onclick="$(this).closest('form').submit()" id="taskResponseUpdate-{{$task->id}}" data-id="{{$task->id}}" class="submitTaskResponseUpdate"><i class="fa fa-exchange" aria-hidden="true"></i></a>
                            {!! Form::close() !!}
                            </a>
                        @endif
                    </strong>
                @endif
            @else
                {!! Form::open(['route' => ['collaborator.events.task-response', $task->id], 'method' => 'put', 'style' => 'display: unset; position: absolute; margin-left: 4%;']) !!}
                {!! Form::hidden('value', 1) !!}
                {!! Form::hidden('task', $task->id) !!}
                <button class="btn btn-success"><i class="fa fa-thumbs-o-up"></i></button>
                {!! Form::close() !!}

                {!! Form::open(['route' => ['collaborator.events.task-response', $task->id], 'method' => 'put']) !!}
                {!! Form::hidden('value', 0) !!}
                {!! Form::hidden('task', $task->id) !!}
                <button class="btn btn-danger"><i class="fa fa-thumbs-o-down"></i></button>
                {!! Form::close() !!}
            @endif
        </div>
    </div>

    @push('js')
    <script type="text/javascript">
        $(document).ready(function() {
            //DESTROY
            $('.submitTaskResponseUpdate').on('click', function() {
                id = $('#'+this.id).attr('data-id');
                $.ajax({
                    type: "POST",
                    data:{"id":id, "_token": "{{ csrf_token() }}", "_method": 'DELETE' },
                    dataType: 'json',
                    url: 'http://localhost:8000/admin/events/tasks/'+id+'/taskResponseUpdate/',
                    success: function( data ) {
                        alert('alterado com sucesso');
                    }
                });
            });
        });
    </script>
    @endpush
@stop