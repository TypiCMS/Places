<?php

namespace TypiCMS\Modules\Places\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use TypiCMS\Modules\Core\Facades\TypiCMS;
use TypiCMS\Modules\Places\Composers\SidebarViewComposer;
use TypiCMS\Modules\Places\Facades\Places;
use TypiCMS\Modules\Places\Models\Place;

class ModuleServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/places.php', 'typicms.modules.places');

        $this->loadRoutesFrom(__DIR__ . '/../routes/places.php');

        $this->loadViewsFrom(__DIR__ . '/../../resources/views/', 'places');

        $this->publishes([__DIR__ . '/../../database/migrations/create_places_table.php.stub' => getMigrationFileName('create_places_table')], 'typicms-migrations');
        $this->publishes([__DIR__ . '/../../resources/views' => resource_path('views/vendor/places')], 'typicms-views');
        $this->publishes([__DIR__ . '/../../resources' => resource_path()], 'typicms-resources');
        $this->publishes([__DIR__ . '/../../public' => public_path()], 'typicms-public');

        AliasLoader::getInstance()->alias('Places', Places::class);

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
        $this->app->bind('Places', Place::class);
    }
}
