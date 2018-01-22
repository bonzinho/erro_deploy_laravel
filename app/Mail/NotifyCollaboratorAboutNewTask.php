<?php

namespace App\Mail;

use App\Entities\Task;
use App\Repositories\TaskRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyCollaboratorAboutNewTask extends Mailable
{
    use Queueable, SerializesModels;
    /**
     * @var TaskRepository
     */
    private $task;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Task $task)
    {
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
        $url = url('');
        return $this->from(env('EMAIL_FROM'))
            ->subject('Disponibilidades')
            ->markdown('admin.event.tasks.mail.new-task')
            ->with('task', $task)
            ->with('url', $url);

    }
}
