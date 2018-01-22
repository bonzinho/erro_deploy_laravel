@component('mail::message')
#Foste alocado(a) para uma tarefa (#{{$task->event->id}})) no evento  ({{$task->event->denomination}}
Olá,
Foste alocado(a) para a tarefa {{$task->description}}
Por favor acede à plataforma do centro de eventos e confirma a tua alocação para o evento que vai decorrer entre os dias {{\Carbon\Carbon::parse($task->event->date_time_init)->format('d-m-Y')}} e {{\Carbon\Carbon::parse($task->event->date_time_end)->format('d-m-Y')}} .

##**Dados da tarefa:**

**Descrição:** {{$task->description}}

**Dia:** {{$task->date}} das {{$task->init}} às {{$task->end}}

**Notas:** {{$task->note}}

@component('mail::button', ['url' => $url])
    Plataforma Centro de Eventos
@endcomponent

Obrigado,
{{ config('app.name') }}
@endcomponent