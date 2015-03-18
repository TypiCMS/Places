<?php
namespace TypiCMS\Modules\Places\Models;

use Dimsav\Translatable\Translatable;
use TypiCMS\Models\Base;
use TypiCMS\Modules\History\Traits\Historable;
use TypiCMS\Presenters\PresentableTrait;

class Place extends Base
{

    use Historable;
    use Translatable;
    use PresentableTrait;

    protected $presenter = 'TypiCMS\Modules\Places\Presenters\ModulePresenter';

    protected $fillable = array(
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
    );

    /**
     * Translatable model configs.
     *
     * @var array
     */
    public $translatedAttributes = array(
        'title',
        'slug',
        'summary',
        'body',
        'status',
    );

    protected $appends = ['status', 'title', 'thumb'];

    /**
     * Columns that are file.
     *
     * @var array
     */
    public $attachments = array(
        'image',
    );
}
