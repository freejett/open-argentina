<?php

namespace App\Console\Commands\Exchange;

use App\Traits\MoneyExchangeTrait;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class UpdateChatSettings extends Command
{
    use MoneyExchangeTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'exchange:update_chat_settings';

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
        $chatIds = config('parsers.exchange.telegram');

        if (!count($chatIds)) {
            Log::info('Не найдены чаты parsers.exchange.telegram для обновления параметров');
            return true;
        }

        foreach ($chatIds as $chatId => $chatName) {
            $this->telegramInit($chatId);
            $this->updateChatSettings();
        }
        return Command::SUCCESS;
    }
}
