<?php

namespace TypiCMS\Modules\Places\Composers;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Gate;
use Maatwebsite\Sidebar\SidebarGroup;
use Maatwebsite\Sidebar\SidebarItem;

class SidebarViewComposer
{
    public function compose(View $view)
    {
        if (Gate::denies('read places')) {
            return;
        }
        $view->sidebar->group(__('Content'), function (SidebarGroup $group) {
            $group->id = 'content';
            $group->weight = 30;
            $group->addItem(__('Places'), function (SidebarItem $item) {
                $item->id = 'places';
                $item->icon = config('typicms.places.sidebar.icon');
                $item->weight = config('typicms.places.sidebar.weight');
                $item->route('admin::index-places');
                $item->append('admin::create-place');
            });
        });
    }
}
