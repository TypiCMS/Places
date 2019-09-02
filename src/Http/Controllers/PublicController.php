<?php

namespace TypiCMS\Modules\Places\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use TypiCMS\Modules\Core\Http\Controllers\BasePublicController;
use TypiCMS\Modules\Places\Models\Place;

class PublicController extends BasePublicController
{
    public function index(): View
    {
        $models = $this->model->all();

        return view('places::public.index')
            ->with(compact('models'));
    }

    public function show($slug): View
    {
        $model = Place::where(column('slug'), $slug)->firstOrFails();

        return view('places::public.show')
            ->with(compact('model'));
    }

    public function json(): JsonResponse
    {
        return Place::get()->map(function ($item) {
            $item->url = $item->uri();

            return $item;
        });
    }

    public function jsonItem($id): JsonResponse
    {
        return Place::find($id);
    }
}
