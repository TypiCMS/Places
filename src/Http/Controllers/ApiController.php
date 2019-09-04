<?php

namespace TypiCMS\Modules\Places\Http\Controllers;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\AllowedFilter;
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
            ->selectFields($request->input('fields.places'))
            ->allowedSorts(['id', 'status_translated', 'title_translated'])
            ->allowedFilters([
                AllowedFilter::custom('title', new FilterOr()),
            ])
            ->allowedIncludes(['image'])
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

    public function files(Place $place): Collection
    {
        return $place->files;
    }

    public function attachFiles(Place $place, Request $request): JsonResponse
    {
        return $place->attachFiles($request);
    }

    public function detachFile(Place $place, File $file): void
    {
        $place->detachFile($file);
    }
}
