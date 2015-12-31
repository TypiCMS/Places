<?php

namespace TypiCMS\Modules\Places\Http\Controllers;

use TypiCMS\Modules\Core\Http\Controllers\BaseAdminController;
use TypiCMS\Modules\Places\Http\Requests\FormRequest;
use TypiCMS\Modules\Places\Models\Place;
use TypiCMS\Modules\Places\Repositories\PlaceInterface;

class AdminController extends BaseAdminController
{
    public function __construct(PlaceInterface $place)
    {
        parent::__construct($place);
    }

    /**
     * Create form for a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $model = $this->repository->getModel();

        return view('core::admin.create')
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
        return view('core::admin.edit')
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
        $model = $this->repository->create($request->all());

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
        $this->repository->update($request->all());

        return $this->redirect($request, $place);
    }
}
