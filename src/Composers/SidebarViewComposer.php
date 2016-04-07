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
        $view->sidebar->group(trans('global.menus.content'), function (SidebarGroup $group) {
            $group->addItem(trans('places::global.name'), function (SidebarItem $item) {
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
