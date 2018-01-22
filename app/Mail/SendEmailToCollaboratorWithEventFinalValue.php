<?php

namespace App\Mail;

use App\Entities\Collaborator;
use App\Entities\Event;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Collection;

class SendEmailToCollaboratorWithEventFinalValue extends Mailable
{
    use Queueable, SerializesModels;
    /**
     * @var Collection
     */
    private $tasks;
    /**
     * @var Event
     */
    private $event;
    /**
     * @var Collaborator
     */
    private $collaborator;

    /**
     * Create a new message instance.
     *
     * @param Collection $tasks
     * @param Event $event
     * @param Collaborator $collaborator
     */
    public function __construct(Collection $tasks, Event $event, Collaborator $collaborator)
    {
        $this->tasks = $tasks;
        $this->event = $event;
        $this->collaborator = $collaborator;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $total = 0;
        $event = $this->event;
        $tasks = $this->tasks;
        $collab = $this->collaborator;
        $url = url('/');

        foreach ($tasks as $task){
            $total += ($task->pivot->normal_hour_value_total + $task->pivot->extra_hour_value_total);
        }

        return $this->from(env('EMAIL_FROM'))
            ->subject('Confirmar horários de evento concluído')
            ->markdown('emails.events.tasks.collaborators.event_final_value')
            ->with('event', $event)
            ->with('tasks', $tasks)
            ->with('collab', $collab)
            ->with('total', $total)
            ->with('url', $url);
    }
}
