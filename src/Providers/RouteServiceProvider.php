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
    public function map(): void
    {
        /*
         * Front office routes
         */
        if ($page = TypiCMS::getPageLinkedToModule('places')) {
            $middleware = $page->private ? ['public', 'auth'] : ['public'];
            foreach (locales() as $lang) {
                if ($page->isPublished($lang) && $uri = $page->uri($lang)) {
                    Route::middleware($middleware)->prefix($uri)->name($lang.'::')->group(function (Router $router) {
                        $router->get('/', [PublicController::class, 'index'])->name('index-places');
                        $router->get('places-json', [PublicController::class, 'json']);
                        $router->get('places-json/{id}', [PublicController::class, 'jsonItem']);
                        $router->get('{slug}', [PublicController::class, 'show'])->name('place');
                    });
                }
            }
        }

        /*
         * Admin routes
         */
        Route::middleware('admin')->prefix('admin')->name('admin::')->group(function (Router $router) {
            $router->get('places', [AdminController::class, 'index'])->name('index-places')->middleware('can:read places');
            $router->get('places/export', [AdminController::class, 'export'])->name('export-places')->middleware('can:read places');
            $router->get('places/create', [AdminController::class, 'create'])->name('create-place')->middleware('can:create places');
            $router->get('places/{place}/edit', [AdminController::class, 'edit'])->name('edit-place')->middleware('can:read places');
            $router->post('places', [AdminController::class, 'store'])->name('store-place')->middleware('can:create places');
            $router->put('places/{place}', [AdminController::class, 'update'])->name('update-place')->middleware('can:update places');
        });

        /*
         * API routes
         */
        Route::middleware(['api', 'auth:api'])->prefix('api')->group(function (Router $router) {
            $router->get('places', [ApiController::class, 'index'])->middleware('can:read places');
            $router->patch('places/{place}', [ApiController::class, 'updatePartial'])->middleware('can:update places');
            $router->delete('places/{place}', [ApiController::class, 'destroy'])->middleware('can:delete places');
        });
    }
}
