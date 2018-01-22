<?php

namespace App\Listeners;

use App\Events\PaymentEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;
use Mockery\Exception;

class SendEmailToCollaboratorWithPayment
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
     * @param  PaymentEvent  $event
     * @return void
     */
    public function handle(PaymentEvent $event)
    {
        $financial = $event->getFinancial();
        $collab = $event->getCollaborator();
        try{
            Mail::to($collab->email)->send(New \App\Mail\SendEmailToCollaboratorWithPayment($financial));
        }catch (Exception $e){
            $e->getMessage();
        }

    }
}
