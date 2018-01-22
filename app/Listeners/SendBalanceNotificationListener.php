<?php

namespace App\Listeners;

use App\Entities\BalanceNotification;
use App\Events\BalanceNotificationEvent;
use App\Mail\SendBalanceNotificationToClient;
use App\Repositories\BalanceNotificationRepository;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;
use Mockery\Exception;

class SendBalanceNotificationListener
{
    /**
     * @var BalanceNotificationRepository
     */
    private $balanceNotificationRepository;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(BalanceNotificationRepository $balanceNotificationRepository)
    {
        $this->balanceNotificationRepository = $balanceNotificationRepository;
    }

    /**
     * Handle the event.
     *
     * @param  BalanceNotificationEvent  $event
     * @return void
     */
    public function handle(BalanceNotificationEvent $_event)
    {
        $event = $_event->getEvent();
        $recipes_total = $_event->getRecipesTotal();
        $insertToken = $this->balanceNotificationRepository->findWhere(['event_id' => $event->id])->first();
        if(!$insertToken){
            $token = BalanceNotification::createToken($event->id);
            $insert = [
                'event_id' => $event->id,
                'token' => $token,
            ];
            $insertToken = $this->balanceNotificationRepository->create($insert);
        }
        $token = base64_encode($insertToken->token);
        Mail::to($event->client->email)->send(new SendBalanceNotificationToClient($event, $recipes_total ,$token));
    }
}
