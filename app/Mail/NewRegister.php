<?php

namespace App\Mail;

use App\Entities\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewRegister extends Mailable
{
    use Queueable, SerializesModels;
    /**
     * @var Client
     */
    private $client;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $client = $this->client;
        return $this->from(env('EMAIL_FROM'))
            ->subject('Bem vindo - Plataforma Centro de Eventos FEUP')
            ->markdown('client.mail.new-register', compact('client'));
    }
}
