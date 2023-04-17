@extends('pages::public.master')

@section('bodyClass', 'body-places body-places-index body-page body-page-'.$page->id)

@push('js')
    <script src="{{ asset('//maps.googleapis.com/maps/api/js?key='.config('services.gmaps.key').'&language='.config('app.locale')) }}"></script>
    <script src="{{ asset('js/oms.min.js') }}"></script>
    <script src="{{ asset('js/public.gmaps.js') }}"></script>
@endpush

@section('page')

    <div class="page-body">

        <div class="page-body-container">

            <div class="rich-content">{!! $page->present()->body !!}</div>

            @include('files::public._document-list', ['model' => $page])
            @include('files::public._image-list', ['model' => $page])

            @include('places::public._itemlist-json-ld', ['items' => $models])

        </div>

        <div id="map" class="map" data-url="{{ url($page->uri().'/places-json') }}" data-button-label="@lang('Read more')"></div>

        <div class="page-body-container">

            @includeWhen($models->count() > 0, 'places::public._list', ['items' => $models])

        </div>

    </div>

@endsection
