@extends('adminlte::page')
@section('content_header')
    @include('_common._alerts')
    <div class="row">
        <div class="col-xs-2"><a href="{{route('admin.events.show', [$event->id, 'admin'])}}" type="button" class="btn btn-block btn-default btn-xs">Voltar</a></div>
        <div class="col-xs-4">
            @if($event->state->id == \App\Entities\Event::CONCULIDO && auth()->user()->can('manage availabilities'))
                {!! Form::open(['route' => ['admin.events.tasks.validate-all-schedules', $event->id], 'method' => 'post']) !!}
                    <button class="btn bnt-block btn-default btn-xs" id="confirm-all-schedules">
                            Confirmar todos os horários
                    </button>
                {!! Form::close() !!}
            @endif
        </div>
        <div class="col-xs-3"></div>
        <div class="col-xs-3"></div>
    </div>
    <i class="fa fa-check text-red"></i> Não Alocado
    <i class="fa fa-check text-green"></i> Alocado e a aguardar confirmação
    <i class="fa fa fa-check-circle text-green"></i> Alocado e confirmado
@stop

@section('title', $data['title'] .' - ' . $event->state->name)
@section('content')
    @foreach($daysArray as $day)
        <div class="row">
        <div class="col-xs-12">
            <div class="info-box" style="margin-bottom: 20px; margin-top: 20px">
                <span class="info-box-icon bg-aqua" style="padding-top: 5px; width: 100%; height: 50px;">
                    <strong><h4>{{trim($day)}}
                            @if($event->state_id < \App\Entities\Event::CONCULIDO)
                            <a href="" style="float: right; margin-right: 20px; color: #fff;" data-toggle="modal" data-target="#modal_horario_{{trim($day)}}"><i class="fa fa-plus"></i></a>
                            @endif
                        </h4>
                    </strong>
                </span>
                <div class="info-box-content">
                    @if($event->tasks->contains('date', \Carbon\Carbon::parse($day)->format('Y-m-d')))
                        @foreach($event->tasks as $task)
                            @if($task->date == \Carbon\Carbon::parse($day)->format('Y-m-d'))
                                <div schedule-delete="{{$task->id}}">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <ul class="list-group">
                                                <li class="list-group-item" style="background-color: #dedede; margin-top: 10px;">
                                                    <strong>{{$task->description}}</strong>
                                                    <p style="margin-top:5px; margin-bottom: 5px;">
                                                        <strong>{{$task->init}}</strong> às <strong>{{$task->end}}</strong>
                                                    <p>{{$task->note}}</p>
                                                    @if($event->state_id < \App\Entities\Event::CONCULIDO)
                                                        <a href="#schedules-{{$task->id}}" data-toggle="modal" class="edit-modal" id="{{$task->id}}">
                                                            <small class="label bg-green" style="margin-top: 15px;">
                                                                <i class="fa fa-edit"></i> Editar
                                                            </small>
                                                        </a>
                                                        <a href="#" class="destroy" data-destroy="{{$task->id}}" id="destroy-{{$task->id}}">
                                                            <small class="label bg-red" style="margin-top: 15px;">
                                                                <i class="fa fa-trash"></i> Apagar
                                                            </small>
                                                        </a>
                                                        <a href="{{route('admin.events.task_change_status', [$task->state, $task->id])}}" id="change-state-{{$task->id}}" class="change-state">
                                                            @if($task->state == 1)
                                                                <small class="label bg-green " style="margin-top: 15px;">
                                                                    <i class="fa fa-unlock"></i> Tarefa Aberta
                                                                </small>
                                                            @else
                                                                <small class="label bg-red " style="margin-top: 15px;">
                                                                    <i class="fa fa-lock"></i> Tarefa Fechada
                                                                </small>
                                                            @endif
                                                        </a>
                                                    @endif
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="col-md-12">
                                            <div style="margin: 10px;">
                                                <input type="checkbox" onClick="mass_selection(this.id)" class="mass-select-tarefa" id="tarefa-{{$task->id}}"> Seleccionar Todos
                                                <button class="btn btn-sm" onClick="mass_allocation(this.id)" id="btn_allocation_tarefa-{{$task->id}}">Alocar</button>
                                                <button class="btn btn-sm" onClick="mass_deallocation(this.id)" id="btn_remove_allocation_tarefa-{{$task->id}}" >Remover alocações</button>
                                            </div>
                                            <ul class="list-group">
                                                @if(isset($collaborators[$task->id]))
                                                    @foreach($collaborators[$task->id] as $collaborator)
                                                        <li class="list-group-item">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    {{$collaborator['name']}}
                                                                    @if($event->state_id === \App\Entities\Event::CONCULIDO)
                                                                        <a href="#modal-collaborator-change-{{$collaborator['id']}}-task-{{$task->id}}" data-toggle="modal"><i class="fa fa-exchange"></i></a>
                                                                    @endif
                                                                </div>
                                                                <div class="col-md-1">
                                                                    @if($event->state_id < \App\Entities\Event::CONCULIDO)
                                                                        {!! Form::hidden('collaborator_id[]', $collaborator['id'], ['class' => 'form-control collaborator-id-task-'.$task->id]) !!}
                                                                        {!! Form::hidden('task_id[]', $task->id, ['class' => 'form-control task-id-'.$task->id, 'id' => 'task_id_'.$task->id]) !!}
                                                                        <input type="checkbox" name="collab-select" class="collab-select-{{$task->id}}" value="{{$collaborator['id']}}">
                                                                        @if($collaborator['pivot']['allocation'] && !$collaborator['pivot']['confirm_allocation'])
                                                                            <i class="fa fa-check text-green" id="task-{{$task->id}}-{{$collaborator['id']}}"></i>
                                                                        @elseif(!$collaborator['pivot']['allocation'])
                                                                            <i class="fa fa-check text-red" id="task-{{$task->id}}-{{$collaborator['id']}}"></i>
                                                                        @else
                                                                            <i class="fa fa fa-check-circle text-green"></i>
                                                                        @endif
                                                                    @else
                                                                        @if($collaborator['pivot']['allocation'] && !$collaborator['pivot']['confirm_allocation'])
                                                                            <i class="fa fa-check text-green"></i>
                                                                        @elseif(!$collaborator['pivot']['allocation'])
                                                                            <i class="fa fa-check text-red"></i>
                                                                        @else
                                                                            <i class="fa fa fa-check-circle text-green"></i>
                                                                        @endif
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            @include('admin.event.tasks._forms._confirm_schedule')
                                                        </li>
                                                    @endforeach
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                    <hr>
                                </div>
                            @endif
                            @if($event->state_id < \App\Entities\Event::CONCULIDO)
                                @include('admin.event.tasks._modals._modal_edit')
                            @endif
                        @endforeach
                    @endif
                </div>
            </div>
            @if($event->state_id < \App\Entities\Event::CONCULIDO)
                @include('admin.event.tasks._modals._modal_add')
            @endif
        </div>
        </div>
    @endforeach

