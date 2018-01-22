<?php

namespace App\Mail;

use App\Entities\Client;
use App\Entities\Event;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class EventFinish extends Mailable
{
    use Queueable, SerializesModels;
    /**
     * @var Event
     */
    private $event;
    /**
     * @var Client
     */
    private $client;

    /**
     * Create a new message instance.
     *
     * @param Event $event
     * @param Client $client
     */
    public function __construct(Event $event, Client $client)
    {
        //
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
        $event = $this->event;
        $client = $this->client;
        $url = url('/');
        return $this->from(env('EMAIL_FROM'))
            ->subject('Evento Concluído')
            ->markdown('emails.events.event-finish')
            ->with('url', $url)
            ->with('event', $event)
            ->with('client', $client);
    }
}
