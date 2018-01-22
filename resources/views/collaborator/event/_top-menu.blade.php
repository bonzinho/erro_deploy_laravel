@if($event->state->id !== \App\Entities\Event::PENDENTE && $event->state->id !== \App\Entities\Event::CANCELADO)
    <div class="row">
        <div class="col md-12">
            <div class="box">
                <div class="box-body">
                    <a class="btn btn-app" href="{{route('collaborator.events.spaces', [$event->id])}}">
                        <i class="fa fa-calendar"></i> Espaços
                    </a>
                    <a class="btn btn-app" href="{{route('collaborator.events.tasks', [$event->id])}}">
                        <i class="fa fa-users"></i> Disponibilidades
                    </a>
                </div>
            </div>
        </div>
    </div>
@endif