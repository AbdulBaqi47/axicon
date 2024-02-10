<?php

namespace App\Console;

use App\Console\Commands\YTStatsUpdate;
use Illuminate\Console\Scheduling\Schedule;
use App\Console\Commands\DailymotionCMSUpdate;
use App\Console\Commands\DailymotionStatsUpdate;
use App\Console\Commands\DailymotionTokenUpdate;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\YTStatsUpdate::class,
        Commands\DailymotionStatsUpdate::class,
        Commands\DailymotionTokenUpdate::class,
        Commands\DailymotionCMSUpdate::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('youtube:update')->daily()->evenInMaintenanceMode();;
        $schedule->command('dailymotion:update')->daily()->evenInMaintenanceMode();;
        $schedule->command('dmtoken:update')->hourly()->evenInMaintenanceMode();
        $schedule->command('dmcms:update')->hourly()->evenInMaintenanceMode();
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
