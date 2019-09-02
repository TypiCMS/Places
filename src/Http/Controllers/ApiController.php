<?php

namespace TypiCMS\Modules\Places\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\Filter;
use Spatie\QueryBuilder\QueryBuilder;
use TypiCMS\Modules\Core\Filters\FilterOr;
use TypiCMS\Modules\Core\Http\Controllers\BaseApiController;
use TypiCMS\Modules\Files\Models\File;
use TypiCMS\Modules\Places\Models\Place;

class ApiController extends BaseApiController
{
    public function index(Request $request): LengthAwarePaginator
    {
        $data = QueryBuilder::for(Place::class)
            ->allowedFilters([
                Filter::custom('title', FilterOr::class),
            ])
            ->allowedIncludes('image')
            ->translated($request->input('translatable_fields'))
            ->paginate($request->input('per_page'));

        return $data;
    }

    protected function updatePartial(Place $place, Request $request): JsonResponse
    {
        $data = [];
        foreach ($request->all() as $column => $content) {
            if (is_array($content)) {
                foreach ($content as $key => $value) {
                    $data[$column.'->'.$key] = $value;
                }
            } else {
                $data[$column] = $content;
            }
        }

        foreach ($data as $key => $value) {
            $place->$key = $value;
        }
        $saved = $place->save();

        return response()->json([
            'error' => !$saved,
        ]);
    }

    public function destroy(Place $place): JsonResponse
    {
        $deleted = $place->delete();

        return response()->json([
            'error' => !$deleted,
        ]);
    }

    public function files(Place $place): JsonResponse
    {
        return $place->files;
    }

    public function attachFiles(Place $place, Request $request): JsonResponse
    {
        return $place->attachFiles($request);
    }

    public function detachFile(Place $place, File $file): array
    {
        return $place->detachFile($file);
    }
}
