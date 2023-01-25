<?php

namespace App\Console\Commands\Telegram;

use App\Http\Controllers\Backend\Parsers\Telegram\TelegramController;
use App\Traits\TelegramTrait;
use Illuminate\Console\Command;

class UpdateChatSettings extends Command
{
    use TelegramTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'telegram:update_chat_settings';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Обновить настройки чата и получить ID последнего сообщения';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->telegramInit(TelegramController::CHAT_ID);
        $this->updateChatSettings();

        return Command::SUCCESS;
    }
}
