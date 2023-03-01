<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

/**
 * RAW-данные по квартирам
 * @property integer chat_id
 * @property integer msg_id
 * @property string msg
 * @property integer is_appartment
 * @property string photo
 * @property string created_at
 * @property string updated_at
 *
 */
class RawTelegramMsg extends Model
{
    use HasFactory;

//    protected $attributes = [
//        'chat_id',
//        'msg_id',
//        'msg',
//        'is_appartment',
//        'photo',
//        'created_at',
//        'updated_at',
//    ];

    protected $fillable = [
        'id',
        'chat_id',
        'msg_id',
        'msg',
        'is_appartment',
        'photo',
        'created_at',
        'updated_at',
    ];
}
