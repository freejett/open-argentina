<?php

namespace App\Traits\Geocoder;

use App\Models\ApartmentsData;
use Geocoder\Query\GeocodeQuery;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;
use Geocoder\Provider\Here\Here;
use Geocoder\StatefulGeocoder;

/**
 * Если передавать с параметром ?only_photos=1
 * то будут выкачиваться фото для сообщений, у которых есть фото и оно не скачено
 * Нужно доработать так, чтобы выкачивалось не больше 10 фото за раз (пагинация)
 */
trait HereGeocoder {

    /**
     * Поиск координат на основе адреса
     * @return bool
     */
    public function searchCoordsByAddress(): bool
    {
        $httpClient = new Client();
        $provider = Here::createUsingApiKey($httpClient, env('HERE_API_MAP_KEY'));
        $geocoder = new StatefulGeocoder($provider, 'en');

        $aparts = ApartmentsData::whereNull('lat')
            ->limit(5)
            ->orderBy('msg_id', 'asc')
            ->get();

        if (!$aparts) {
            return true;
        }

        foreach ($aparts as $apart) {
            if (!$apart->address) {
                $apartCoords = [
                    'lat' => 2,
                    'lng' => 2,
                ];
                $apart->fill($apartCoords)->save();
                Log::alert('Не указан адрес для '. $apart->chat_id .' '. $apart->msg_id);
                continue;
            }

            if (strlen($apart->address) < 5) {
                $apartCoords = [
                    'lat' => 3,
                    'lng' => 3,
                ];
                $apart->fill($apartCoords)->save();
                Log::alert('Неправильный адрес для '. $apart->chat_id .' '. $apart->msg_id);
                continue;
            }

            $address = 'buenos aires '. $apart->address;
            $result = $geocoder->geocodeQuery(GeocodeQuery::create($address));

            if (!$result->count()) {
                $apartCoords = [
                    'lat' => 1,
                    'lng' => 1,
                ];
                $apart->fill($apartCoords)->save();
                Log::alert('Не найдены координаты для '. $apart->chat_id .' '. $apart->msg_id);
                continue;
            }

            $coords = $result->first()->getCoordinates()->toArray();
            $lat = $coords[0];
            $lng = $coords[1];

            $apartCoords = [
                'lat' => $lat,
                'lng' => $lng,
            ];
            $apart->fill($apartCoords)->save();
            Log::info('Нашли и записали координаты для '. $apart->chat_id .' '. $apart->msg_id);

            sleep(4);
        }

        return true;
    }
}
