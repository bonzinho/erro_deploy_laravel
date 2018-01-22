@component('mail::message')
    # Novo pedido de disponiblidade para evento ({{$task->event->denomination}})
    Olá,
    Tens um novo pedido de disponibilidade ativo.
    Por favor acede à plataforma do centro de enventos e responde à tua disponibilidade para o evento que vai de correr entre os dias {{$task->event->date_time_init}} e {{$task->event->date_time_end}} .

    <strong>Dados da tarefa:</strong>
    Descrição: {{$task->description}}
    Dia: {{$task->date}}<br> das {{$task->init}} às {{$task->end}}
    Notas: {{$task->note}}


    Obrigado,
    {{ config('app.name') }}
@endcomponent