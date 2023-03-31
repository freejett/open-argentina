<?php

namespace App\Models;

use App\Models\Telegram\TelegramChat;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class News
 *
 * @property $id
 * @property $chat_id
 * @property $msg_id
 * @property $date
 * @property $title
 * @property $body
 * @property $announcement
 * @property $cover
 * @property $link
 * @property $status
 * @property $created_at
 * @property $updated_at
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class News extends Model
{
    /**
     * Статус новости $status
     * 0 - не обработана
     * 1 - не публикуем
     * 2 - публикуем анонс
     * 3 - публикуем полностью
     */

    static $rules = [
		'chat_id' => 'required',
		'msg_id' => 'required',
		'date' => 'required',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['chat_id','msg_id','date','title','views','forwards','body','announcement','cover','link','status'];

    /**
     * Связанный ТГ канал
     * @return BelongsTo
     */
    public function channel(): BelongsTo
    {
        return $this->belongsTo(TelegramChat::class, 'chat_id', 'chat_id');
    }
}
