@extends('pages::public.master')

@section('bodyClass', 'body-places body-places-index body-page body-page-'.$page->id)

@push('js')
    <script src="{{ asset('//maps.googleapis.com/maps/api/js?key='.config('services.gmaps.key').'&language='.config('app.locale')) }}"></script>
    <script src="{{ asset('js/oms.min.js') }}"></script>
    <script src="{{ asset('js/public.gmaps.js') }}"></script>
@endpush

@section('content')

    <div class="rich-content">{!! $page->present()->body !!}</div>

    @include('files::public._documents', ['model' => $page])
    @include('files::public._images', ['model' => $page])

    @include('places::public._itemlist-json-ld', ['items' => $models])

    <div id="map" class="map" data-url="/{{ $lang }}/places-json" data-button-label="@lang('Read more')"></div>

    @includeWhen($models->count() > 0, 'places::public._list', ['items' => $models])

@endsection
