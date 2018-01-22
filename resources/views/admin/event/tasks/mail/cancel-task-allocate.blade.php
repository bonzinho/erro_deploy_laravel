@component('mail::message')
# A tua alocação para a tarefa com id #{{$task->id}} do evento {{$task->event->denomination}} #{{$task->event->id}} foi cancelada

**Dados da tarefa:**

**Descrição:** {{$task->description}}

**Dia:** {{$task->date}} das {{$task->init}} às {{$task->end}}

**Notas:** {{$task->note}}

@component('mail::button', ['url' => $url])
Plataforma Centro de Eventos
@endcomponent

Obrigado,
{{ config('app.name') }}
@endcomponent