<?php

namespace App\Http\Controllers\Backend\Geo;

use App\Http\Controllers\Controller;
use App\Models\ApartmentsData;
use App\Traits\Geocoder\HereGeocoder;
use Geocoder\Query\GeocodeQuery;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;
use Geocoder\Provider\Here\Here;
use Geocoder\StatefulGeocoder;

/**
 * Определение координат места по адресу
 */
class HereMapController extends Controller
{
    use HereGeocoder;

    public function index()
    {
        $this->searchCoordsByAddress();
        return true;
    }
}
