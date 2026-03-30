<?php

declare(strict_types=1);

namespace TypiCMS\Modules\Places\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use TypiCMS\Modules\Places\Composers\SidebarViewComposer;

class ModuleServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/places.php', 'typicms.modules.places');

        $this->loadRoutesFrom(__DIR__.'/../routes/places.php');

        $this->loadViewsFrom(__DIR__.'/../../resources/views/', 'places');

        $this->publishes([
            __DIR__.'/../../database/migrations/create_places_table.php.stub' => getMigrationFileName(
                'create_places_table',
            ),
        ], 'typicms-migrations');
        $this->publishes([__DIR__.'/../../resources/views' => resource_path('views/vendor/places')], 'typicms-views');
        $this->publishes([__DIR__.'/../../resources' => resource_path()], 'typicms-resources');
        $this->publishes([__DIR__.'/../../public' => public_path()], 'typicms-public');

        View::composer('core::admin._sidebar', SidebarViewComposer::class);

        /*
         * Add the page in the view.
         */
        View::composer('places::public.*', function ($view): void {
            $view->page = getPageLinkedToModule('places');
        });
    }
}
