<?php

namespace TypiCMS\Modules\Places\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\QueryBuilder\Filter;
use Spatie\QueryBuilder\QueryBuilder;
use TypiCMS\Modules\Core\Filters\FilterOr;
use TypiCMS\Modules\Core\Http\Controllers\BaseApiController;
use TypiCMS\Modules\Files\Models\File;
use TypiCMS\Modules\Places\Models\Place;
use TypiCMS\Modules\Places\Repositories\EloquentPlace;

class ApiController extends BaseApiController
{
    public function __construct(EloquentPlace $place)
    {
        parent::__construct($place);
    }

    public function index(Request $request)
    {
        $data = QueryBuilder::for(Place::class)
            ->allowedFilters([
                Filter::custom('title', FilterOr::class),
            ])
            ->allowedIncludes('files','images')
            ->translated($request->input('translatable_fields'))
            ->paginate($request->input('per_page'));

        return $data;
    }

    protected function updatePartial(Place $place, Request $request)
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

        $this->repository->forgetCache();

        return response()->json([
            'error' => !$saved,
        ]);
    }

    public function destroy(Place $place)
    {
        $deleted = $this->repository->delete($place);

        return response()->json([
            'error' => !$deleted,
        ]);
    }

    public function files(Place $place)
    {
        return $place->files;
    }

    public function attachFiles(Place $place, Request $request)
    {
        return $this->repository->attachFiles($place, $request);
    }

    public function detachFile(Place $place, File $file)
    {
        return $this->repository->detachFile($place, $file);
    }
}
