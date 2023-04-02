<?php

namespace App\Models\Telegram;

use App\Models\News;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TelegramChat extends Model
{
    use HasFactory;

    /**
     * Путь до аватара
     * @var string
     */
    public static string $baseAvatarPath = 'app/public/telegram/chats/avatars/';

    public array $chatTypes = [
        1 => 'realtors',
        2 => 'exchange',
    ];

    protected $fillable = [
        'chat_id',
        'type_id',
        'title',
        'username',
        'about',
        'chat_photo',
        'contact',
    ];

//    public function

    /**
     * Новости
     * @return HasMany
     */
    public function news(): HasMany
    {
        return $this->hasMany(News::class);
    }
}
