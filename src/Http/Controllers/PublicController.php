<?php

namespace TypiCMS\Modules\Places\Http\Controllers;

use Illuminate\Support\Facades\Request;
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
        $models = $this->repository->published()->findAll();
        if (Request::ajax()) {
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
        if (Request::ajax()) {
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
        $model = $this->repository->published()->bySlug($slug);
        if (Request::ajax()) {
            return $model;
        }

        return view('places::public.show')
            ->with(compact('model'));
    }
}
