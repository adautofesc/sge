<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class EnviaEmails implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 3;
    private $pessoa;
    private $email;
    private $email_fesc;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($pessoa,$email,$email_fesc)
    {
        $this->pessoa = $pessoa;
        $this->email = $email;
        $this->email_fesc = $email_fesc;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        
        $nome = $this->pessoa->nome;
        $email_fesc = $this->email_fesc;
        $email = $this->email;
        
        \Illuminate\Support\Facades\Mail::send('emails.informeboletos2021', ['nome' => $nome,'username'=>$email_fesc ], function ($message) use($email){
            $message->from('no-reply@fesc.saocarlos.sp.gov.br', 'Sistema Fesc');
            $message->to($email);
            $message->subject('Dados de acesso e boletos disponíveis');
            });
    }
}
