@extends('pages::public.master')

@section('bodyClass', 'body-places body-places-index body-page body-page-'.$page->id)

@push('js')
    <script src="{{ asset('//maps.googleapis.com/maps/api/js?key='.getenv('GMAPS_API_KEY').'&language='.config('app.locale')) }}"></script>
    <script src="{{ asset('js/public.gmaps.js') }}"></script>
@endpush

@section('content')

    {!! $page->present()->body !!}

    @include('files::public._files', ['model' => $page])

    <div class="row">

        <div class="col-sm-4">

            <h2>@lang('Filter')</h2>
            <form method="get" role="form">
                <label for="string" class="sr-only">@lang('Search')</label>
                <div class="input-group input-group-lg">
                    <input id="string" type="text" name="string" value="{{ request('string') }}" class="form-control form-control-sm">
                    <span class="input-group-append">
                        <button type="submit" class="btn btn-sm btn-primary">@lang('Search')</button>
                    </span>
                </div>
            </form>

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

            <div id="map" class="map"></div>
        </div>

    </div>

@endsection
