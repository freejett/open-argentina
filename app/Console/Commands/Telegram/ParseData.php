<?php

namespace App\Console\Commands\Telegram;

use App\Http\Controllers\Backend\Parsers\Telegram\TelegramController;
use App\Traits\TelegramTrait;
use Illuminate\Console\Command;

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
        $this->telegramInit(TelegramController::CHAT_ID);
        $this->parseRawData();

        return Command::SUCCESS;
    }
}
