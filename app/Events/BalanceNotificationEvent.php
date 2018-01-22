<?php

namespace App\Events;

use App\Entities\Event;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class BalanceNotificationEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var Event
     */
    private $event;
    private $recipes_total;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Event $event, $recipes_total)
    {
        $this->event = $event;
        $this->recipes_total = $recipes_total;
    }

    /**
     * @return mixed
     */
    public function getRecipesTotal()
    {
        return $this->recipes_total;
    }

    /**
     * @return mixed
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
