<?php

namespace App\Mail;

use App\Entities\Event;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendEmailToCollaboratorsAfterEventCompleted extends Mailable
{
    use Queueable, SerializesModels;
    /**
     * @var Event
     */
    public $event;

    /**
     * Create a new message instance.
     *
     * @param Event $event
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
        $event = $this->event;
        $url = url('/');
        return $this->from(env('EMAIL_FROM'))
            ->subject('Confirmar horários de evento concluído')
            ->markdown('admin.event.tasks.mail.event-completed')
            ->with('event', $event)
            ->with('url', $url);
    }
}
