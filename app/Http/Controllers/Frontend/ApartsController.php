<?php

namespace App\Http\Controllers\Frontend;

use App\Filters\Frontend\ApartsFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreApartmentsDataRequest;
use App\Http\Requests\UpdateApartmentsDataRequest;
use App\Models\ApartmentsData;
use App\Models\RawAppartmentsData;
use App\Models\References\ReferenceRoomsNumber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class ApartsController extends FrontController
{
    public function __construct()
    {
        parent::__construct();

        $this->templateBase .= 'aparts.';
        view()->share('templateBase', $this->templateBase);
    }

    /**
     * Display a listing of the resource.
     * @param Request $request
     * @param ApartsFilter $filter
     * @return array|false|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|mixed
     */
    public function index(Request $request, ApartsFilter $filter)
    {
        // квартиры для карты
        $apartments = ApartmentsData::filter($filter)->get();
        // типа квартир
        $apartTypes = ReferenceRoomsNumber::pluck('title', 'number_of_rooms');
        // нижний и верхний края диапазона цены
        list($min, $max) = ApartmentsData::getMinMaxPrice();

        return view($this->templateBase . $this->currentMethod, [
            'apartments' => $apartments,
            'apartTypes' => $apartTypes,
            'filter' => $request->query(),
            'request' => $request,
            'min' => $min,
            'max' => $max,
        ]);
    }

    /**
     * Display the specified resource.
     * @param $id
     * @return array|false|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|mixed
     */
    public function show($id)
    {
        $apartment = ApartmentsData::find($id);
        $rawApartments = RawAppartmentsData::where('chat_id', $apartment->chat_id)
                            ->where('msg_id', $apartment->msg_id)
                            ->first();
//        dd($rawApartments);

        return view($this->templateBase . $this->currentMethod, [
            'apartment' => $apartment,
            'rawApartments' => $rawApartments,
        ]);
    }
}
