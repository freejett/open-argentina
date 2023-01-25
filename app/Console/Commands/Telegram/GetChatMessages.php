<?php

namespace App\Console\Commands\Telegram;

use App\Http\Controllers\Backend\Parsers\Telegram\TelegramController;
use App\Traits\TelegramTrait;
use Illuminate\Console\Command;

class GetChatMessages extends Command
{
    use TelegramTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'telegram:get_chat_messages';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Получить сообщения из телеграм чата и записать информацию в БД';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->telegramInit(TelegramController::CHAT_ID);
        $this->getChatMessages();

        return Command::SUCCESS;
    }
}
