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

    protected $guarded = ['id', 'exit'];

    public $translatable = [
        'title',
        'slug',
        'summary',
        'body',
        'status',
    ];

    protected $appends = ['thumb', 'title_translated'];

    public $attachments = [
        'image',
    ];

    /**
     * Append title_translated attribute.
     *
     * @return string
     */
    public function getTitleTranslatedAttribute()
    {
        $locale = config('app.locale');
        return $this->translate('title', config('typicms.content_locale', $locale));
    }

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
