<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
//         $schedule->command('telegram:update_chat_settings')->daily();
//         $schedule->command('telegram:get_chat_messages')->everyThreeHours();
//         $schedule->command('telegram:parse')->everyThreeHours();
//         $schedule->command('geocoder_here:search_coords')->dailyAt('01:00');

        /*
         * tests
         */
//        $schedule->command('telegram:get_chat_messages')->everyMinute();
        $schedule->command('geocoder_here:search_coords')->everyMinute();
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
