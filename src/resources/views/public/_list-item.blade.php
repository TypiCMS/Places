<li id="item-{{ $place->id }}">
    @if ($place->latitude && $place->longitude)
    <a class="btn-map" href="" title="{{ __('db.Show on map') }}"><i class="fa fa-map-marker"></i><span class="sr-only">{{ __('db.Show on map') }}</span></a>
    @endif
    <a href="{{ route($lang.'::place', array($place->slug)) }}" title="{{ __('db.More') }}">
        {{ $place->title }}
    </a>
</li>
