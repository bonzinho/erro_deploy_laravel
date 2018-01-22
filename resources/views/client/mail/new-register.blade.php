@component('mail::message')
    Obrigado por se ter registado na Plataforma do centro de eventos da FEUP.
    Para poder aceder aos seus eventos submetidos faça login na <a href="{{route('client.login')}}" target="_blank">plataforma</a>

    Ao aceder à nossa plataforma poderá:

        - Ver histórico de eventos criados
        - Editar eventos (Brevemente)
        - Adicionar novos eventos

    Obrigado

    {{ config('app.name') }}
@endcomponent