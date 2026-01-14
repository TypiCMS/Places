<?php

declare(strict_types=1);

namespace TypiCMS\Modules\Places\Facades;

use Illuminate\Support\Facades\Facade;

class Places extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'Places';
    }
}
