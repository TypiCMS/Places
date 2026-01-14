<?php

declare(strict_types=1);

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use TypiCMS\Modules\Core\Models\Page;
use TypiCMS\Modules\Places\Http\Controllers\AdminController;
use TypiCMS\Modules\Places\Http\Controllers\ApiController;
use TypiCMS\Modules\Places\Http\Controllers\JsonController;
use TypiCMS\Modules\Places\Http\Controllers\PublicController;

/*
 * Front office routes
 */
if (($page = getPageLinkedToModule('places')) instanceof Page) {
    $middleware = $page->private ? ['public', 'auth'] : ['public'];
    foreach (locales() as $lang) {
        if ($page->isPublished($lang) && ($path = $page->path($lang))) {
            Route::middleware($middleware)
                ->prefix($path)
                ->name($lang . '::')
                ->group(function (Router $router): void {
                    $router->get('/', [PublicController::class, 'index'])->name('index-places');
                    $router->get('places-json', [JsonController::class, 'index'])->name('places-json');
                    $router->get('{place}', [PublicController::class, 'show'])->name('place');
                    $router->get('{place}/json', [JsonController::class, 'show'])->name('place-json');
                });
        }
    }
}

/*
 * Admin routes
 */
Route::middleware('admin')
    ->prefix('admin')
    ->name('admin::')
    ->group(function (Router $router): void {
        $router->get('places', [AdminController::class, 'index'])->name('index-places')->middleware('can:read places');
        $router
            ->get('places/export', [AdminController::class, 'export'])
            ->name('export-places')
            ->middleware('can:read places');
        $router
            ->get('places/create', [AdminController::class, 'create'])
            ->name('create-place')
            ->middleware('can:create places');
        $router
            ->get('places/{place}/edit', [AdminController::class, 'edit'])
            ->name('edit-place')
            ->middleware('can:read places');
        $router
            ->post('places', [AdminController::class, 'store'])
            ->name('store-place')
            ->middleware('can:create places');
        $router
            ->put('places/{place}', [AdminController::class, 'update'])
            ->name('update-place')
            ->middleware('can:update places');
    });

/*
 * API routes
 */
Route::middleware(['api', 'auth:api'])->prefix('api')->group(function (Router $router): void {
    $router->get('places', [ApiController::class, 'index'])->middleware('can:read places');
    $router->patch('places/{place}', [ApiController::class, 'updatePartial'])->middleware('can:update places');
    $router->delete('places/{place}', [ApiController::class, 'destroy'])->middleware('can:delete places');
});
