<?php

namespace App\Events;

use App\Entities\Collaborator;
use App\Entities\Financial;
use Illuminate\Broadcasting\Channel;
use Illuminate\Http\UploadedFile;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class UpdateReceiptEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    /**
     * @var Financial
     */
    private $financial;
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
     * @param UploadedFile $receipt
     * @param Financial $financial
     * @param Collaborator $collaborator
     */
    public function __construct(UploadedFile $receipt, Financial $financial, Collaborator $collaborator)
    {
        $this->financial = $financial;
        $this->collaborator = $collaborator;
        $this->receipt = $receipt;
    }

    /**
     * @return Financial
     */
    public function getFinancial()
    {
        return $this->financial;
    }

    /**
     * @return Collaborator
     */
    public function getCollaborator()
    {
        return $this->collaborator;
    }

    /**
     * @return UploadedFile
     */
    public function getReceipt()
    {
        return $this->receipt;
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
