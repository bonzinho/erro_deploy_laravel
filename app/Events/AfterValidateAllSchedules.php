<?php

namespace App\Events;

use App\Entities\Collaborator;
use App\Entities\Event;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Support\Collection;

class AfterValidateAllSchedules
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    /**
     * @var Collaborator
     */
    private $collaborator;
    /**
     * @var Event
     */
    private $event;


    /**
     * AfterValidateAllSchedules constructor.
     * @param Event $event
     * @param Collection $collaborator
     */
    public function __construct(Collection $collaborator, Event $event)
    {
        $this->collaborator = $collaborator;
        $this->event = $event;
    }

    /**
     * @return Collaborator
     */
    public function getCollaborator()
    {
        return $this->collaborator;
    }

    /**
     * @return Event
     */
    public function getEvent()
    {
        return $this->event;
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
