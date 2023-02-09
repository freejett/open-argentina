<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Realtor extends Model
{
    use HasFactory;

    protected $fillable = [
        'chat_id',
        'name',
        'telegram',
        'whatsapp',
        'msg_preview',
        'msg',
        'created_at',
        'updated_at',
    ];
}
