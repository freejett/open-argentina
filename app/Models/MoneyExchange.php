<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

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

    /**
     * Сообщение из телеграм канала
     */
    public function rawTelegramMessage()
    {
        return $this->belongsTo(RawTelegramMsg::class, 'msg_id', 'msg_id');
    }

    /**
     * Возвращает текущие курсы обмена для виджета
     * @param array $exchangeDirectionsId
     * @return Collection
     */
    public static function getTodayExchanges(array $exchangeDirectionsId = []): Collection
    {
        $chatIds = config('parsers.exchange.telegram');
        $exchange = collect([]);

        foreach ($chatIds as $chatId => $chatName) {
            $query = self::select('chat_id', 'exchange_direction_id', 'date', 'rate', 'msg_id')
                ->where('chat_id', $chatId)
                ->whereRaw("msg_id = (select max(`msg_id`) from money_exchanges where chat_id = $chatId)");

            if (count($exchangeDirectionsId)) {
                $query->whereIn('exchange_direction_id', $exchangeDirectionsId);
            }

            $exchange = $query->get();
        }

        return $exchange;
    }

    /**
     * Возвратить последние сообщения об обмене для каждого ТГ-канала
     * @return Collection
     */
    public static function getExchanges(): Collection
    {
        $chatIds = config('parsers.exchange.telegram');
        $exchange = collect([]);

        foreach ($chatIds as $chatId => $chatName) {
            $exchange[$chatId] = self::select('chat_id', 'exchange_direction_id', 'date', 'rate', 'msg_id', 'msg')
                ->where('chat_id', $chatId)
                ->whereRaw("msg_id = (select max(`msg_id`) from money_exchanges where chat_id = $chatId)")
                ->orderBy('exchange_direction_id', 'asc')
                ->get();
        }

        return collect($exchange);
    }


    /**
     * Возвратить последние сообщения об обмене для выбранного ТГ-канала
     * @param int $chatId
     * @return Collection
     */
    public static function getCurrentExchangesForChat(int $chatId): Collection
    {
        return self::select('chat_id', 'exchange_direction_id', 'date', 'rate', 'msg_id', 'msg')
                ->where('chat_id', $chatId)
                ->whereRaw("msg_id = (select max(`msg_id`) from money_exchanges where chat_id = $chatId)")
                ->get();
    }
}
