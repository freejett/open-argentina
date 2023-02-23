<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TelegramSession.
 *
 * @package App
 * @mixin Builder
 *
 * @property int id
 * @property int user_id
 * @property string session_file
 */
class TelegramSession extends Model
{
    /**
     * @inheritdoc
     */
    protected $fillable = [
        'user_id', 'session_file'
    ];
}