@endsection
@if($event->state_id < \App\Entities\Event::CONCULIDO)
    @push('js')
    <script type="text/javascript">
        $(document).ready(function() {
            $('.js-example-basic-single').select2({
                dropdownParent: "#modal-collaborator-change"
            });
            //vai haver ajax loading
            var modalLoading = '<div class="modal" id="pleaseWaitDialog" data-backdrop="static" data-keyboard="false" role="dialog">\
                                <div class="modal-dialog">\
                                    <div class="modal-content">\
                                        <div class="modal-header">\
                                            <h4 class="modal-title">Aguarde...</h4>\
                                        </div>\
                                        <div class="modal-body">\
                                            <div class="progress">\
                                              <div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar"\
                                              aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width:100%; height: 40px">\
                                              </div>\
                                            </div>\
                                        </div>\
                                    </div>\
                                </div>\
                            </div>';
            $(document.body).append(modalLoading);

            //DESTROY
            $('#confirm-all-schedules').on('click', function() {
                $.ajax({
                    type: "POST",
                    data:{"id":id, "_token": "{{ csrf_token() }}", "_method": 'DELETE' },
                    dataType: 'json',
                    url: 'http://192.168.21.106:8000/admin/events/tasks/'+id+'/destroy/',
                    success: function( data ) {
                        $('div[schedule-delete="'+id+'"]').remove();
                    }
                });
            });
        });

        $('.form-time').timepicker({
            timeFormat: 'HH:mm',
            interval: 15,
            minTime: '0',
            maxTime: '23',
            defaultTime: '07',
            startTime: '00',
            dynamic: false,
            dropdown: false,
            scrollbar: false
        });

        //mass selection for checkboxes
        function mass_selection(id){
           let str = id.split('-')[1];
            if ($('#'+id).is(':checked')) {
                $('.collab-select-'+str).prop("checked", true);
            } else {
                $('.collab-select-'+str).prop("checked", false);
            }
        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                "Accept":"application/json"
            }
        });

        function mass_allocation(id){
            let taskID = id.split('-')[1];
            valuesCollabID = [];
            $('.collaborator-id-task-'+taskID).each(function() {
                valuesCollabID.push($(this).val());
            });

            valuesSelect = [];
            totalCheckboxes =  $('.collab-select-'+taskID).length;
            verify = 0;
            $('.collab-select-'+taskID).each(function() {
                if($(this).is(':checked')){
                    valuesSelect.push($(this).val());
                    verify++;
                }
            });
            if(verify === 0){
                return false;
            }else{
                $("#pleaseWaitDialog").modal("show");
                $.ajax({
                    type: 'POST',
                    url: '{{url('/admin/events/tasks/allocate')}}',
                    datatType : 'JSON',
                    data: {
                        collaborator_id: valuesCollabID,
                        task_id: taskID,
                        select: valuesSelect,
                    },
                    success: function(data){
                        $(JSON.parse(data)).each(function (key, value) {
                            $("#task-" + taskID + "-" + value.collaborator_id).removeClass().addClass('fa fa-check text-green');
                        });
                        $("#pleaseWaitDialog").modal("hide");
                    }
                })
            }

        }

        function mass_deallocation(id){
            let taskID = id.split('-')[1];
            valuesCollabID = [];
            $('.collaborator-id-task-'+taskID).each(function() {
                valuesCollabID.push($(this).val());
            });

            valuesSelect = [];
            totalCheckboxes =  $('.collab-select-'+taskID).length;
            verify = 0;
            $('.collab-select-'+taskID).each(function() {
                if($(this).is(':checked')){
                    valuesSelect.push($(this).val());
                    verify++;
                }
            });
            if(verify === 0){
                return false;
            }else{
                $("#pleaseWaitDialog").modal("show");
                $.ajax({
                    type: 'POST',
                    url: '{{url('/admin/events/tasks/deallocate')}}',
                    datatType : 'JSON',
                    data: {
                        collaborator_id: valuesCollabID,
                        task_id: taskID,
                        select: valuesSelect,
                    },
                    success: function(data){
                        $(JSON.parse(data)).each(function(key, value){
                            $("#task-"+taskID+"-"+value.collaborator_id).removeClass().addClass('fa fa-check text-red');
                        });
                        $("#pleaseWaitDialog").modal("hide");
                    }
                })
            }

        }
    </script>
    @endpush
@endif




