<?php

namespace App\Http\Controllers\Frontend;

use App\Filters\Frontend\ApartsFilter;
use App\Models\ApartmentsData;
use App\Models\RawTelegramMsg;
use App\Models\Realtor;
use App\Models\References\ReferenceRoomsNumber;
use Illuminate\View\View;
use Illuminate\Http\Request;

class ApartsController extends FrontController
{
    public function __construct()
    {
        parent::__construct();

        $this->templateBase .= 'aparts.';
        $this->pageTitle = 'Снять, найти квартиру в Буэнос-Айресе на длительный срок';
        $this->metaDescription = 'Поиск квартиры Буэнос-Айрес';
        $this->metaKeyword = 'Найти квартиру Буэнос-Айрес, снять квартиру Буэнос-Айрес';

        view()->share('title', $this->pageTitle);
        view()->share('description', $this->metaDescription);
        view()->share('keyword', $this->metaKeyword);
        view()->share('templateBase', $this->templateBase);
    }

    /**
     * Display a listing of the resource.
     * @param Request $request
     * @param ApartsFilter $filter
     * @return View
     */
    public function index(Request $request, ApartsFilter $filter): View
    {
        // квартиры для карты
        $apartments = ApartmentsData::filter($filter)
            ->where('chat_id', -1001632649859)
            ->whereNull('status')
            ->orderBy('id', 'desc')
            ->paginate(30);

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
     * @return View
     */
    public function show($id): View
    {
        $apartment = ApartmentsData::find($id);
        $realtor = Realtor::find(1);
        $rawApartments = RawTelegramMsg::where('chat_id', $apartment->chat_id)
                            ->where('msg_id', $apartment->msg_id)
                            ->first();
//        dd($apartment);

        return view($this->templateBase . $this->currentMethod, [
            'apartment' => $apartment,
            'realtor' => $realtor,
            'rawApartments' => $rawApartments,
        ]);
    }


    public function show_realtor($channelId)
    {
        $realtor = Realtor::find($channelId);

        return view($this->templateBase . $this->currentMethod, [
            'realtor' => $realtor,
        ]);
    }
}
