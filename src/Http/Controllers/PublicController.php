<?php

namespace TypiCMS\Modules\Places\Http\Controllers;

use TypiCMS\Modules\Core\Http\Controllers\BasePublicController;

class PublicController extends BasePublicController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $models = $this->model->all();

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
        $model = $this->model->bySlug($slug);

        return view('places::public.show')
            ->with(compact('model'));
    }

    public function json()
    {
        return $this->model->all()->map(function ($item) {
            $item->url = $item->uri();

            return $item;
        });
    }

    public function jsonItem($id)
    {
        return $this->model->find($id);
    }
}
