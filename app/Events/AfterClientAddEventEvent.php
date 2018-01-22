<?php

namespace App\Events;

use App\Entities\Client;
use App\Entities\Event;
use App\Repositories\ClientRepository;
use App\Repositories\EventRepository;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class AfterClientAddEventEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    /**
     * @var EventRepository
     */
    private $event;
    /**
     * @var ClientRepository
     */
    private $client;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Event $event, Client $client)
    {

        $this->event = $event;
        $this->client = $client;
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
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * @return ClientRepository
     */
    public function getClient()
    {
        return $this->client;
    }


}
