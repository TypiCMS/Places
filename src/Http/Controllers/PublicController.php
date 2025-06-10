<?php

namespace TypiCMS\Modules\Places\Http\Controllers;

use Illuminate\View\View;
use TypiCMS\Modules\Core\Http\Controllers\BasePublicController;
use TypiCMS\Modules\Places\Models\Place;

class PublicController extends BasePublicController
{
    public function index(): View
    {
        $models = Place::query()
            ->published()
            ->order()
            ->with('image')
            ->get();

        return view('places::public.index')
            ->with(compact('models'));
    }

    public function show(string $slug): View
    {
        $model = Place::query()
            ->published()
            ->whereSlugIs($slug)
            ->firstOrFail();

        return view('places::public.show')
            ->with(compact('model'));
    }
}
