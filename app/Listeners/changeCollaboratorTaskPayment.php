<?php

namespace App\Listeners;

use App\Events\PaymentEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Mockery\Exception;

class changeCollaboratorTaskPayment
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
        $collab = $event->getCollaborator();
        $tasks = $event->getTask();
        foreach ($tasks as $c){
            $total = 0;
            $horasExtras = 0;
            $horasNormais = 0;
            $pay = 0;
            $tasks = $c->tasks()->where('collaborator_id', $collab->id)->wherePivot('allocation', 1)
                ->wherePivot('accepted', 1)
                ->wherePivot('confirm_allocation', 1)
                ->wherePivot('payment', 0)
                ->get();
            for($y = 0; $y < count($tasks); $y++){
                try{
                    $tasks[$y]->pivot->payment = 1;
                    $tasks[$y]->pivot->save($tasks[$y]->toArray());
                }catch (Exception $e){
                    $e->getMessage();
                }

            }
        }
    }
}
