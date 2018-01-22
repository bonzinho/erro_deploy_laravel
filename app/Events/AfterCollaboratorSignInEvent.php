<?php

namespace App\Events;

use App\Entities\Collaborator;
use Illuminate\Broadcasting\Channel;
use Illuminate\Http\UploadedFile;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class AfterCollaboratorSignInEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var UploadedFile
     */
    private $photo;
    /**
     * @var Collaborator
     */
    private $repository;
    /**
     * @var UploadedFile
     */
    private $cv;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(UploadedFile $photo = null, UploadedFile $cv = null, Collaborator $repository)
    {
        $this->photo = $photo;
        $this->repository = $repository;
        $this->cv = $cv;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }

    /**
     * @return UploadedFile
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * @return Collaborator
     */
    public function getRepository()
    {
        return $this->repository;
    }

    /**
     * @return UploadedFile
     */
    public function getCv()
    {
        return $this->cv;
    }
}
