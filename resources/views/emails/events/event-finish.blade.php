@component('mail::message')
# O Evento {{$event->denomination }} foi concluído.
Olá {{$client->ac_name}}<br/>
O seu evento, {{$event->denomination}}, foi conluído.
Em breve receberá um email com um descritivo dos valores a serem cobrados, ainda nesse email poderá confirmar o valor final ou contactar o centro de eventos para que  seja rectificado.

Caso não tenha submetido este evento na plataforma, por favor  entre em contacto com o centro de eventos.

@component('mail::button', ['url' => $url])
Plataforma Centro de Eventos
@endcomponent

Obrigado,<br>
{{ config('app.name') }}
@endcomponent