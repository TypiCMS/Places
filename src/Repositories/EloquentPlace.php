<?php
namespace TypiCMS\Modules\Places\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;
use TypiCMS\Modules\Core\Repositories\RepositoriesAbstract;
use stdClass;

class EloquentPlace extends RepositoriesAbstract implements PlaceInterface
{

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Get paginated models
     *
     * @param  int      $page  Number of models per page
     * @param  int      $limit Results per page
     * @param  boolean  $all   Show published or all
     * @return stdClass Object with $items && $totalItems for pagination
     */
    public function byPage($page = 1, $limit = 10, array $with = array(), $all = false)
    {
        $result = new stdClass;
        $result->page = $page;
        $result->limit = $limit;
        $result->totalItems = 0;
        $result->items = array();

        $query = $this->make($with)
            ->select('places.*', 'status', 'title')
            ->join('place_translations', 'place_translations.place_id', '=', 'places.id')
            ->where('locale', config('app.locale'))
            ->skip($limit * ($page - 1))
            ->take($limit);

        if (!$all) {
            $query->online();
        }
        $query->order();
        $models = $query->get();

        // Build query to get totalItems
        $queryTotal = $this->model;
        if (!$all) {
            $queryTotal->online();
        }

        // Put items and totalItems in stdClass
        $result->totalItems = $queryTotal->count();
        $result->items = $models->all();

        return $result;
    }

    /**
     * Get all models
     *
     * @param  boolean  $all  Show published or all
     * @param  array    $with Eager load related models
     * @return Collection Object with $items
     */
    public function all(array $with = array(), $all = false)
    {
        // get search string
        $string = Input::get('string');

        $query = $this->make($with)
            ->select('places.*', 'status', 'title')
            ->join('place_translations', 'place_translations.place_id', '=', 'places.id')
            ->where('locale', config('app.locale'));

        if (!$all) {
            $query->online();
        }

        $string && $query->where('title', 'LIKE', '%'.$string.'%');

        $query->order();

        // Get
        return $query->get();
    }
}
