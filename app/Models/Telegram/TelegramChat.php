<?php

namespace App\Models\Telegram;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TelegramChat extends Model
{
    use HasFactory;

    public array $chatTypes = [
        1 => 'realtors',
        2 => 'exchange',
    ];

//    public function
}
