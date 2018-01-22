<?php

namespace App\Listeners;

use App\Entities\Client;
use App\Events\AddEventAndRegisterAccountEvent;
use App\Mail\NewRegister;
use App\Repositories\ClientRepository;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;
use Mockery\Exception;

class SendEmailWithNewRegister
{
    /**
     * @var ClientRepository
     */
    private $repository;

    /**
     * Create the event listener.
     *
     * @param ClientRepository $repository
     */
    public function __construct(Client $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Handle the event.
     *
     * @param  AddEventAndRegisterAccountEvent  $event
     * @return void
     */
    public function handle(AddEventAndRegisterAccountEvent $event)
    {
        $client = $event->getClient();
        try{
            Mail::to($client->email)->send(new NewRegister($client));
        }catch (Exception $e){
            $e->getMessage();
        }
    }
}
