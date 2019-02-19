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
        $models = $this->repository->all();

        return view('places::public.index')
            ->with(compact('models'));
    }

    /**
     * Show place.
     *
     * @return \Illuminate\View\View
     */
    public function show($slug)
    {
        $model = $this->repository->bySlug($slug);

        return view('places::public.show')
            ->with(compact('model'));
    }

    public function json()
    {
        return $this->repository->all()->map(function($item){
            $item->url = $item->uri();

            return $item;
        });
    }

    public function jsonItem($id)
    {
        return $this->repository->find($id);
    }
}
