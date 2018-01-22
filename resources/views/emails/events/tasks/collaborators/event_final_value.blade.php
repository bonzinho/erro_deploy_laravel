@component('mail::message')
# Horários fechados e validados
Olá {{$collab->name}}

Os horários das tarefas do evento {{$event->denomination}}, foram fechadas e validadas, segue de seguida os valores que tens a receber deste evento.

| Descrição | Data & Horário | H. Extras | Total |
| --- | --- | --- | --- |
@foreach($tasks as $task)
| {{$task->description}} | {{$task->date}} - {{\Carbon\Carbon::parse($task->init)->format('h:i')}} - {{\Carbon\Carbon::parse($task->end)->format('h:i')}} | {{$task->pivot->total_extra_hour}}| {{$task->pivot->normal_hour_value_total + $task->pivot->extra_hour_value_total}} € |
@endforeach

#**Total:** {{$total}} €

Caso notes alguma falha nos valores / horarios por favor contacta o Centro de Eventos

@component('mail::button', ['url' => $url])
Plataforma Centro de Eventos
@endcomponent

Obrigado,<br>
{{ config('app.name') }}
@endcomponent