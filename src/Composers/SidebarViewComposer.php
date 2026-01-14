<?php

declare(strict_types=1);

namespace TypiCMS\Modules\Places\Composers;

use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;
use TypiCMS\Modules\Sidebar\SidebarGroup;
use TypiCMS\Modules\Sidebar\SidebarItem;

class SidebarViewComposer
{
    public function compose(View $view): void
    {
        if (Gate::denies('read places')) {
            return;
        }

        $view->offsetGet('sidebar')->group(
            __(config('typicms.modules.places.sidebar.group', 'Content')),
            function (SidebarGroup $group): void {
                $group->id = 'content';
                $group->weight = 30;
                $group->addItem(
                    __(config('typicms.modules.places.sidebar.label', 'Places')),
                    function (SidebarItem $item): void {
                        $item->id = 'places';
                        $item->icon = config('typicms.modules.places.sidebar.icon');
                        $item->weight = config('typicms.modules.places.sidebar.weight');
                        $item->route('admin::index-places');
                    },
                );
            },
        );
    }
}
