@if($event->state_id == \App\Entities\Event::CONCULIDO || $event->state_id == \App\Entities\Event::ARQUIVADO)
    @if($collaborator['pivot']['init_time_correction'] == null && $collaborator['pivot']['end_time_correction'] == null && $collaborator['pivot']['confirm_allocation'] === 1)
        <div class="row">
            <div class="col-md-10">
                <div class="text-red">Colaborador ainda não confirmou o hórario</div>
            </div>
            <div class="col-md-2">
                <a href="#schedules-{{$task->id}}-{{$collaborator['id']}}" data-toggle="modal" class="edit-modal" id="{{$task->id}}">
                    <i class="fa fa-calendar-check-o text-red"></i>
                </a>
            </div>
        </div>
        @include('admin.event.tasks._modals._modal_confirm_schedule') <!-- Modal para admin confirmar o horário-->
        @if($event->state_id === \App\Entities\Event::CONCULIDO)
            <div class="modal" id="modal-collaborator-change-{{$collaborator['id']}}-task-{{$task->id}}">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Selecione Novo colaborador</h4>
                        </div>
                        <div class="modal-body">
                            {{Form::open(['route' => 'admin.events.tasks.change-collaborator', 'method' => 'post'])}}
                            {{Form::hidden('old_id_collaborator', $collaborator['id'])}}
                            {{Form::hidden('task_id', $task->id)}}
                            <div class="form-group">
                                <label for="new_collaborator_id">Selecionar Colaborador para substituir</label>
                                <select class="form-control js-example-basic-single" name="collaborator_id">
                                    @foreach($allCollaborators as $collaborator)
                                        <option value="{{$collaborator->id}}">{{$collaborator->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <input type="submit" class="btn btn-danger right" value="Substituir">
                                <button class="btn btn-success" type="button">Cancelar</button>
                            </div>
                            {{Form::close()}}
                        </div>
                    </div>
                </div>
            </div>
        @endif

    @elseif($collaborator['pivot']['init_time_correction'] != null && $collaborator['pivot']['end_time_correction'] != null && $collaborator['pivot']['confirm_allocation'] === 1 && $collaborator['pivot']['validate_confirm_schedule'] == 0)

        <div class="row">
            <div class="col-md-10">
                <div class="text-green">Colaborador já confirmou horário, por favor faça a validação</div>
            </div>
            <div class="col-md-2">
                <a href="#schedules-{{$task->id}}-{{$collaborator['id']}}" data-toggle="modal" class="edit-modal" id="{{$task->id}}">
                    <i class="fa fa-calendar-check-o text-green"></i>
                </a>
            </div>
        </div>
        @include('admin.event.tasks._modals._modal_validate_schedule') <!--  Modal para admin validar horario confirmado pelo colaborador-->
    @else
        <div class="row">
            <div class="col-md-10">
                <div class="text-green">
                    Validado e fechado.<br/>
                    Horas Normais: {{$collaborator['pivot']['total_normal_hour']}} / {{$collaborator['pivot']['normal_hour_value_total']}}€ <br/>
                    Horas Extras: {{$collaborator['pivot']['total_extra_hour']}} / {{$collaborator['pivot']['extra_hour_value_total']}}€ <br/>
                    Total: {{$collaborator['pivot']['normal_hour_value_total'] + $collaborator['pivot']['extra_hour_value_total']}} €
                </div>
            </div>
            <div class="col-md-2">

            </div>
        </div>
    @endif
@endif

@push('js')
<script type="text/javascript">

</script>
@endpush