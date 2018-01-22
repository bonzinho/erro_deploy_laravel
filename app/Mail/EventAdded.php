<?php

namespace App\Mail;

use App\Entities\Client;
use App\Entities\Event;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class EventAdded extends Mailable
{
    use Queueable, SerializesModels;
    /**
     * @var Event
     */
    public $event;
    /**
     * @var Client
     */
    public $client;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Event $event, Client $client)
    {
        $this->event = $event;
        $this->client = $client;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $url = url('/');
        return $this->markdown('emails.events.added')
            ->with('url', $url);
    }
}
