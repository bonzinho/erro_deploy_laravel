<?php

namespace App\Listeners;

use App\Events\ChangeCollaboratorAllocatedEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendEmailToNewCollaboratorChangedListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ChangeCollaboratorAllocatedEvent  $event
     * @return void
     */
    public function handle(ChangeCollaboratorAllocatedEvent $event)
    {
        //
    }
}
