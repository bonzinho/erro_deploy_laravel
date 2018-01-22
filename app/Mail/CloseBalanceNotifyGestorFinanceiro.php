<?php

namespace App\Mail;

use App\Entities\Event;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CloseBalanceNotifyGestorFinanceiro extends Mailable
{
    use Queueable, SerializesModels;
    /**
     * @var Event
     */
    private $event;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Event $event)
    {
        $this->event = $event;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $link_to_event = url('admin/events/'.$this->event->id.'/show/admin');
        $event = $this->event;
        return $this->from('eventos@fe.up.pt')
            ->subject('Balancete interno do evento ' . $event->denomination . ' fechado')
            ->markdown('emails.events.close_internal_balance')
            ->with('event', $event)
            ->with('link_to_event', $link_to_event);
    }
}
