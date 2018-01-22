<h1>{{$data['title']}} ({{$event->state->name}})
    @if(Auth::guard('admin')->check() && $event->state_id !== \App\Entities\Event::CANCELADO
        && $event->state_id !== \App\Entities\Event::ARQUIVADO
        && auth()->user()->can(['accept event', 'archive event', 'finish event', 'cancel event']))
    <div class="btn-group-vertical">
        <div class="btn-group">
            <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
                <span class="caret"></span>
            </button>
            <ul class="dropdown-menu">
                @if($event->state_id == \App\Entities\Event::PENDENTE && auth()->user()->can(['accept event', 'cancel event']))
                    <li><a href="{{route('admin.events.change_status', [$event->id, \App\Entities\Event::PROCESSADO])}}">Processar Evento</a></li>
                    <li><a href="{{route('admin.events.change_status', [$event->id, \App\Entities\Event::CANCELADO])}}">Cancelar Evento</a></li>
                @elseif($event->state_id == \App\Entities\Event::PROCESSADO && auth()->user()->can(['cancel event', 'finish event']))
                    <li><a href="{{route('admin.events.change_status', [$event->id, \App\Entities\Event::CONCULIDO])}}">Concluir Evento</a></li>
                    <li><a href="{{route('admin.events.change_status', [$event->id, \App\Entities\Event::CANCELADO])}}">Cancelar Evento</a></li>
                @elseif($event->state_id == \App\Entities\Event::CONCULIDO && auth()->user()->can(['finish event']))
                    <li><a href="{{route('admin.events.change_status', [$event->id, \App\Entities\Event::ARQUIVADO])}}">Arquivar Evento</a></li>
                @endif
            </ul>
        </div>
    </div>
    @endif
</h1>