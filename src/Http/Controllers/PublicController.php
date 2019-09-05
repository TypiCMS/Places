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
        $models = Place::published()->get();

        return view('places::public.index')
            ->with(compact('models'));
    }

    public function show($slug): View
    {
        $model = Place::published()->whereSlugIs($slug)->firstOrFail();

        return view('places::public.show')
            ->with(compact('model'));
    }

    public function json(): JsonResponse
    {
        $places = Place::published()->get()->map(function ($item) {
            $item->url = $item->uri();

            return $item;
        });

        return response()->json($places);

    }

    public function jsonItem($id): JsonResponse
    {
        $place = Place::published()->find($id);

        return response()->json($place);
    }
}
