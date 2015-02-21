<?php
namespace TypiCMS\Modules\Places\Providers;

use Config;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use Lang;
use TypiCMS\Modules\Places\Models\Place;
use TypiCMS\Modules\Places\Models\PlaceTranslation;
use TypiCMS\Modules\Places\Repositories\CacheDecorator;
use TypiCMS\Modules\Places\Repositories\EloquentPlace;
use TypiCMS\Observers\FileObserver;
use TypiCMS\Observers\SlugObserver;
use TypiCMS\Services\Cache\LaravelCache;
use View;

class ModuleProvider extends ServiceProvider
{

    public function boot()
    {

        $this->loadViewsFrom(__DIR__ . '/../resources/views/', 'places');
        $this->publishes([
            __DIR__ . '/../views' => base_path('resources/views/vendor/places'),
        ], 'views');
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'places');
        $this->mergeConfigFrom(
            __DIR__ . '/../config/config.php', 'typicms.places'
        );
        $this->publishes([
            __DIR__ . '/../migrations/' => base_path('/database/migrations'),
        ], 'migrations');

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
        $app->view->composer('core::admin._sidebar', 'TypiCMS\Modules\Places\Composers\SideBarViewComposer');

        $app->bind('TypiCMS\Modules\Places\Repositories\PlaceInterface', function (Application $app) {
            $repository = new EloquentPlace(new Place);
            if (! Config::get('app.cache')) {
                return $repository;
            }
            $laravelCache = new LaravelCache($app['cache'], 'places', 10);

            return new CacheDecorator($repository, $laravelCache);
        });

    }
}
