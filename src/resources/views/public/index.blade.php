@extends('pages::public.master')

@section('bodyClass', 'body-places body-places-index body-page body-page-'.$page->id)

@push('js')
    <script src="{{ asset('//maps.googleapis.com/maps/api/js?key='.config('services.gmaps.key').'&language='.config('app.locale')) }}"></script>
    <script src="{{ asset('js/oms.min.js') }}"></script>
    <script src="{{ asset('js/public.gmaps.js') }}"></script>
@endpush

@section('content')

    {!! $page->present()->body !!}

    @include('files::public._documents', ['model' => $page])
    @include('files::public._images', ['model' => $page])

    @include('places::public._itemlist-json-ld', ['items' => $models])

    <div class="row">

        <div class="col-sm-4">

            <h3>
            {{ $models->count() }} @lang('Places')
            @if (request('string')) @lang('for')
                “{{ request('string') }}”
            @endif
            </h3>

            @includeWhen($models->count() > 0, 'places::public._list', ['items' => $models])

        </div>

        <div class="col-sm-8">

            <h2>@lang('Find nearest')</h2>
            <form id="search-nearest" class="hides" method="get" role="form">
                <label for="address" class="sr-only">@lang('address')</label>
                <div class="input-group input-group-lg">
                    <input class="form-control" id="address" type="text" placeholder="{{ __('Address') }}" name="address" value="">
                    <span class="input-group-append">
                        <button type="submit" class="btn btn-sm btn-primary">@lang('Search')</button>
                    </span>
                </div>
            </form>

            <div id="map" class="map" data-url="/{{ $lang }}/places-json"></div>
        </div>

    </div>

@endsection
