<?php

namespace App\Events;

use App\Entities\Collaborator;
use App\Entities\Financial;
use App\Entities\Task;
use Illuminate\Broadcasting\Channel;
use Illuminate\Http\UploadedFile;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Support\Collection;

class PaymentEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    /**
     * @var Financial
     */
    private $financial;
    /**
     * @var Task
     */
    private $task;
    /**
     * @var Collaborator
     */
    private $collaborator;
    /**
     * @var UploadedFile
     */
    private $receipt;

    /**
     * Create a new event instance.
     *
     * @param Financial $financial
     * @param Task $task
     * @param Collaborator $collaborator
     */
    public function __construct(UploadedFile $receipt = null, Financial $financial, Collection $task, Collaborator $collaborator)
    {
        $this->financial = $financial;
        $this->task = $task;
        $this->collaborator = $collaborator;
        $this->receipt = $receipt;
    }

    /**
     * @return UploadedFile
     */
    public function getReceipt()
    {
        return $this->receipt;
    }

    /**
     * @return Collaborator
     */
    public function getCollaborator()
    {
        return $this->collaborator;
    }

    /**
     * @return Task
     */
    public function getTask()
    {
        return $this->task;
    }

    /**
     * @return Financial
     */
    public function getFinancial()
    {
        return $this->financial;
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
}
