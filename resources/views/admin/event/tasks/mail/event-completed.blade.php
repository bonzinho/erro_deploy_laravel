@component('mail::message')
# O evento {{$event->denomination}} (#{{$event->id}}) foi concluído.
Olá,
O Evento {{$event->denomination}} foi concluido.
Por favor caso não tenhas feito o horário definido nas tarefas em que foste alocado(a), responde a este email com as alterações que foram feitas.
Caso não respondas no prazo de 5 dias os horários pré definidos serão dados como corretos.

##Dados da Evento:

**ID:** #{{$event->id}}

**Nome:** {{$event->denomination}}

**Dia(s):** {{\Carbon\Carbon::parse($event->init)->format('Y-m-d')}} a {{\Carbon\Carbon::parse($event->end)->format('Y-m-d')}}

@component('mail::button', ['url' => $url])
    Plataforma Centro de Eventos
@endcomponent

Obrigado,
{{ config('app.name') }}
@endcomponent