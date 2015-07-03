<?php
namespace TypiCMS\Modules\Places\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use TypiCMS\Modules\Core\Facades\TypiCMS;
use TypiCMS\Modules\Core\Observers\FileObserver;
use TypiCMS\Modules\Core\Observers\SlugObserver;
use TypiCMS\Modules\Core\Services\Cache\LaravelCache;
use TypiCMS\Modules\Places\Models\Place;
use TypiCMS\Modules\Places\Models\PlaceTranslation;
use TypiCMS\Modules\Places\Repositories\CacheDecorator;
use TypiCMS\Modules\Places\Repositories\EloquentPlace;

class ModuleProvider extends ServiceProvider
{

    public function boot()
    {

        $this->mergeConfigFrom(
            __DIR__ . '/../config/config.php', 'typicms.places'
        );

        $modules = $this->app['config']['typicms']['modules'];
        $this->app['config']->set('typicms.modules', array_merge(['places' => ['linkable_to_page']], $modules));

        $this->loadViewsFrom(__DIR__ . '/../resources/views/', 'places');
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'places');

        $this->publishes([
            __DIR__ . '/../resources/views' => base_path('resources/views/vendor/places'),
        ], 'views');
        $this->publishes([
            __DIR__ . '/../database' => base_path('database'),
        ], 'migrations');
        $this->publishes([
            __DIR__ . '/../../resources/assets' => public_path(),
        ], 'scripts');

        AliasLoader::getInstance()->alias(
            'Places',
            'TypiCMS\Modules\Places\Facades\Facade'
        );

        // Observers
        PlaceTranslation::observe(new SlugObserver);
        Place::observe(new FileObserver);
    }

    public function register()
    {

        $app = $this->app;

        /**
         * Register route service provider
         */
        $app->register('TypiCMS\Modules\Places\Providers\RouteServiceProvider');

        /**
         * Sidebar view composer
         */
        $app->view->composer('core::admin._sidebar', 'TypiCMS\Modules\Places\Composers\SidebarViewComposer');

        $app->bind('TypiCMS\Modules\Places\Repositories\PlaceInterface', function (Application $app) {
            $repository = new EloquentPlace(new Place);
            if (! config('typicms.cache')) {
                return $repository;
            }
            $laravelCache = new LaravelCache($app['cache'], 'places', 10);

            return new CacheDecorator($repository, $laravelCache);
        });

        /**
         * Return the page linked to this module (for @inject in views)
         */
        $app->singleton('typicms.places.page', function (Application $app) {
            return TypiCMS::getPageLinkedToModule('places');
        });

    }
}
