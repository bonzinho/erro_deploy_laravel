<?php

namespace App\Mail;

use App\Entities\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendEmailAfterCancelTaskAllocate extends Mailable
{
    use Queueable, SerializesModels;
    /**
     * @var Task
     */
    private $task;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Task $task)
    {
        //
        $this->task = $task;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $task = $this->task;
        return $this->from(env('EMAIL_FROM'))
            ->subject('A tua alocação foi cancelada')
            ->markdown('admin.event.tasks.mail.cancel-task-allocate', compact('task'));
    }
}
