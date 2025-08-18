<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Atestado;
use App\AtestadoLog;

class VerificarAtestados extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:verificar-atestados';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Faz a verificação de validade máxima dos atestados';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Verificando atestados...');
        $hoje = Carbon::now();
        $modificados = 0;
        $atestados = \App\Atestado::where('tipo','saude')->where('status','aprovado')->whereDate('emissao','<',(clone $hoje)->subMonths(12))->get();
        //dd((clone $hoje)->subMonths(12));
		foreach($atestados as $atestado){       
            $atestado->status = 'vencido';
            $atestado->save();

            $log = new AtestadoLog;
            $log->atestado = $atestado->id;
            $log->evento = 'Procedimento automatizado de validação';
            $log->pessoa = 0;
            $log->data = Carbon::now();
            $log->save();

            $modificados++;

			
			

		}
        
        $this->info($atestados->count().' atestados vencidos '.$modificados.' foram alterados.');
    }
}
