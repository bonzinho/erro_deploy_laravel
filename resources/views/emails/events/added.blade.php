@component('mail::message')
# Novo Evento adicionado com sucesso
Olá {{$client->ac_name}}<br/>
A sua proposta para o evento {{$event->denomination}} foi inserida com sucesso.
Se o evento for aprovado receberá uma confirmação por email, caso contrário será contactado(a) pela equipa do centro de eventos da FEUP.

Caso não submetido nenhuma proposta na plataforma, por favor  entre em contacto com o centro de eventos.

@component('mail::button', ['url' => $url])
    Plataforma Centro de Eventos
@endcomponent

Obrigado,<br>
{{ config('app.name') }}
@endcomponent
