<?php

namespace App\Listeners;

use App\Entities\Collaborator;

class UploadPhotoListener
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
        //
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
        $photo = $event->getPhoto();
        $collaborator = $event->getRepository();


        if($photo){
            $name = $collaborator->created_at != $collaborator->updated_at ? $collaborator->photo : md5(time().$photo->getClientOriginalName())
                . '.' . $photo->guessExtension();
            $destFile = Collaborator::photoDir();

            $result = \Storage::disk('public')->putFileAs($destFile, $photo, $name);

            if($collaborator->created_at == $collaborator->updated_at){
                if($result){
                    $collaborator['photo'] = $name;
                    $collaborator->update($collaborator->toArray());
                }
            }
        }
    }
}
