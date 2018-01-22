<?php

namespace App\Listeners;

use App\Events\AfterValidateAllSchedules;
use App\Mail\SendEmailToCollaboratorWithEventFinalValue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class SendEmailWithTasksTotalValuesLstener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  AfterValidateAllSchedules  $event
     * @return void
     */
    public function handle(AfterValidateAllSchedules $event)
    {
        $collaborators = $event->getCollaborator();
        $_event = $event->getEvent();
        foreach ($collaborators as $collab){
            // 1 - obeter todas as tarefas do evento x para enviar por email
            $tasks = $collab->tasks()->where(['event_id' => $_event->id])
                ->wherePivot('accepted', 1)
                ->wherePivot('confirm_allocation', 1)
                ->wherePivot('payment', 0)
                ->get();
            Mail::to($collab->email)->send(New SendEmailToCollaboratorWithEventFinalValue($tasks, $_event, $collab));

        }
    }
}
