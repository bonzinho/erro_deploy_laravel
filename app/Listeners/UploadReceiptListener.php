<?php

namespace App\Listeners;

use App\Entities\Financial;
use App\Events\PaymentEvent;
use Carbon\Carbon;

class UploadReceiptListener
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
        $file = $event->getReceipt();
        $collaborator = $event->getCollaborator();
        $financial = $event->getFinancial();
        $today = Carbon::now()->format('d-m-Y');
        if($file){
            $name = trim($collaborator->name).'-'.$today.'.'.$file->guessExtension();
            $destFile = Financial::receiptDir();
            $result = \Storage::disk('public')->putFileAs($destFile, $file, $name);
            if($financial->created_at == $financial->updated_at){
                if($result){
                    $financial['receipt'] = $name;
                    $financial->update($financial->toArray());
                }
            }
        }
    }
}
