<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use League\Flysystem\File;

class SendDynamicEmail extends Mailable
{
    use Queueable, SerializesModels;
    /**
     * @var
     */
    private $message;
    /**
     * @var null
     */
    private $attach;

    /**
     * Create a new message instance.
     *
     * @param $message
     * @param $subject
     * @param null $attach
     */
    public function __construct($message, $subject, $attach = null)
    {
        $this->message = $message;
        $this->subject = $subject;
        $this->attach = $attach;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $message = $this->message;
        if($this->attach){
            return $this->from(env('EMAIL_FROM'))
                ->subject('Email Dinâmico: '. $this->subject)
                ->attach(public_path('/storage/'.$this->attach))
                ->markdown('admin.dynamic.mail', compact('message'));
        }else{
            return $this->from(env('EMAIL_FROM'))
                ->subject('Email Dinâmico: '. $this->subject)
                ->markdown('admin.dynamic.mail', compact('message'));
        }
    }
}
