<?php
namespace TypiCMS\Modules\Places\Composers;

use Illuminate\Contracts\View\View;
use Maatwebsite\Sidebar\SidebarGroup;
use Maatwebsite\Sidebar\SidebarItem;
use TypiCMS\Composers\BaseSidebarViewComposer;

class SidebarViewComposer extends BaseSidebarViewComposer
{
    public function compose(View $view)
    {
        $view->sidebar->group(trans('global.menus.content'), function (SidebarGroup $group) {
            $group->addItem(trans('places::global.name'), function (SidebarItem $item) {
                $item->icon = config('typicms.places.sidebar.icon', 'icon fa fa-fw fa-map-marker');
                $item->weight = config('typicms.places.sidebar.weight');
                $item->route('admin.places.index');
                $item->append('admin.places.create');
                $item->authorize(
                    $this->auth->hasAccess('places.index')
                );
            });
        });
    }
}
