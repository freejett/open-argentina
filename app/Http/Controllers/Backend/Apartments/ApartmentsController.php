<?php

namespace App\Http\Controllers\Backend\Apartments;

use App\Http\Controllers\Backend\BackendController;
use App\Models\ApartmentsData;
use App\Models\News;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ApartmentsController extends BackendController
{
    protected string $telegramTypeName = 'aparts';
    protected string $routePath = 'aparts';

    public function __construct()
    {
        parent::__construct();

        $this->telegramTypeId = array_search($this->telegramTypeName, config("parsers.telegram_channel_types"));
        $this->templateBase .= $this->routePath .'.';

        view()->share('templateBase', $this->templateBase);
        view()->share('avatarPath', $this->avatarPath);
    }

    /**
     * Список квартир
     * @return View
     */
    public function index(): View
    {
        $apartments = ApartmentsData::orderBy('id', 'desc')->paginate(50);
//        $newStatus = ApartmentsDataews::$newStatus;
//        dd($newStatus);

        return view($this->templateBase . $this->currentMethod, [
            'apartments' => $apartments,
//            'newStatus' => $newStatus,
        ]);
    }

    /**
     * Редактирование параметров квартиры
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        $apartments = ApartmentsData::find($id);

        return view($this->templateBase . $this->currentMethod, [
            'apartments' => $apartments,
        ]);
    }

    /**
     * Обновление новости
     * @param Request $request
     * @param ApartmentsData $apartments
     * @param int $id
     * @return RedirectResponse
     */
    public function update(Request $request, ApartmentsData $apartments, int $id): RedirectResponse
    {
        $apartments->find($id)->update($request->all());
//        dd($news);

        return redirect()->route('backend.aparts.list.edit', $id)
            ->with('success', 'Apartment updated successfully');
    }
}
