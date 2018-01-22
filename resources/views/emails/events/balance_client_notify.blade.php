@component('mail::message')

@component('mail::panel')
#### Por favor confirme os valores finais do evento {{$event['denomination']}}
@endcomponent

@component('mail::table')
| Descrição     | Preço         | Grupo    | CCO/Fatura   |
| ------------- |:-------------:|:--------:|-------------:|
@foreach($event['recipes'] as $recipe)
| {{$recipe['description']}} | {{$recipe['value']}} € | @if($recipe['group'] == 0) Gestão técnica @else Gestão de Agenda @endif |  {{$recipe['cco']}} |
@endforeach
@endcomponent

#Total: {{$recipes_total}} €

@component('mail::button', ['url' => $token])
Confirmar Valor
@endcomponent

Obrigado<br/>
{{ config('app.name') }}
@endcomponent
