<?php

namespace TypiCMS\Modules\Places\Models;

use Dimsav\Translatable\Translatable;
use Laracasts\Presenter\PresentableTrait;
use TypiCMS\Modules\Core\Models\Base;
use TypiCMS\Modules\History\Traits\Historable;

class Place extends Base
{
    use Historable;
    use Translatable;
    use PresentableTrait;

    protected $presenter = 'TypiCMS\Modules\Places\Presenters\ModulePresenter';

    protected $fillable = [
        'address',
        'email',
        'phone',
        'fax',
        'website',
        'image',
        'latitude',
        'longitude',
        // Translatable columns
        'title',
        'slug',
        'summary',
        'body',
        'status',
    ];

    /**
     * Translatable model configs.
     *
     * @var array
     */
    public $translatedAttributes = [
        'title',
        'slug',
        'summary',
        'body',
        'status',
    ];

    protected $appends = ['status', 'title', 'thumb'];

    /**
     * Columns that are file.
     *
     * @var array
     */
    public $attachments = [
        'image',
    ];
}
