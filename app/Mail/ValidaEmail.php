<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ValidaEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
        * Armazena os campos que serão enviados.
        *
        * @access protected
        * @property array $inputs
        */
    protected $inputs;

    /**
        * Cria uma nova instância e
        * armazena os valores dos campos
        * a serem enviados.
        *
        * @access public
        * @param array $inputs
        * @return void
        */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->from('xdeventos@email.com')
            ->subject('XDEventos - Resete sua senha')
            ->markdown('emails.valida_email', $this->data);
    }
}
