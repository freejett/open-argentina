<?php

namespace App\Console\Commands\Telegram;

use App\Http\Controllers\Backend\Parsers\Telegram\TelegramController;
use App\Traits\TelegramTrait;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ParseData extends Command
{
    use TelegramTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'telegram:parse';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Спарсить данные в БД';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // ID чатов со сдачей квартир
        $chatIds = config('parsers.aparts.telegram');

        if (!count($chatIds)) {
            Log::info('Не найдены чаты parsers.aparts.telegram для обновления параметров');
            return true;
        }

        foreach ($chatIds as $chatId => $chatName) {
            $this->telegramInit($chatId);
            $this->parseRawData();
        }

        return Command::SUCCESS;
    }
}
