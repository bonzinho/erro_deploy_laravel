<?php

namespace App\Events;

use App\Entities\Collaborator;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class AfterTaskAllocateEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    /**
     * @var Collaborator
     */
    private $collaborator;

    /**
     * Create a new event instance.
     *
     * @param Collaborator $collaborator
     */
    public function __construct(Collaborator $collaborator)
    {

        $this->collaborator = $collaborator;
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

    /**
     * @return Collaborator
     */
    public function getCollaborator()
    {
        return $this->collaborator;
    }
}
