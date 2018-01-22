<?php

namespace App\Listeners;
use App\Events\InternalBalanceCloseEvent;
use App\Repositories\AdminRepository;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;
use Mockery\Exception;

class SendEmailToGestorFnanceiroListener
{
    /**
     * @var AdminRepository
     */
    private $adminRepository;

    /**
     * Create the event listener.
     *
     * @param AdminRepository $adminRepository
     */
    public function __construct(AdminRepository $adminRepository)
    {
        $this->adminRepository = $adminRepository;
    }

    /**
     * Handle the event.
     *
     * @param  InternalBalanceCloseEvent  $event
     * @return void
     */
    public function handle(InternalBalanceCloseEvent $event)
    {
        $_event = $event->getEvent();
        $emails_gestor_financeiro = $this->adminRepository->whereHas('roles', function($q){
            $q->where('name', '=' , 'gestor_financeiro');
        })->get()->pluck('email')->toArray();
        try{
            Mail::to($emails_gestor_financeiro)->send(New \App\Mail\CloseBalanceNotifyGestorFinanceiro($_event));
        }catch (Exception $e){
            $e->getMessage();
        }
    }
}
