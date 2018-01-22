<?php

namespace App\Events;

use App\Entities\Task;
use App\Repositories\TaskRepository;
use App\Repositories\TaskRepositoryEloquent;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class AfterAddNewTaskEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    /**
     * @var Task
     */
    private $task;


    /**
     * Create a new event instance.
     *
     * @param Task $task
     * @internal param TaskRepository $repository
     */
    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    /**
     * @return Task
     */
    public function getTask()
    {
        return $this->task;
    }



    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
