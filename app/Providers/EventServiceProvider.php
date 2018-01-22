<?php

namespace App\Providers;

use App\Events\AddEventAndRegisterAccountEvent;
use App\Events\AddNewTaskEvent;
use App\Events\AfterAddNewTaskEvent;
use App\Events\AfterCancelTaskAllocateEvent;
use App\Events\AfterChangeEventStatusToArquivado;
use App\Events\AfterChangeEventStatusToCancelado;
use App\Events\AfterChangeEventStatusToConcluido;
use App\Events\AfterChangeEventStatusToProcessado;
use App\Events\AfterClientAddEventEvent;
use App\Events\AfterCollaboratorSignInEvent;
use App\Events\AfterTaskAllocateEvent;
use App\Events\AfterValidateAllSchedules;
use App\Events\BalanceNotificationEvent;
use App\Events\ChangeCollaboratorAllocatedEvent;
use App\Events\ClientAcceptFinalValueEvent;
use App\Events\InternalBalanceCloseEvent;
use App\Events\PaymentEvent;
use App\Events\SendDynamicEmailEvent;
use App\Events\SendEmailAfterChangeCollaboratorEvent;
use App\Events\UpdateReceiptEvent;
use App\Events\UploadEventProgramEvent;
use App\Listeners\changeCollaboratorTaskPayment;
use App\Listeners\MakeLoginAfterInsertEventIfNotLoggedIn;
use App\Listeners\NotifyCollaboratorsAboutTaskListener;
use App\Listeners\SendBalanceNotificationListener;
use App\Listeners\SendEmailAfterCancelTaskAllocateListener;
use App\Listeners\SendEmailAfterTaskAllocateListener;
use App\Listeners\SendEmailListenner;
use App\Listeners\SendEmailToCollaboratorsListener;
use App\Listeners\SendEmailToCollaboratorsToSchudlerCorrection;
use App\Listeners\SendEmailToCollaboratorWithNewTaskListenner;
use App\Listeners\SendEmailToCollaboratorWithPayment;
use App\Listeners\SendEmailToGestorFnanceiroListener;
use App\Listeners\SendEmailToNewCollaboratorChangedListener;
use App\Listeners\SendEmailWithNewRegister;
use App\Listeners\SendEmailWithTasksTotalValuesLstener;
use App\Listeners\SendNotificatioGestorFinanceiroFinalValueAccepted;
use App\Listeners\UpdateAndUploadReceiptListener;
use App\Listeners\UploadCvListener;
use App\Listeners\UploadFileListener;
use App\Listeners\UploadPhotoListener;
use App\Listeners\UploadReceiptListener;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        AfterCollaboratorSignInEvent::class => [
            UploadPhotoListener::class,
            UploadCvListener::class,
        ],
        AddEventAndRegisterAccountEvent::class => [
            MakeLoginAfterInsertEventIfNotLoggedIn::class,
            SendEmailWithNewRegister::class,
        ],
        AfterClientAddEventEvent::class => [
          SendEmailListenner::class,
        ],
        AfterAddNewTaskEvent::class => [
            NotifyCollaboratorsAboutTaskListener::class,
        ],
        AfterChangeEventStatusToProcessado::class => [

        ],
        AfterChangeEventStatusToConcluido::class => [
            SendEmailToCollaboratorsToSchudlerCorrection::class,
        ],
        AfterChangeEventStatusToArquivado::class => [

        ],
        AfterChangeEventStatusToCancelado::class => [

        ],
        AfterTaskAllocateEvent::class => [
            SendEmailAfterTaskAllocateListener::class,
        ],
        AfterCancelTaskAllocateEvent::class => [
            SendEmailAfterCancelTaskAllocateListener::class,
        ],
        SendDynamicEmailEvent::class => [
          SendEmailToCollaboratorsListener::class,
        ],
        PaymentEvent::class => [
            UploadReceiptListener::class,
            SendEmailToCollaboratorWithPayment::class,
            changeCollaboratorTaskPayment::class,
        ],
        UpdateReceiptEvent::class => [
            UpdateAndUploadReceiptListener::class,
        ],
        UploadEventProgramEvent::class => [
          UploadFileListener::class,
        ],
        ChangeCollaboratorAllocatedEvent::class => [
            SendEmailToNewCollaboratorChangedListener::class,
        ],
        BalanceNotificationEvent::class => [
          SendBalanceNotificationListener::class,
        ],
        InternalBalanceCloseEvent::class => [
            SendEmailToGestorFnanceiroListener::class,
        ],
        AfterValidateAllSchedules::class => [
            SendEmailWithTasksTotalValuesLstener::class
        ],
        ClientAcceptFinalValueEvent::class => [
            SendNotificatioGestorFinanceiroFinalValueAccepted::class
        ]

    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
        //
    }
}
