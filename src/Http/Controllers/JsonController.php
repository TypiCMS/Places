<?php

namespace TypiCMS\Modules\Places\Http\Controllers;

use Illuminate\Http\JsonResponse;
use TypiCMS\Modules\Core\Http\Controllers\BasePublicController;
use TypiCMS\Modules\Places\Models\Place;

class JsonController extends BasePublicController
{
    public function index(): JsonResponse
    {
        $institutions = Place::published()->get()->map(function ($item) {
            $item->url = url($item->uri());

            return $item;
        });

        return response()->json($institutions);
    }

    public function show(string $slug): JsonResponse
    {
        $institution = Place::published()->whereSlugIs($slug)->firstOrFail();

        return response()->json($institution);
    }
}
