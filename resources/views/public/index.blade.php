@extends('pages::public.master')

@section('bodyClass', 'body-places body-places-index body-page body-page-' . $page->id)

@push('js')
    <script src="{{ asset('//maps.googleapis.com/maps/api/js?key=' . config('services.gmaps.key') . '&callback=initMap&language=' . app()->getLocale()) }}" defer></script>
@endpush

@section('page')
    @include('places::public._itemlist-json-ld', ['items' => $models])
    <div class="page-body">
        <div class="page-body-container">
            @include('pages::public._main-content', ['page' => $page])
            @include('files::public._document-list', ['model' => $page])
            @include('files::public._image-list', ['model' => $page])
        </div>

        <div class="map" id="map" data-url="{{ route($lang . '::places-json') }}" data-button-label="@lang('Read more')"></div>

        <div class="page-body-container">
            @includeWhen($models->count() > 0, 'places::public._list', ['items' => $models])
        </div>
    </div>
@endsection
