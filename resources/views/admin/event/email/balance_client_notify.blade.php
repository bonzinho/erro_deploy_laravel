@component('mail::message')




    @component('mail::table')
        | Descrição     | Preço         | Grupo    | CCO/Fatura   |
        | ------------- |:-------------:|:--------:|-------------:|
        @foreach($event['recipes'] as $recipe)
        | {{$recipe['description']}} | {{$recipe['value']}} € | @if($recipe['group'] == 0) Gestão técnica @else Gestão de Agenda @endif |  {{$recipe['cco']}} |
        @endforeach
    @endcomponent


    @component('mail::button', ['url' => 'http://www.sapo.pt'])
        Confirmar Valor
    @endcomponent


    Por favor caso esteja correto responda a este email, caso exista algum erro poderá entrar em contacto como centro de eventos.
    Obrigado

    {{ config('app.name') }}
@endcomponent