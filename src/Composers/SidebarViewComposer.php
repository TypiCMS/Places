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
        $view->sidebar->group(__('global.menus.content'), function (SidebarGroup $group) {
            $group->addItem(__('places::global.name'), function (SidebarItem $item) {
                $item->id = 'places';
                $item->icon = config('typicms.places.sidebar.icon', 'icon fa fa-fw fa-map-marker');
                $item->weight = config('typicms.places.sidebar.weight');
                $item->route('admin::index-places');
                $item->append('admin::create-place');
                $item->authorize(
                    Gate::allows('index-places')
                );
            });
        });
    }
}
