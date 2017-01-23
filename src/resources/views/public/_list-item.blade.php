<li class="places-item" id="item-{{ $place->id }}">
    @if ($place->latitude && $place->longitude)
    <a class="places-item-btn-map" href="" title="{{ __('db.Show on map') }}"><i class="fa fa-map-marker"></i><span class="sr-only">{{ __('db.Show on map') }}</span></a>
    @endif
    <a class="places-item-link" href="{{ route($lang.'::place', array($place->slug)) }}" title="@lang('db.More')">
        {{ $place->title }}
    </a>
</li>
