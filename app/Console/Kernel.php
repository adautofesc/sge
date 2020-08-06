<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Jobs\ControleFaltas;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        //disparador de fila de trabalho
        $schedule->command('queue:work --stop-when-empty')->everyMinute()->withoutOverlapping();

        $schedule->call( function(){
                dispatch(new ControleFaltas);
            })->daily()->at('21:05');


        $schedule->call( function(){
                dispatch(new ControleBoletos);
            })->daily()->at('18:07');

         //verificar boletos em aberto 
         //

         
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
