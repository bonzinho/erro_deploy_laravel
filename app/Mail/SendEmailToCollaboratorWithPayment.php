<?php

namespace App\Mail;

use App\Entities\Financial;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendEmailToCollaboratorWithPayment extends Mailable
{
    use Queueable, SerializesModels;
    /**
     * @var Financial
     */
    private $financial;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Financial $financial)
    {
        //
        $this->financial = $financial;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $financial = $this->financial;
        return $this->from(env('EMAIL_FROM'))
            ->subject('Pagamento efetuado')
            ->markdown('admin.financials.mail.payment', compact('financial'));
    }
}
