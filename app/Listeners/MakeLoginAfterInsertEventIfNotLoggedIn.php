<?php

namespace App\Listeners;

use App\Events\AddEventAndRegisterAccountEvent;
use Illuminate\Support\Facades\Auth;

class MakeLoginAfterInsertEventIfNotLoggedIn
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
     * @param  AddEventAndRegisterAccountEvent  $event
     * @return void
     */
    public function handle(AddEventAndRegisterAccountEvent $event)
    {
        //$client = $event->getClient();
        //Auth::guard('client')->login($client);
    }
}
