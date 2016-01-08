<?php

namespace TypiCMS\Modules\Places\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Request;
use TypiCMS\Modules\Core\Repositories\CacheAbstractDecorator;
use TypiCMS\Modules\Core\Services\Cache\CacheInterface;

class CacheDecorator extends CacheAbstractDecorator implements PlaceInterface
{
    public function __construct(PlaceInterface $repo, CacheInterface $cache)
    {
        $this->repo = $repo;
        $this->cache = $cache;
    }

    /**
     * Get paginated models.
     *
     * @param int   $page  Number of models per page
     * @param int   $limit Results per page
     * @param bool  $all   get published models or all
     * @param array $with  Eager load related models
     *
     * @return stdClass Object with $items && $totalItems for pagination
     */
    public function byPage($page = 1, $limit = 10, array $with = ['translations'], $all = false)
    {
        $cacheKey = md5(config('app.locale').'byPage.'.$page.$limit.$all.serialize(Request::except('page')));

        if ($this->cache->has($cacheKey)) {
            return $this->cache->get($cacheKey);
        }

        $models = $this->repo->byPage($page, $limit, $with, $all);

        // Store in cache for next request
        $this->cache->put($cacheKey, $models);

        return $models;
    }

    /**
     * Get all models.
     *
     * @param bool  $all  Show published or all
     * @param array $with Eager load related models
     *
     * @return Collection
     */
    public function all(array $with = ['translations'], $all = false)
    {
        $cacheKey = md5(config('app.locale').'all'.$all.serialize($with).serialize(Request::all()));

        if ($this->cache->has($cacheKey)) {
            return $this->cache->get($cacheKey);
        }

        $models = $this->repo->all(['translations'], $all);

        // Store in cache for next request
        $this->cache->put($cacheKey, $models);

        return $models;
    }
}
