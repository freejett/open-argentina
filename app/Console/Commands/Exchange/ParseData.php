<?php

namespace App\Console\Commands\Exchange;

use App\Traits\MoneyExchangeTrait;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ParseData extends Command
{
    use MoneyExchangeTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'exchange:parse';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Спарсить данные об обменных курсах в БД';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // ID чатов со сдачей квартир
        $chatIds = config('parsers.exchange.telegram');

        if (!count($chatIds)) {
            Log::info('Не найдены чаты parsers.exchange.telegram для обновления параметров');
            return true;
        }

        $this->telegramInit();
        foreach ($chatIds as $chatId => $chatName) {
            $this->setChatId($chatId);
            $this->parseRawData();
        }
        return Command::SUCCESS;
    }
}
