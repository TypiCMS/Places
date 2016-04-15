<?php

namespace TypiCMS\Modules\Places\Models;

use Laracasts\Presenter\PresentableTrait;
use Spatie\Translatable\HasTranslations;
use TypiCMS\Modules\Core\Models\Base;
use TypiCMS\Modules\History\Traits\Historable;

class Place extends Base
{
    use HasTranslations;
    use Historable;
    use PresentableTrait;

    protected $presenter = 'TypiCMS\Modules\Places\Presenters\ModulePresenter';

    protected $guarded = ['id'];

    public $translatable = [
        'title',
        'slug',
        'summary',
        'body',
        'status',
    ];

    protected $appends = ['thumb'];

    public $attachments = [
        'image',
    ];

    /**
     * Append thumb attribute.
     *
     * @return string
     */
    public function getThumbAttribute()
    {
        return $this->present()->thumbSrc(null, 22);
    }
}
