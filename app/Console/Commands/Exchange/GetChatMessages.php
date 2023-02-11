<?php

namespace App\Console\Commands\Exchange;

use App\Traits\MoneyExchangeTrait;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class GetChatMessages extends Command
{
    use MoneyExchangeTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'exchange:get_chat_messages';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Получить сообщения об обменых курсах из телеграм чата и записать информацию в БД';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // ID чатов-обменников
        $chatIds = config('parsers.exchange.telegram');

        if (!count($chatIds)) {
            Log::info('Не найдены чаты parsers.exchange.telegram для обновления параметров');
            return true;
        }

        foreach ($chatIds as $chatId => $chatName) {
            $this->telegramInit($chatId);
            $this->getChatMessages();
        }
        return Command::SUCCESS;
    }
}
