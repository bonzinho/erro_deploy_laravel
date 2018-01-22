<?php

namespace App\Listeners;

use App\Events\AfterChangeEventStatusToConcluido;
use App\Mail\SendEmailToCollaboratorsAfterEventCompleted;
use App\Repositories\TaskRepository;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;
use Mockery\Exception;

class SendEmailToCollaboratorsToSchudlerCorrection
{
    /**
     * @var TaskRepository
     */
    private $taskRepository;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(TaskRepository $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    /**
     * Handle the event.
     *
     * @param  AfterChangeEventStatusToConcluido  $event
     * @return void
     */
    public function handle(AfterChangeEventStatusToConcluido $event)
    {
        $evento = $event->getEventRepository();
        $eventTasks = $evento->tasks;
        $emails = [];
        foreach ($eventTasks as $task){
            foreach ($task->collaborators()->wherePivot('allocation', 1)->wherePivot('accepted', 1)->wherePivot('confirm_allocation', 1)->get() as $collaborator){
                if (!in_array($collaborator->email, $emails)) {
                    array_push($emails, $collaborator->email);
                }
            }
        }
        try{
            Mail::to($emails)->send(New SendEmailToCollaboratorsAfterEventCompleted($evento));
        }catch (Exception $e){
            $e->getMessage();
        }
    }


}
