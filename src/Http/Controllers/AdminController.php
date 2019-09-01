<?php

namespace TypiCMS\Modules\Places\Http\Controllers;

use TypiCMS\Modules\Core\Http\Controllers\BaseAdminController;
use TypiCMS\Modules\Places\Http\Requests\FormRequest;
use TypiCMS\Modules\Places\Models\Place;

class AdminController extends BaseAdminController
{
    /**
     * List models.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('places::admin.index');
    }

    /**
     * Create form for a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $model = new;

        return view('places::admin.create')
            ->with(compact('model'));
    }

    /**
     * Edit form for the specified resource.
     *
     * @param \TypiCMS\Modules\Places\Models\Place $place
     *
     * @return \Illuminate\View\View
     */
    public function edit(Place $place)
    {
        return view('places::admin.edit')
            ->with(['model' => $place]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \TypiCMS\Modules\Places\Http\Requests\FormRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(FormRequest $request)
    {
        $model = ::create($request->all());

        return $this->redirect($request, $model);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \TypiCMS\Modules\Places\Models\Place              $place
     * @param \TypiCMS\Modules\Places\Http\Requests\FormRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Place $place, FormRequest $request)
    {
        ::update($request->id, $request->all());

        return $this->redirect($request, $place);
    }

    /**
     * List models.
     *
     * @return \Illuminate\View\View
     */
    public function files(Place $place)
    {
        $data = [
            'models' => $place->files,
        ];

        return response()->json($data, 200);
    }
}
