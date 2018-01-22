<?php

namespace App\Listeners;

use App\Events\ClientAcceptFinalValueEvent;
use App\Mail\SendEmailToGestorFinanceiroFinalValueAccepted;
use App\Repositories\AdminRepository;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class SendNotificatioGestorFinanceiroFinalValueAccepted
{
    /**
     * @var AdminRepository
     */
    private $adminRepository;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(AdminRepository $adminRepository)
    {
        //
        $this->adminRepository = $adminRepository;
    }

    /**
     * Handle the event.
     *
     * @param  ClientAcceptFinalValueEvent  $event
     * @return void
     */
    public function handle(ClientAcceptFinalValueEvent $event)
    {
        $_event = $event->getEvent();
        $emails_gestor_financeiro = $this->adminRepository->whereHas('roles', function($q){
            $q->where('name', '=' , 'gestor_financeiro');
        })->get()->pluck('email')->toArray();
        Mail::to($emails_gestor_financeiro)->send(New SendEmailToGestorFinanceiroFinalValueAccepted($_event));


    }
}
