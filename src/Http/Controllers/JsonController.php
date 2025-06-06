<?php

namespace TypiCMS\Modules\Places\Http\Controllers;

use Illuminate\Http\JsonResponse;
use TypiCMS\Modules\Core\Http\Controllers\BasePublicController;
use TypiCMS\Modules\Places\Models\Place;

class JsonController extends BasePublicController
{
    public function index(): JsonResponse
    {
        $institutions = Place::query()
            ->published()
            ->get()
            ->map(function ($item) {
                $item->url = $item->url();

                return $item;
            });

        return response()->json($institutions);
    }

    public function show(string $slug): JsonResponse
    {
        $institution = Place::query()
            ->published()
            ->whereSlugIs($slug)
            ->firstOrFail();

        return response()->json($institution);
    }
}
