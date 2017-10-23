<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\PessoaDadosAcesso;

class recuperarSenha extends Mailable
{
    use Queueable, SerializesModels;

    protected $senha_nova;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($id_pessoa)
    {
        //
        $this->pessoa =$id_pessoa;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $acesso=PessoaDadosAcesso::where('pessoa', $this->pessoa)->first();
        if($acesso->remember_token==''){
            $custo=15;
            $salt='BpuKl267TczRgPlkm7R6VB';
            $hash=crypt($usuario->login,'$2a$'.$custo.'$'.$salt.'$');
            $acesso->remember_token=$hash;
            $acesso->save();
        }

        $token=urlencode($acesso->remember_token);

        return $this->view('emails.recuperasenha', compact('token'));
    }
}
