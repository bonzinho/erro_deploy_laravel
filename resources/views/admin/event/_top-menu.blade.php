@if($event->state->id !== \App\Entities\Event::CANCELADO)
    <div class="row">
        <div class="col md-12">
            <div class="box">
                <div class="box-body">
                    @if($event->state_id < \App\Entities\Event::CONCULIDO && auth()->user()->can('edit event'))
                    <a class="btn btn-app" href="{{ route('admin.events.edit', [$event->id, \App\Entities\Admin::ROLE]) }}">
                        <i class="fa fa-edit"></i> Editar
                    </a>
                    @endif
                    <a class="btn btn-app" href="{{route('admin.events.spaces', [$event->id])}}">
                        <i class="fa fa-calendar"></i> Espaços
                    </a>

                    <a class="btn btn-app" href="{{route('admin.events.tasks', [$event->id])}}">
                        <i class="fa fa-users"></i> Turnos
                    </a>
                        @if($event->doc_program !== null)
                            <a class="btn btn-app" href="{{asset('storage/'.\App\Entities\Event::programDir().$event->doc_program)}}" target="_blank">
                                <i class="fa fa-file"></i> Programa
                            </a>
                        @endif
                        @if($event->state_id == \App\Entities\Event::CONCULIDO || $event->state_id == \App\Entities\Event::ARQUIVADO)

                            @if(auth()->user()->can('edit schedule balance') || auth()->user()->can('edit technic balance'))
                            <a class="btn btn-app" href="{{ route('admin.events.balance.expenses', [$event->id]) }}">
                                <i class="fa fa-edit"></i> Despesas
                            </a>
                            <a class="btn btn-app" href="{{ route('admin.events.balance.recipes', [$event->id]) }}">
                                <i class="fa fa-edit"></i> Receitas
                            </a>
                            @endif

                            @if(!$event->close_internal_tech_balance)
                                <a class="btn btn-app" href="{{ route('admin.events.balance.close-internal-tech-balance', [$event->id]) }}">
                                    <i class="fa fa-close"></i> Bal. Técnico
                                </a>
                            @else
                                <a class="btn disabled btn-app" href="#">
                                    <i class="fa fa-close"></i> Bal. Técnico Fechado
                                </a>
                            @endif

                            @if(!$event->close_internal_sche_balance)
                                <a class="btn btn-app" href="{{ route('admin.events.balance.close-internal-sche-balance', [$event->id]) }}">
                                    <i class="fa fa-close"></i> Bal. Agenda
                                </a>
                            @else
                                <a class="btn disabled btn-app" href="#">
                                    <i class="fa fa-close"></i> Bal. Agenda Fechado
                                </a>
                            @endif

                            @if($event->close_internal_sche_balance && $event->close_internal_tech_balance)
                                    <span id="btnClientNotify">
                                        @if(!$event->balance_notify_client && !$event->balance_notify_client)
                                            <a class="btn btn-app"  href="{{route('admin.events.balance.notify-client', [$event->id])}}" id="btnCloseScheduleBalance">
                                                <i class="fa fa-euro"></i> Notificar Cliente Val. final
                                            </a>
                                        @elseif($event->balance_notify_client && !$event->balance_acepted_client)
                                            <a class="btn btn-app" href="{{route('admin.events.balance.notify-client', [$event->id])}}" id="btnCloseScheduleBalance">
                                                <i class="fa fa-euro"></i> Reenviar Notificação
                                            </a>
                                        @else
                                            <a class="btn btn-app disabled" href="#" id="btnCloseScheduleBalance">
                                                <i class="fa fa-euro"></i> Cliente Notificado e balanço aceite
                                            </a>
                                        @endif
                                    </span>
                            @endif

                        @endif
                </div>
            </div>
        </div>
    </div>
@endif
