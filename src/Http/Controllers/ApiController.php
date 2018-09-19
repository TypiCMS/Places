<?php

namespace TypiCMS\Modules\Places\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;
use TypiCMS\Modules\Core\Http\Controllers\BaseApiController;
use TypiCMS\Modules\Places\Http\Requests\FormRequest;
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
        $models = QueryBuilder::for(Place::class)
            ->translated($request->input('translatable_fields'))
            ->with('files')
            ->paginate($request->input('per_page'));

        return $models;
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

    public function files(Place $place)
    {
        $data = [
            'models' => $place->files,
        ];

        return response()->json($data, 200);
    }
}
