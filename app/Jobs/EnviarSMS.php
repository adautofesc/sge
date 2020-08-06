<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Http\Controllers\ContatoController;

class EnviarSMS implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $mensagem;
    Private $destinatario;
    private $remetente;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($mensagem,$destinatario,$remetente)
    {
        $this->mensagem = $mensagem;
        $this->destinatario = $destinatario;
        $this->remetente = $remetente;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(ContatoController $CC)
    {
        $CC->enviarSMS($this->mensagem,$this->destinatario,$this->remetente);
    }
}
