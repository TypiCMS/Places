<?php

namespace TypiCMS\Modules\Places\Models;

use TypiCMS\Modules\Core\Models\BaseTranslation;

class PlaceTranslation extends BaseTranslation
{
    protected $fillable = [
        'title',
        'slug',
        'summary',
        'body',
        'status',
    ];

    /**
     * get the parent model.
     */
    public function owner()
    {
        return $this->belongsTo('TypiCMS\Modules\Places\Models\Place', 'place_id');
    }
}
