<?php

namespace TypiCMS\Modules\Places\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use TypiCMS\Modules\Core\Http\Controllers\BaseAdminController;
use TypiCMS\Modules\Places\Http\Requests\FormRequest;
use TypiCMS\Modules\Places\Models\Place;

class AdminController extends BaseAdminController
{
    public function index(): View
    {
        return view('places::admin.index');
    }

    public function create(): View
    {
        $model = new Place();

        return view('places::admin.create')
            ->with(compact('model'));
    }

    public function edit(Place $place): View
    {
        return view('places::admin.edit')
            ->with(['model' => $place]);
    }

    public function store(FormRequest $request): RedirectResponse
    {
        $model = Place::create($request->all());

        return $this->redirect($request, $model);
    }

    public function update(Place $place, FormRequest $request): RedirectResponse
    {
        $place->update($request->all());

        return $this->redirect($request, $place);
    }

    public function files(Place $place): JsonResponse
    {
        $data = [
            'models' => $place->files,
        ];

        return response()->json($data, 200);
    }
}
