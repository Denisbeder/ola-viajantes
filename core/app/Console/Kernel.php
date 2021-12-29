<?php

namespace App\Console;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

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
        /* $schedule->call(function () {
            $service = new \App\Supports\Services\FacebookInsertDataService;
            $service->insert();
        })->hourly(); */ //->cron('0 */2 * * *'); // Executa a tarefa a cada 2 horas

        // Gera o sitemap diariamente
        $schedule->command('sitemap:generate')->daily();

        // Remove all cache 
        $schedule->call(function () {
            Artisan::call("page-cache:clear"); 
        })->hourly();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
