@component('mail::message')
# O Evento {{$event->denomination }} foi aprovado.
Olá {{$client->ac_name}}<br/>
A sua proposta para o evento {{$event->denomination}} foi aprovada.

Caso não tenha submetido este evento na plataforma, por favor  entre em contacto com o centro de eventos.

@component('mail::button', ['url' => $url])
Plataforma Centro de Eventos
@endcomponent

Obrigado,<br>
{{ config('app.name') }}
@endcomponent