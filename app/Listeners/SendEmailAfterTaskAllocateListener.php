<?php

namespace App\Listeners;

use App\Events\AfterTaskAllocateEvent;
use App\Mail\SendEmailWithAfterTaskAllocated;
use App\Repositories\TaskRepository;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;
use Mockery\Exception;

class SendEmailAfterTaskAllocateListener
{
    /**
     * @var TaskRepository
     */
    private $taskRepository;

    /**
     * Create the event listener.
     *
     * @param TaskRepository $taskRepository
     */
    public function __construct(TaskRepository $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    /**
     * Handle the event.
     *
     * @param  AfterTaskAllocateEvent  $event
     * @return void
     */
    public function handle(AfterTaskAllocateEvent $event)
    {
        $collaborator = $event->getCollaborator();
        $task = $this->taskRepository->find($collaborator->pivot->task_id);
        try{
            Mail::to($collaborator->email)->send(new SendEmailWithAfterTaskAllocated($task));
        }catch (Exception $e){
            $e->getMessage();
        }
    }
}
