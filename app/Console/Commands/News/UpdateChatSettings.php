<?php

namespace App\Console\Commands\News;

use App\Models\Telegram\TelegramChat;
use App\Traits\TelegramNewsTrait;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class UpdateChatSettings extends Command
{
    use TelegramNewsTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'news:update_chat_settings';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Обновить настройки новостных чатов и получить ID последнего сообщения';

    protected array $chatIds;

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // ID новостных каналов
        $this->chatIds = TelegramChat::where('type_id', 3)
            ->pluck('chat_id')
            ->toArray();

        if (!count($this->chatIds)) {
            Log::info('Не найдены чаты parsers.news.telegram для обновления параметров');
            return true;
        }

        $this->telegramInit();
        $this->updateChatSettings($this->chatIds);
        return Command::SUCCESS;
    }
}
