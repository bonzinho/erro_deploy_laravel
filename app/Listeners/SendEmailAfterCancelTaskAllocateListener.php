<?php

namespace App\Listeners;

use App\Entities\Task;
use App\Events\AfterCancelTaskAllocateEvent;
use App\Mail\SendEmailAfterCancelTaskAllocate;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;
use Mockery\Exception;

class SendEmailAfterCancelTaskAllocateListener
{
    /**
     * @var Task
     */
    private $task;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    /**
     * Handle the event.
     *
     * @param  AfterCancelTaskAllocateEvent  $event
     * @return void
     */
    public function handle(AfterCancelTaskAllocateEvent $event)
    {
        $collaborator = $event->getCollaborator();
        $task = $this->task->find($collaborator->pivot->task_id);
        try{
            Mail::to($collaborator->email)->send(new SendEmailAfterCancelTaskAllocate($task));
        }catch (Exception $e){
            $e->getMessage();
        }
    }
}
