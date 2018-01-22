@component('mail::message')

@component('mail::panel')
#### Balanço interno foi fechado.
@endcomponent

Olá, Isto é um email automático para te avisar que existe um novo evento com o balanço interno fechado, podes, por isso, acabar de preencher os dados necessários e enviar o valor final para o cliente para paraaprovação.
Depois do cliente aprovar receberá um email automático e já será possivel arquivar o evento.

@component('mail::button', ['url' => $link_to_event])
Ver evento
@endcomponent

Obrigado<br/>
{{ config('app.name') }}
@endcomponent
