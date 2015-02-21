<?php
namespace TypiCMS\Modules\Places\Http\Controllers;

use TypiCMS\Modules\Places\Http\Requests\FormRequest;
use TypiCMS\Modules\Places\Repositories\PlaceInterface;
use TypiCMS\Http\Controllers\BaseAdminController;

class AdminController extends BaseAdminController
{

    public function __construct(PlaceInterface $place)
    {
        parent::__construct($place);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  FormRequest $request
     * @return Redirect
     */
    public function store(FormRequest $request)
    {
        $model = $this->repository->create($request->all());
        return $this->redirect($request, $model);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  $model
     * @param  FormRequest $request
     * @return Redirect
     */
    public function update($model, FormRequest $request)
    {
        $this->repository->update($request->all());
        return $this->redirect($request, $model);
    }
}
