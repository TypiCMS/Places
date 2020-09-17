<?php

namespace TypiCMS\Modules\Places\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use TypiCMS\Modules\Core\Facades\TypiCMS;
use TypiCMS\Modules\Places\Http\Controllers\AdminController;
use TypiCMS\Modules\Places\Http\Controllers\ApiController;
use TypiCMS\Modules\Places\Http\Controllers\PublicController;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Define the routes for the application.
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
                            $router->get($uri, $options + ['uses' => [PublicController::class, 'index']])->name($lang.'::index-places');
                            $router->get($lang.'/places-json', $options + ['uses' => [PublicController::class, 'json']]);
                            $router->get($lang.'/places-json/{id}', $options + ['uses' => [PublicController::class, 'jsonItem']]);
                            $router->get($uri.'/{slug}', $options + ['uses' => [PublicController::class, 'show']])->name($lang.'::place');
                        }
                    }
                });
            }

            /*
             * Admin routes
             */
            $router->middleware('admin')->prefix('admin')->group(function (Router $router) {
                $router->get('places', [AdminController::class, 'index'])->name('admin::index-places')->middleware('can:read places');
                $router->get('places/create', [AdminController::class, 'create'])->name('admin::create-place')->middleware('can:create places');
                $router->get('places/{place}/edit', [AdminController::class, 'edit'])->name('admin::edit-place')->middleware('can:update places');
                $router->post('places', [AdminController::class, 'store'])->name('admin::store-place')->middleware('can:create places');
                $router->put('places/{place}', [AdminController::class, 'update'])->name('admin::update-place')->middleware('can:update places');
            });

            /*
             * API routes
             */
            $router->middleware('api')->prefix('api')->group(function (Router $router) {
                $router->middleware('auth:api')->group(function (Router $router) {
                    $router->get('places', [ApiController::class, 'index'])->middleware('can:read places');
                    $router->patch('places/{place}', [ApiController::class, 'updatePartial'])->middleware('can:update places');
                    $router->delete('places/{place}', [ApiController::class, 'destroy'])->middleware('can:delete places');
                });
            });
        });
    }
}
