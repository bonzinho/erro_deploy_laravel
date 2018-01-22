@component('mail::message')

@component('mail::panel')
#### {{$subject}}
@endcomponent

{{$message}}

@component('mail::button', ['url' => $url])
Plataforma Centro de Eventos
@endcomponent

Obrigado<br/>
{{ config('app.name') }}
@endcomponent
