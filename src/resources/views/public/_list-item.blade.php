@include('places::public._json-ld')
<li class="place-list-item" id="item-{{ $place->id }}">
    @if ($place->latitude && $place->longitude)
    <a class="place-list-item-btn-map" href="" title="{{ __('db.Show on map') }}"><i class="fa fa-map-marker"></i><span class="sr-only">{{ __('db.Show on map') }}</span></a>
    @endif
    <a class="place-list-item-link" href="{{ $place->uri() }}" title="@lang('db.More')">
        {{ $place->title }}
    </a>
</li>
