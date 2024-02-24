<?php

namespace App\Console;

use App\Console\Commands\UpdateAnimeCommand;
use App\Jobs\SyncAnimeJob;
use App\Services\JikanService;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{

    protected $commands = [
        UpdateAnimeCommand::class,
    ];

    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        //* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
        $schedule->command('anime:update')->dailyAt('06:00');
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
