<?php

namespace App\Mail;

use App\Entities\Task;
use App\Repositories\TaskRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendEmailWithAfterTaskAllocated extends Mailable
{
    use Queueable, SerializesModels;
    /**
     * @var TaskRepository
     */
    private $taskRepository;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Task $taskRepository)
    {

        $this->taskRepository = $taskRepository;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $task = $this->taskRepository;
        $url = url('/');
        return $this->from(env('EMAIL_FROM'))
                    ->subject('Foste alocado(a) para uma nova tarefa')
                    ->markdown('admin.event.tasks.mail.task-allocate')
                    ->with('task', $task)
                    ->with('url', $url);
    }
}
