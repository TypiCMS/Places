<?php
namespace TypiCMS\Modules\Places\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Routing\Router;
use TypiCMS\Facades\TypiCMS;

class RouteServiceProvider extends ServiceProvider {

    /**
     * This namespace is applied to the controller routes in your routes file.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'TypiCMS\Modules\Places\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    public function boot(Router $router)
    {
        parent::boot($router);

        $router->model('places', 'TypiCMS\Modules\Places\Models\Place');
    }

    /**
     * Define the routes for the application.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    public function map(Router $router)
    {
        $router->group(['namespace' => $this->namespace], function($router) {

            /**
             * Front office routes
             */
            if ($page = TypiCMS::getPageLinkedToModule('places')) {
                foreach (config('translatable.locales') as $lang) {
                    if ($page->hasTranslation($lang)) {
                        $uri = $page->translate($lang)->uri;
                        $router->get($uri, ['as' => $lang.'.places', 'uses' => 'PublicController@index']);
                        $router->get($uri.'/{slug}', ['as' => $lang.'.places.slug', 'uses' => 'PublicController@show']);
                    }
                }
            }

            /**
             * Admin routes
             */
            $router->resource('admin/places', 'AdminController');

            /**
             * API routes
             */
            $router->resource('api/places', 'ApiController');
        });
    }

}
