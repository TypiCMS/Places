<?php
namespace TypiCMS\Modules\Places\Repositories;

use App;
use Illuminate\Database\Eloquent\Collection;
use Input;
use TypiCMS\Repositories\CacheAbstractDecorator;
use TypiCMS\Services\Cache\CacheInterface;

class CacheDecorator extends CacheAbstractDecorator implements PlaceInterface
{

    public function __construct(PlaceInterface $repo, CacheInterface $cache)
    {
        $this->repo = $repo;
        $this->cache = $cache;
    }

    /**
     * Get paginated models
     *
     * @param  int      $page  Number of models per page
     * @param  int      $limit Results per page
     * @param  boolean  $all   get published models or all
     * @param  array    $with  Eager load related models
     * @return stdClass Object with $items && $totalItems for pagination
     */
    public function byPage($page = 1, $limit = 10, array $with = array('translations'), $all = false)
    {
        $cacheKey = md5(App::getLocale().'byPage.'.$page.$limit.$all.implode('.', Input::except('page')));

        if ($this->cache->has($cacheKey)) {
            return $this->cache->get($cacheKey);
        }

        $models = $this->repo->byPage($page, $limit, $with, $all);

        // Store in cache for next request
        $this->cache->put($cacheKey, $models);

        return $models;
    }

    /**
     * Get all models
     *
     * @param  boolean  $all  Show published or all
     * @param  array    $with Eager load related models
     * @return Collection
     */
    public function getAll(array $with = array('translations'), $all = false)
    {
        $cacheKey = md5(App::getLocale() . 'all' . $all . implode('.', $with) . implode('.', Input::all()));

        if ($this->cache->has($cacheKey)) {
            return $this->cache->get($cacheKey);
        }

        $models = $this->repo->getAll(array('translations'), $all);

        // Store in cache for next request
        $this->cache->put($cacheKey, $models);

        return $models;
    }
}
