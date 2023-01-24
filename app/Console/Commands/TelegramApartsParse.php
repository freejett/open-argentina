<?php

namespace App\Console\Commands;

use App\Http\Controllers\Backend\Parsers\Telegram\TelegramController;
use App\Traits\TelegramTrait;
use Illuminate\Console\Command;

class TelegramApartsParse extends Command
{
    use TelegramTrait;

    /**
     * The name and signature of the console command.
     * Получаем сообщения из чата
     * @var string
     */
    protected $signature = 'telegram:get_raw_msgs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Получаем сообщения из телеграм чата';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->telegramInit(TelegramController::CHAT_ID);
        $this->getChatMessages();
//        $this->updateChatSettings();
        return Command::SUCCESS;
    }
}
