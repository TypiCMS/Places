<?php

namespace TypiCMS\Modules\Places\Repositories;

use TypiCMS\Modules\Core\Repositories\EloquentRepository;
use TypiCMS\Modules\Places\Models\Place;

class EloquentPlace extends EloquentRepository
{
    protected $repositoryId = 'places';

    protected $model = Place::class;
}
