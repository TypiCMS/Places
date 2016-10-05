<?php

namespace TypiCMS\Modules\Places\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
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
     * @return null
     */
    public function map()
    {
        Route::group(['namespace' => $this->namespace], function (Router $router) {

            /*
             * Front office routes
             */
            if ($page = TypiCMS::getPageLinkedToModule('places')) {
                $options = $page->private ? ['middleware' => 'auth'] : [];
                foreach (config('translatable-bootforms.locales') as $lang) {
                    if ($page->translate('status', $lang) && $uri = $page->uri($lang)) {
                        $router->get($uri, $options + ['as' => $lang.'.places', 'uses' => 'PublicController@index']);
                        $router->get($uri.'/{slug}', $options + ['as' => $lang.'.places.slug', 'uses' => 'PublicController@show']);
                    }
                }
            }

            /*
             * Admin routes
             */
            $router->group(['middleware' => 'admin', 'prefix' => 'admin'], function (Router $router) {
                $router->get('places', 'AdminController@index')->name('admin::index-places');
                $router->get('places/create', 'AdminController@create')->name('admin::create-place');
                $router->get('places/{place}/edit', 'AdminController@edit')->name('admin::edit-place');
                $router->post('places', 'AdminController@store')->name('admin::store-place');
                $router->put('places/{place}', 'AdminController@update')->name('admin::update-place');
                $router->patch('places/{place}', 'AdminController@ajaxUpdate');
                $router->delete('places/{place}', 'AdminController@destroy')->name('admin::destroy-place');
            });
        });
    }
}
