<?php

namespace TypiCMS\Modules\Places\Http\Controllers;

use TypiCMS\Modules\Core\Http\Controllers\BasePublicController;
use TypiCMS\Modules\Places\Repositories\EloquentPlace;

class PublicController extends BasePublicController
{
    public function __construct(EloquentPlace $place)
    {
        parent::__construct($place);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $models = $this->repository->with('files')->published()->findAll();
        if (request()->wantsJson()) {
            return $models;
        }

        return view('places::public.index')
            ->with(compact('models'));
    }

    /**
     * Search models.
     *
     * @return \Illuminate\Support\Facades\Response
     */
    public function search()
    {
        $models = $this->repository->published()->findAll();
        if (request()->wantsJson()) {
            return $models;
        }

        return view('places::public.results')
            ->with(compact('models'));
    }

    /**
     * Show place.
     *
     * @return \Illuminate\View\View
     */
    public function show($slug)
    {
        $model = $this->repository->with('files')->published()->bySlug($slug);
        if (request()->wantsJson()) {
            return $model;
        }

        return view('places::public.show')
            ->with(compact('model'));
    }
}
