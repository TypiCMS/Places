<?php
namespace TypiCMS\Modules\Places\Composers;

use Illuminate\View\View;

class SidebarViewComposer
{
    public function compose(View $view)
    {
        $view->menus['content']->put('places', [
            'weight' => config('typicms.places.sidebar.weight'),
            'request' => $view->prefix . '/places*',
            'route' => 'admin.places.index',
            'icon-class' => 'icon fa fa-fw fa-map-marker',
            'title' => 'Places',
        ]);
    }
}
