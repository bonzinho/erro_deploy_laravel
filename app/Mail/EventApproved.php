<?php

namespace App\Mail;

use App\Entities\Client;
use App\Entities\Event;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class EventApproved extends Mailable
{
    use Queueable, SerializesModels;
    /**
     * @var Client
     */
    private $client;
    /**
     * @var Event
     */
    private $event;

    /**
     * Create a new message instance.
     *
     * @param Client $client
     * @param Event $event
     */
    public function __construct(Event $event, Client $client)
    {
        $this->client = $client;
        $this->event = $event;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $event = $this->event;
        $client = $this->client;
        $url = url('/');
        return $this->from(env('EMAIL_FROM'))
            ->subject('Evento Aprovado')
            ->markdown('emails.events.event-approved')
            ->with('url', $url)
            ->with('event', $event)
            ->with('client', $client);
    }
}
