@extends('pages::public.master')

@section('bodyClass', 'body-places body-places-index body-page body-page-'.$page->id)

@section('js')
    <script src="{{ asset('//maps.googleapis.com/maps/api/js?key='.getenv(GMAPS_API_KEY).'&language='.config('app.locale')) }}"></script>
    <script src="{{ asset('js/public.gmaps.js') }}"></script>
@endsection

@section('content')

    {!! $page->present()->body !!}

    @include('galleries::public._galleries', ['model' => $page])

    <div class="row">

        <div class="col-sm-4">

            <h2>@lang('places::global.Filter')</h2>
            <form method="get" role="form">
                <label for="string" class="sr-only">@lang('places::global.Search')</label>
                <div class="input-group input-group-lg">
                    <input id="string" type="text" name="string" value="{{ request('string') }}" class="form-control input-sm">
                    <span class="input-group-btn">
                        <button type="submit" class="btn btn-sm btn-primary">@lang('places::global.Search')</button>
                    </span>
                </div>
            </form>

            <h3>
            {{ $models->count() }} @choice('places::global.places', $models->count())
            @if(request('string')) @lang('for')
                “{{ request('string') }}”
            @endif
            </h3>

            @if ($models->count())
            @include('places::public._list', ['items' => $models])
            @endif

        </div>

        <div class="col-sm-8">

            <h2>@lang('places::global.Find nearest')</h2>
            <form id="search-nearest" class="hides" method="get" role="form">
                <label for="address" class="sr-only">@lang('places::global.address')</label>
                <div class="input-group input-group-lg">
                    <input class="form-control" id="address" type="text" placeholder="{{ __('places::global.Address') }}" name="address" value="">
                    <span class="input-group-btn">
                        <button type="submit" class="btn btn-sm btn-primary">@lang('places::global.Search')</button>
                    </span>
                </div>
            </form>

            <div id="map" class="map"></div>
        </div>

    </div>

@endsection
