<?php

namespace App\Listeners;

use App\Events\AfterAddNewTaskEvent;
use App\Mail\NotifyCollaboratorAboutNewTask;
use App\Repositories\CollaboratorRepository;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;
use Mockery\Exception;

class NotifyCollaboratorsAboutTaskListener
{
    /**
     * @var CollaboratorRepository
     */
    private $collaboratorRepository;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(CollaboratorRepository $collaboratorRepository)
    {
        $this->collaboratorRepository = $collaboratorRepository;
    }

    /**
     * Handle the event.
     *
     * @param  AfterAddNewTaskEvent  $event
     * @return void
     */
    public function handle(AfterAddNewTaskEvent $event)
    {
        $task = $event->getTask();
        $collaborators = $this->collaboratorRepository->findWhere(['state' => 1])->pluck('email')->toArray();
        try{
            Mail::to($collaborators)->send(New NotifyCollaboratorAboutNewTask($task));
        }catch (Exception $e){
            $e->getMessage();
        }

    }
}
