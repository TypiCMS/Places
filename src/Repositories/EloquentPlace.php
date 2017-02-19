<?php

namespace TypiCMS\Modules\Places\Repositories;

use Illuminate\Database\Eloquent\Collection;
use stdClass;
use TypiCMS\Modules\Core\Repositories\EloquentRepository;
use TypiCMS\Modules\Places\Models\Place;

class EloquentPlace extends EloquentRepository
{
    protected $repositoryId = 'places';

    protected $model = Place::class;

    /**
     * Get paginated models.
     *
     * @param int  $page  Number of models per page
     * @param int  $limit Results per page
     * @param bool $all   Show published or all
     *
     * @return stdClass Object with $items && $totalItems for pagination
     */
    public function byPage($page = 1, $limit = 10, array $with = [], $all = false)
    {
        $result = new stdClass();
        $result->page = $page;
        $result->limit = $limit;
        $result->totalItems = 0;
        $result->items = [];

        $query = $this->with($with)
            ->select('places.*', 'status', 'title')
            ->join('place_translations', 'place_translations.place_id', '=', 'places.id')
            ->where('locale', config('app.locale'))
            ->skip($limit * ($page - 1))
            ->take($limit);

        if (!$all) {
            $query->published();
        }
        $query->order();
        $models = $query->get();

        // Build query to get totalItems
        $queryTotal = $this->createModel();
        if (!$all) {
            $queryTotal->published();
        }

        // Put items and totalItems in stdClass
        $result->totalItems = $queryTotal->count();
        $result->items = $models->all();

        return $result;
    }

    /**
     * Get all models.
     *
     * @param bool  $all  Show published or all
     * @param array $with Eager load related models
     *
     * @return Collection Object with $items
     */
    public function all(array $with = [], $all = false)
    {
        // get search string
        $string = request('string');

        $query = $this->with($with)
            ->select('places.*', 'status', 'title')
            ->join('place_translations', 'place_translations.place_id', '=', 'places.id')
            ->where('locale', config('app.locale'));

        if (!$all) {
            $query->published();
        }

        $string && $query->where('title', 'LIKE', '%'.$string.'%');

        $query->order();

        // Get
        return $query->get();
    }
}
