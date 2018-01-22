@component('mail::message')
# Novo pedido de disponiblidade para evento ({{$task->event->denomination}})
Olá,
Tens um novo pedido de disponibilidade ativo.
Por favor acede à plataforma do centro de enventos e responde à tua disponibilidade para o evento (#{{$task->event->id}}) que vai decorrer entre os dias {{\Carbon\Carbon::parse($task->event->date_time_init)->format('d-m-Y')}} e {{\Carbon\Carbon::parse($task->event->date_time_end)->format('d-m-Y')}} .

**Dados da tarefa:**

Descrição: {{$task->description}}

**Dia:** {{$task->date}} das {{$task->init}} às {{$task->end}}

**Notas:** {{$task->note}}

@component('mail::button', ['url' => $url])
Plataforma Centro de Eventos
@endcomponent


Obrigado,

{{ config('app.name') }}
@endcomponent