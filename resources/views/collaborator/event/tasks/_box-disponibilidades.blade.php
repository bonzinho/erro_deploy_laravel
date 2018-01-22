<div class="info-box" style="margin-bottom: 20px; margin-top: 20px">
                <span class="info-box-icon bg-aqua" style="padding-top: 5px; width: 100%; height: 50px;">
                    <strong><h4>{{trim($day)}}</h4></strong>
                </span>
    <div class="info-box-content">
        @if($event->tasks->contains('date', \Carbon\Carbon::parse($day)->format('Y-m-d')))
            @foreach($event->tasks as $task)
                @if($task->date === \Carbon\Carbon::parse($day)->format('Y-m-d'))

                        <div schedule-delete="{{$task->id}}">
                            <strong>{{$task->description}}</strong>
                            @if($task->state)
                                <small class="label pull-right bg-green">Aberta</small>
                            @else
                                <small class="label pull-right bg-red">Fechada</small>
                            @endif
                            <p style="margin-top:5px; margin-bottom: 5px;">
                                <strong>{{$task->init}}</strong> às <strong>{{$task->end}}</strong><br/>
                                {{$task->note}}
                            </p>
                            @if(isset($collaboratorTasks[$task->id]))
                                @if($event->state_id < \App\Entities\Event::CONCULIDO)
                                    @if($collaboratorTasks[$task->id])
                                        <strong class="text-green">
                                            <small class="label bg-green">Tens disponibilidade</small>
                                            @if($data['edit'])
                                                @if($collaboratorAllocation[$task->id] == null)
                                                    <small class="label bg-aqua">A aguardar alocações!</small>
                                                    @if($task->state == 1)
                                                        {!! Form::open(['route' => ['collaborator.events.task-response-update', $task->id], 'method' => 'put', 'style' => 'display: unset; position: absolute; margin-left: 1%;']) !!}
                                                        {!! Form::hidden('task', $task->id) !!}
                                                        {!! Form::hidden('value', $collaboratorTasks[$task->id]) !!}
                                                        <a href="#" onclick="$(this).closest('form').submit()" id="taskResponseUpdate-{{$task->id}}" data-id="{{$task->id}}" class="submitTaskResponseUpdate"><i class="fa fa-exchange" aria-hidden="true"></i></a>
                                                        {!! Form::close() !!}
                                                    @endif
                                                @elseif($collaboratorAllocation[$task->id] === 0)
                                                    <small class="label bg-red">Não foste alocado(a)</small>
                                                @elseif($collaboratorAllocation[$task->id] === 1)
                                                    <small class="label  bg-green">Foste alocado(a)</small>
                                                    @if($collaboratorAllocationAcept[$task->id] === 0)
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
                                            @if($data['edit'] && $task->state == 1)
                                                {!! Form::open(['route' => ['collaborator.events.task-response-update', $task->id], 'method' => 'put', 'style' => 'display: unset; position: absolute; margin-left: 1%;']) !!}
                                                {!! Form::hidden('task', $task->id) !!}
                                                {!! Form::hidden('value', $collaboratorTasks[$task->id]) !!}
                                                <a href="#" onclick="$(this).closest('form').submit()" id="taskResponseUpdate-{{$task->id}}" data-id="{{$task->id}}" class="submitTaskResponseUpdate"><i class="fa fa-exchange" aria-hidden="true"></i></a>
                                                {!! Form::close() !!}
                                            @endif
                                        </strong>
                                    @endif
                                 @else
                                    @if($tarefas[$task->id]->pivot->validate_confirm_schedule === 0)
                                            <small class="label bg-green">Estiveste Alocado a este evento</small>
                                            <small class="label bg-green">Aguarda que o horário seja validado</small>
                                        @else
                                            <div class="text-green">
                                                Validado e fechado.<br/>
                                                Horas Normais: {{$tarefas[$task->id]->pivot->total_normal_hour}} / {{$tarefas[$task->id]->pivot->normal_hour_value_total}}€ <br/>
                                                Horas Extras: {{$tarefas[$task->id]->pivot->total_extra_hour}} / {{$tarefas[$task->id]->pivot->extra_hour_value_total}}€ <br/>
                                                Total: {{$tarefas[$task->id]->pivot->normal_hour_value_total + $tarefas[$task->id]->pivot->extra_hour_value_total}} €
                                            </div>
                                    @endif

                                @endif
                            @elseif($data['edit'])
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
                            <hr>
                        </div>

                @endif
            @endforeach
        @endif
    </div>
</div>

@push('js')
@if($data['edit'])
<script type="text/javascript">
    $(document).ready(function() {
        //DESTROY
        $('.submitTaskResponseUpdate').on('click', function() {
            id = $('#'+this.id).attr('data-id');
            $.ajax({
                type: "POST",
                data:{"id":id, "_token": "{{ csrf_token() }}", "_method": 'POST' },
                dataType: 'json',
                url: 'http://localhost:8000/admin/events/tasks/'+id+'/taskResponseUpdate/',
                success: function( data ) {
                    alert('alterado com sucesso');
                }
            });
        });
    });
</script>
@endif
@endpush