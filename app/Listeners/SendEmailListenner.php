<?php

namespace App\Listeners;

use App\Events\AfterClientAddEventEvent;
use App\Mail\EventAdded;
use App\Mail\InsertEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;
use Mockery\Exception;

class SendEmailListenner
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
     * @param  AfterClientAddEventEvent  $event
     * @return void
     */
    public function handle(AfterClientAddEventEvent $event)
    {
        $client = $event->getClient();
        $evento = $event->getEvent();
        try{
            Mail::to($client->email)->send(New EventAdded($evento, $client));
        }catch (Exception $e){
             $e->getMessage();
        }
    }
}
