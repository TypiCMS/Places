<?php
namespace TypiCMS\Modules\Places\Repositories;

use Illuminate\Database\Eloquent\Collection;
use stdClass;
use TypiCMS\Repositories\RepositoryInterface;

interface PlaceInterface extends RepositoryInterface
{

    /**
     * Get paginated models
     *
     * @param  int      $page  Number of models per page
     * @param  int      $limit Results per page
     * @param  boolean  $all   Show published or all
     * @return stdClass Object with $items && $totalItems for pagination
     */
    public function byPage($page = 1, $limit = 10, array $with = array('translations'), $all = false);

    /**
     * Get all models
     *
     * @param  boolean  $all  Show published or all
     * @param  array    $with Eager load related models
     * @return Collection
     */
    public function getAll(array $with = array('translations'), $all = false);
}
