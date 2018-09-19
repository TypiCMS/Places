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
        Route::namespace($this->namespace)->group(function (Router $router) {

            /*
             * Front office routes
             */
            if ($page = TypiCMS::getPageLinkedToModule('places')) {
                $router->middleware('public')->group(function (Router $router) use ($page) {
                    $options = $page->private ? ['middleware' => 'auth'] : [];
                    foreach (locales() as $lang) {
                        if ($page->translate('status', $lang) && $uri = $page->uri($lang)) {
                            $router->get($uri, $options + ['uses' => 'PublicController@index'])->name($lang.'::index-places');
                            $router->get($uri.'/{slug}', $options + ['uses' => 'PublicController@show'])->name($lang.'::place');
                        }
                    }
                });
            }

            /*
             * Admin routes
             */
            $router->middleware('admin')->prefix('admin')->group(function (Router $router) {
                $router->get('places', 'AdminController@index')->name('admin::index-places')->middleware('can:see-all-places');
                $router->get('places/create', 'AdminController@create')->name('admin::create-place')->middleware('can:create-place');
                $router->get('places/{place}/edit', 'AdminController@edit')->name('admin::edit-place')->middleware('can:update-place');
                $router->post('places', 'AdminController@store')->name('admin::store-place')->middleware('can:create-place');
                $router->put('places/{place}', 'AdminController@update')->name('admin::update-place')->middleware('can:update-place');
            });

            /*
             * API routes
             */
            $router->middleware('api')->prefix('api')->group(function (Router $router) {
                $router->middleware('auth:api')->group(function (Router $router) {
                    $router->get('places', 'ApiController@index')->name('api::index-places')->middleware('can:see-all-places');
                    $router->get('places/{place}/files', 'ApiController@files')->name('api::edit-place-files')->middleware('can:update-place');
                    $router->patch('places/{place}', 'ApiController@updatePartial')->name('api::update-place')->middleware('can:update-place');
                    $router->delete('places/{place}', 'ApiController@destroy')->name('api::destroy-place')->middleware('can:delete-place');
                });
            });
        });
    }
}
