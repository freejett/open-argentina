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
        /**
         * Общий принцип установки времени парсинга для разных сущностей
         * на основе простых чисел, чтобы запросы как можно реже пересекались друг с другом
         * и не создавали пиковые нагрузки на процессор
         *
         * Список простых чисел:
         * 2, 3, 5, 7, 11, 13, 17, 19, 23, 29, 31, 37, 41, 43, 47, 53, 59, 61, 67, 71, 73, 79,
         * 83, 89, 97, 101, 103, 107, 109, 113, 127, 131, 137, 139, 149, 151, 157, 163, 167, 1
         * 73, 179, 181, 191, 193, 197, 199
         */

        // парсер квартир
        $schedule->command('telegram:update_chat_settings')->cron('23 * * * *');
        $schedule->command('telegram:get_chat_messages')->cron('23 * * * *');
        $schedule->command('telegram:parse')->cron('23 * * * *');

        // пасинг курсов валют
        $schedule->command('exchange:update_chat_settings')->cron('17 * * * *');
        $schedule->command('exchange:get_chat_messages')->cron('17 * * * *');
        $schedule->command('exchange:parse')->cron('17 * * * *');

        // парсинг координат квартиры
        $schedule->command('geocoder_here:search_coords')->everyThreeHours();

        // парсинг новостей
        $schedule->command('news:update_chat_settings')->cron('7 * * * *');
        $schedule->command('news:get_chat_messages')->cron('7 * * * *');
        $schedule->command('news:parse')->cron('7 * * * *');
        //*/

        /*
         * tests
         */
//        $schedule->command('news:update_chat_settings')->everyThreeMinutes();
//        $schedule->command('news:get_chat_messages')->everyThreeMinutes();
//        $schedule->command('news:parse')->everyThreeMinutes();

//        $schedule->command('telegram:update_chat_settings')->everyMinute();
//        $schedule->command('telegram:get_chat_messages')->everyMinute();
//        $schedule->command('telegram:parse')->everyMinute();
//        $schedule->command('geocoder_here:search_coords')->everyMinute();

//        $schedule->command('exchange:update_chat_settings')->everyThreeMinutes();
//        $schedule->command('exchange:get_chat_messages')->everyThreeMinutes();
//        $schedule->command('exchange:parse')->everyThreeMinutes();
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
