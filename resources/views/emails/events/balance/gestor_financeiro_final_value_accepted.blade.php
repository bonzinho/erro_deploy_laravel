@component('mail::message')

@component('mail::panel')
#Valor aceite pelo cliente
@endcomponent

Olá, Isto é um email automático.<br/>
O cliente **{{$event->client->name}}** aceitou o valor final enviado para o evento **{{$event->denomination}}**<br/>
O evento pode agora ser Arquivado com sucesso.

@component('mail::button', ['url' => $url])
Plataforma Centro de eventos
@endcomponent

Obrigado<br/>
{{ config('app.name') }}
@endcomponent
