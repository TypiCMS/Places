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
                foreach (locales() as $lang) {
                    if ($page->translate('status', $lang) && $uri = $page->uri($lang)) {
                        $router->get($uri, $options + ['uses' => 'PublicController@index'])->name($lang.'::index-places');
                        $router->get($uri.'/{slug}', $options + ['uses' => 'PublicController@show'])->name($lang.'::place');
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
                $router->patch('places/{ids}', 'AdminController@ajaxUpdate')->name('admin::update-place-ajax');
                $router->delete('places/{ids}', 'AdminController@destroyMultiple')->name('admin::destroy-place');
            });
        });
    }
}
