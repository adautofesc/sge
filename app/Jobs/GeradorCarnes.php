<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Http\Controllers\CarneController;

class GeradorCarnes implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 3;
    private $pessoa;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($pessoa)
    {
        $this->pessoa = $pessoa;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(CarneController $carne_controller)
    {
        $carne_controller->geradorSegundoPlano($this->pessoa);
        //mail("Job Concluído");
    }
}
