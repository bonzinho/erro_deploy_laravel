<?php

namespace App\Mail;

use App\Entities\Event;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendBalanceNotificationToClient extends Mailable
{
    use Queueable, SerializesModels;
    /**
     * @var Event
     */
    private $event;
    /**
     * @var
     */
    private $token;
    /**
     * @var
     */
    private $recipes_total;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Event $event, $recipes_total ,$token)
    {
        $this->event = $event;
        $this->token = $token;
        $this->recipes_total = $recipes_total;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $event = $this->event->toArray();
        $token = url('/event/balance_notify/') . '/' . $this->token;
        $recipes_total = $this->recipes_total;
        return $this->from('eventos@fe.up.pt')
            ->subject('Envio dos valores finais do evento ' . $event['denomination'])
            ->markdown('emails.events.balance_client_notify')
            ->with('event', $event)
            ->with('recipes_total', $recipes_total)
            ->with('token', $token);
    }
}