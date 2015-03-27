<li id="item-{{ $place->id }}">
    @if ($place->latitude && $place->longitude)
    <a class="btn-map" href="" title="{{ trans('db.Show on map') }}"><i class="fa fa-map-marker"></i><span class="sr-only">{{ trans('db.Show on map') }}</span></a>
    @endif
    <a href="{{ route($lang.'.places.slug', array($place->slug)) }}" title="{{ trans('db.More') }}">
        {{ $place->title }}
    </a>
</li>
