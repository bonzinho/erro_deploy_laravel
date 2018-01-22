<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendMsgToCollaborator extends Mailable
{
    use Queueable, SerializesModels;
    /**
     * @var
     */
    private $message;

    /**
     * @var
     */
    public $subject;
    /**
     * Create a new message instance.
     *
     * @param $subject
     * @param $message
     */
    public function __construct($subject, $message)
    {
        $this->subject = $subject;
        $this->message = $message;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = $this->subject;
        $message = $this->message;
        return $this->from('eventos@fe.up.pt')
            ->subject($subject)
            ->markdown('emails.collaborators.send_message')
            ->with('message', $message)
            ->with('subject', $subject)
            ->with('url', url('/'));
    }
}
