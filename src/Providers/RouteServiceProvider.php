<?php

namespace TypiCMS\Modules\Places\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Routing\Router;
use TypiCMS\Modules\Core\Facades\TypiCMS;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to the controller routes in your routes file.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'TypiCMS\Modules\Places\Http\Controllers';

    /**
     * Define the routes for the application.
     *
     * @param \Illuminate\Routing\Router $router
     *
     * @return void
     */
    public function map(Router $router)
    {
        $router->group(['namespace' => $this->namespace], function (Router $router) {

            /*
             * Front office routes
             */
            if ($page = TypiCMS::getPageLinkedToModule('places')) {
                $options = $page->private ? ['middleware' => 'auth'] : [];
                foreach (config('translatable.locales') as $lang) {
                    if ($page->translate($lang)->status && $uri = $page->uri($lang)) {
                        $router->get($uri, $options + ['as' => $lang.'.places', 'uses' => 'PublicController@index']);
                        $router->get($uri.'/{slug}', $options + ['as' => $lang.'.places.slug', 'uses' => 'PublicController@show']);
                    }
                }
            }

            /*
             * Admin routes
             */
            $router->get('admin/places', ['as' => 'admin.places.index', 'uses' => 'AdminController@index']);
            $router->get('admin/places/create', ['as' => 'admin.places.create', 'uses' => 'AdminController@create']);
            $router->get('admin/places/{place}/edit', ['as' => 'admin.places.edit', 'uses' => 'AdminController@edit']);
            $router->post('admin/places', ['as' => 'admin.places.store', 'uses' => 'AdminController@store']);
            $router->put('admin/places/{place}', ['as' => 'admin.places.update', 'uses' => 'AdminController@update']);

            /*
             * API routes
             */
            $router->get('api/places', ['as' => 'api.places.index', 'uses' => 'ApiController@index']);
            $router->put('api/places/{place}', ['as' => 'api.places.update', 'uses' => 'ApiController@update']);
            $router->delete('api/places/{place}', ['as' => 'api.places.destroy', 'uses' => 'ApiController@destroy']);
        });
    }
}
