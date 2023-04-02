<?php

namespace App\Console\Commands\News;

use App\Models\Telegram\TelegramChat;
use App\Traits\TelegramNewsTrait;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class GetChatMessages extends Command
{
    use TelegramNewsTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'news:get_chat_messages';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Получить новые посты из новостных ТГ-каналов';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // ID чатов новостных каналов
        $this->chatIds = TelegramChat::where('type_id', 3)
            ->pluck('chat_id')
            ->toArray();

        if (!count($this->chatIds)) {
            Log::info('Не найдены чаты parsers.news.telegram для обновления параметров');
            return true;
        }

        $this->telegramInit();
        foreach ($this->chatIds as $chatId) {
            $this->setChatId($chatId);
            $this->getChatMessages();
        }
        return Command::SUCCESS;
    }
}
