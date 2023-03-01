<?php

namespace App\Console\Commands\Telegram;

use App\Http\Controllers\Backend\Parsers\Telegram\TelegramController;
use App\Traits\TelegramTrait;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

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
        // ID чатов со сдачей квартир
        $chatIds = config('parsers.aparts.telegram');

        if (!count($chatIds)) {
            Log::info('Не найдены чаты parsers.aparts.telegram для обновления параметров');
            return true;
        }

        $this->telegramInit();
        foreach ($chatIds as $chatId => $chatName) {
            $this->setChatId($chatId);
            $this->updateChatSettings();
        }

        return Command::SUCCESS;
    }
}
