<?php

namespace App\Listeners;

use App\Entities\Event;
use App\Events\UploadEventProgramEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UploadFileListener
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
     * @param  UploadEventProgramEvent  $event
     * @return void
     */
    public function handle(UploadEventProgramEvent $event)
    {
        $file = $event->getFile();
        $name = $event->getName();

        if($file){
            $destFile = Event::programDir();
            $result = \Storage::disk('public')->putFileAs($destFile, $file, $name);
        }
    }
}
