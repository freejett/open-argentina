<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Настройки для парсинга чатов
 * @property integer id
 * @property integer chat_id
 * @property integer current_msg_id
 * @property integer per_page
 * @property integer last_chat_msg_id
 * @property json chat_info
 *
 */
class ChatSettings extends Model
{
    use HasFactory;

    protected $attributes = ['id', 'chat_id', 'current_msg_id', 'per_page', 'last_chat_msg_id', 'chat_info'];

    protected $fillable = ['chat_id', 'current_msg_id', 'per_page', 'last_chat_msg_id', 'chat_info'];
}
