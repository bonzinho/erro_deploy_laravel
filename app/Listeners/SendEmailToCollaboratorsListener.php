<?php

namespace App\Listeners;

use App\Entities\Dynamicmail;
use App\Events\SendDynamicEmailEvent;
use App\Mail\SendDynamicEmail;
use App\Repositories\CollaboratorRepository;
use Faker\Provider\File;
use Illuminate\Support\Facades\Mail;
use Mockery\Exception;

class SendEmailToCollaboratorsListener
{
    /**
     * @var CollaboratorRepository
     */
    private $repository;

    /**
     * Create the event listener.
     *
     * @param CollaboratorRepository $repository
     */
    public function __construct(CollaboratorRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Handle the event.
     *
     * @param  SendDynamicEmailEvent  $event
     * @return void
     */
    public function handle(SendDynamicEmailEvent $event)
    {
        $attributes = $event->getAttributes();
        if($attributes['type'] == 3){
            $collaborators = $this->repository->findWhere(['state' => 1])->pluck('email');
        }else{
            $collaborators = $this->repository->findWhere(['type' => $attributes['type'], 'state' => 1])->pluck('email');
        }

        //upload anexo se existir
        if(isset($attributes['attachment'])){
            $name =  md5('anexo-'.time()). '.' . $attributes['attachment']->guessExtension();
            $destFile = Dynamicmail::attatchDir();
            $result = \Storage::disk('public')->putFileAs($destFile, $attributes['attachment'], $name);
        }else{
            $result = null;
        }
        try{
            if(Mail::to($collaborators)->send(new SendDynamicEmail($attributes['message'], $attributes['subject'], $result))){
                File::delete(asset('storage/'.$attributes['attachment']));
            }
        }catch (Exception $e){
            $e->getMessage();
        }
    }
}
