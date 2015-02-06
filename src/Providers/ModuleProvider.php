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
use TypiCMS\Modules\Places\Services\Form\PlaceForm;
use TypiCMS\Modules\Places\Services\Form\PlaceFormLaravelValidator;
use TypiCMS\Observers\FileObserver;
use TypiCMS\Observers\SlugObserver;
use TypiCMS\Services\Cache\LaravelCache;
use View;

class ModuleProvider extends ServiceProvider
{

    public function boot()
    {
        // Bring in the routes
        require __DIR__ . '/../routes.php';

        // Add dirs
        View::addNamespace('places', __DIR__ . '/../views/');
        $this->loadTranslationsFrom(__DIR__ . '/../lang', 'places');
        $this->publishes([
            __DIR__ . '/../config/' => config_path('typicms/places'),
        ], 'config');
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

        $app->bind('TypiCMS\Modules\Places\Services\Form\PlaceForm', function (Application $app) {
            return new PlaceForm(
                new PlaceFormLaravelValidator($app['validator']),
                $app->make('TypiCMS\Modules\Places\Repositories\PlaceInterface')
            );
        });

    }
}
