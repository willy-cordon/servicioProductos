<?php

namespace App\Console;


use App\Facades\MLAccountServiceOrderSync;
use App\Facades\MLSyncService;
use App\Facades\WooSyncOrders;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;

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
        // $schedule->command('inspire')->hourly();
        $schedule->call(function (){

            Log::debug('[START] Synchronize products ML');
              MLSyncService::syncroniceProducts();
            Log::debug('[FINISH] END Synchronize products ML');

            Log::debug('[START] Synchronize Orders ML');
              MLAccountServiceOrderSync::getServiceML();
            Log::debug('[FINISH] END Synchronize Orders ML');

            Log::debug('[START] Synchronize Orders Woo ');
            WooSyncOrders::synchronizeOrdersWoo();
            Log::debug('[FINISH] END Synchronize Orders Woo');

        })->everyMinute();
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
