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
            $router->get('admin/places', 'AdminController@index')->name('admin::index-places');
            $router->get('admin/places/create', 'AdminController@create')->name('admin::create-place');
            $router->get('admin/places/{place}/edit', 'AdminController@edit')->name('admin::edit-place');
            $router->post('admin/places', 'AdminController@store')->name('admin::store-place');
            $router->put('admin/places/{place}', 'AdminController@update')->name('admin::update-place');

            /*
             * API routes
             */
            $router->get('api/places', 'ApiController@index')->name('api::index-places');
            $router->put('api/places/{place}', 'ApiController@update')->name('api::update-place');
            $router->delete('api/places/{place}', 'ApiController@destroy')->name('api::destroy-place');
        });
    }
}
