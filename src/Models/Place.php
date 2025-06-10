<?php

namespace TypiCMS\Modules\Places\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Route;
use Laracasts\Presenter\PresentableTrait;
use Spatie\Translatable\HasTranslations;
use TypiCMS\Modules\Core\Models\Base;
use TypiCMS\Modules\Core\Models\File;
use TypiCMS\Modules\Core\Models\History;
use TypiCMS\Modules\Core\Traits\HasFiles;
use TypiCMS\Modules\Core\Traits\Historable;
use TypiCMS\Modules\Places\Presenters\ModulePresenter;

/**
 * @property int $id
 * @property string|null $address
 * @property string|null $email
 * @property string|null $phone
 * @property string|null $website
 * @property int|null $og_image_id
 * @property int|null $image_id
 * @property string|null $latitude
 * @property string|null $longitude
 * @property string $status
 * @property string $title
 * @property string $slug
 * @property string $summary
 * @property string $body
 * @property string $url
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection<int, File> $audios
 * @property-read int|null $audios_count
 * @property-read Collection<int, File> $documents
 * @property-read int|null $documents_count
 * @property-read Collection<int, File> $files
 * @property-read int|null $files_count
 * @property-read Collection<int, History> $history
 * @property-read int|null $history_count
 * @property-read File|null $image
 * @property-read Collection<int, File> $images
 * @property-read int|null $images_count
 * @property-read File|null $ogImage
 * @property-read mixed $thumb
 * @property-read mixed $translations
 * @property-read Collection<int, File> $videos
 * @property-read int|null $videos_count
 */
class Place extends Base
{
    use HasFiles;
    use HasTranslations;
    use Historable;
    use PresentableTrait;

    protected string $presenter = ModulePresenter::class;

    protected $guarded = [];

    protected $appends = ['thumb'];

    public array $translatable = [
        'title',
        'slug',
        'summary',
        'body',
        'status',
    ];

    public function url($locale = null): string
    {
        $locale = $locale ?: app()->getLocale();
        $route = $locale . '::place';
        $slug = $this->translate('slug', $locale) ?: null;

        return Route::has($route) && $slug ? url(route($route, $slug)) : url('/');
    }

    /**
     * @return Attribute<string, null>
     */
    protected function thumb(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->present()->image(null, 54),
        );
    }

    /** @return BelongsTo<File, $this> */
    public function image(): BelongsTo
    {
        return $this->belongsTo(File::class, 'image_id');
    }

    /** @return BelongsTo<File, $this> */
    public function ogImage(): BelongsTo
    {
        return $this->belongsTo(File::class, 'og_image_id');
    }
}
