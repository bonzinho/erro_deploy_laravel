<?php

namespace App\Events;

use App\Entities\Event;
use App\Repositories\EventRepository;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class AfterChangeEventStatusToConcluido
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    /**
     * @var EventRepository
     */
    private $eventRepository;

    /**
     * Create a new event instance.
     *
     * @param EventRepository $eventRepository
     */
    public function __construct(Event $eventRepository)
    {
        $this->eventRepository = $eventRepository;
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
     * @return EventRepository
     */
    public function getEventRepository()
    {
        return $this->eventRepository;
    }
}
