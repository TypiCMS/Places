<?php

namespace TypiCMS\Modules\Places\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use TypiCMS\Modules\Core\Filters\FilterOr;
use TypiCMS\Modules\Core\Http\Controllers\BaseApiController;
use TypiCMS\Modules\Places\Models\Place;

class ApiController extends BaseApiController
{
    public function index(Request $request): LengthAwarePaginator
    {
        $data = QueryBuilder::for(Place::class)
            ->selectFields()
            ->allowedSorts(['id', 'status_translated', 'title_translated'])
            ->allowedFilters([
                AllowedFilter::custom('title', new FilterOr()),
            ])
            ->allowedIncludes(['image'])
            ->paginate($request->input('per_page'));

        return $data;
    }

    protected function updatePartial(Place $place, Request $request)
    {
        foreach ($request->only('status') as $key => $content) {
            if ($place->isTranslatableAttribute($key)) {
                foreach ($content as $lang => $value) {
                    $place->setTranslation($key, $lang, $value);
                }
            } else {
                $place->{$key} = $content;
            }
        }

        $place->save();
    }

    public function destroy(Place $place)
    {
        $place->delete();
    }
}
