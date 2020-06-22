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

    private $menagem;
    Private $destinatarios;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($mensagem,$destinatarios)
    {
        $this->mensagem = $mensagem;
        $this->destinatarios = $destinatarios;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(ContatoController $CC)
    {
        $CC->enviarSMS($this->mensagem,[$this->destinatarios]);
    }
}
