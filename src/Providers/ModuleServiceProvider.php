<?php

namespace TypiCMS\Modules\Places\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use TypiCMS\Modules\Core\Facades\TypiCMS;
use TypiCMS\Modules\Core\Observers\SlugObserver;
use TypiCMS\Modules\Places\Composers\SidebarViewComposer;
use TypiCMS\Modules\Places\Facades\Places;
use TypiCMS\Modules\Places\Models\Place;

class ModuleServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'typicms.places');
        $this->mergeConfigFrom(__DIR__.'/../config/permissions.php', 'typicms.permissions');

        config(['typicms.modules.places' => ['linkable_to_page']]);

        $this->loadViewsFrom(__DIR__.'/../../resources/views/', 'places');

        $this->publishes([
            __DIR__.'/../../database/migrations/create_places_table.php.stub' => getMigrationFileName('create_places_table'),
        ], 'migrations');

        $this->publishes([
            __DIR__.'/../../resources/views' => resource_path('views/vendor/places'),
        ], 'views');

        $this->publishes([
            __DIR__.'/../../resources/scss' => resource_path('scss'),
        ], 'resources');

        $this->publishes([
            __DIR__.'/../../public/js' => public_path('js'),
        ], 'public');

        AliasLoader::getInstance()->alias('Places', Places::class);

        // Observers
        Place::observe(new SlugObserver());

        View::composer('core::admin._sidebar', SidebarViewComposer::class);

        /*
         * Add the page in the view.
         */
        View::composer('places::public.*', function ($view) {
            $view->page = TypiCMS::getPageLinkedToModule('places');
        });
    }

    public function register(): void
    {
        $this->app->register(RouteServiceProvider::class);

        $this->app->bind('Places', Place::class);
    }
}
