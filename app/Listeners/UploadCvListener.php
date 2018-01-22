<?php

namespace App\Listeners;

use App\Entities\Collaborator;

class UploadCvListener
{
    /**
     * @var Collaborator
     */
    private $collaborator;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(Collaborator $collaborator)
    {
        $this->collaborator = $collaborator;
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $cv = $event->getCv();
        $collaborator = $event->getRepository();

        if($cv){
            $name = $collaborator->created_at != $collaborator->updated_at ? $collaborator->cv : md5(time().$cv->getClientOriginalName())
                . '.' . $cv->guessExtension();
            $destFile = Collaborator::cvDir();

            $result = \Storage::disk('public')->putFileAs($destFile, $cv, $name);

            if($collaborator->created_at == $collaborator->updated_at){
                if($result){
                    $collaborator['cv'] = $name;
                    $collaborator->update($collaborator->toArray());
                }
            }
        }
    }
}
