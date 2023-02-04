<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MoneyExchange extends Model
{
    use HasFactory;

    protected $fillable = [
        'chat_id',
        'msg_id',
        'exchange_direction_id',
        'date',
        'rate',
        'msg',
        'created_at',
        'updated_at',
    ];
}
