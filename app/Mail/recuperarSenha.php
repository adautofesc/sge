<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class recuperarSenha extends Mailable
{
    use Queueable, SerializesModels;

    protected $senha_nova;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($senha)
    {
        //
        $this->senha_nova = $senha;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $senha_nova=['senha'=>$this->senha_nova]
        return $this->view('emails.recuperasenha', compact('senha_nova'));
    }
}
