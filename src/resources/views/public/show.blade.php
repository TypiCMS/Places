@extends('core::public.master')

@section('title', $model->title.' – '.__('Places').' – '.$websiteTitle)
@section('ogTitle', $model->title)
@section('description', $model->summary)
@section('image', $model->present()->image())
@section('bodyClass', 'body-places body-place-'.$model->id.' body-page body-page-'.$page->id)

@push('js')
    <script src="{{ asset('//maps.googleapis.com/maps/api/js?key='.config('services.gmaps.key').'&language='.config('app.locale')) }}"></script>
    <script src="{{ asset('js/oms.min.js') }}"></script>
    <script src="{{ asset('js/public.gmaps.js') }}"></script>
@endpush

@section('content')

    @include('places::public._json-ld', ['place' => $model])

    <div class="place">
        <h1 class="place-title">{{ $model->title }}</h1>
        @isset($model->latitude, $model->longitude)
        <div class="place-map" id="map" data-url="/{{ $lang }}/places-json/{{ $model->id }}" style="height: 500px"></div>
        @endisset
        @isset($model->image)
        <img class="place-image" src="{!! $model->present()->image(null, 1000) !!}" alt="">
        @endisset
        <div class="place-contact">
            @isset($model->address)
            <address>{{ $model->address }}</address>
            @endif
            @isset($model->phone)
            <p class="place-phone">{{ $model->phone }}</p>
            @endif
            @isset($model->email)
            <p class="place-email"><a href="mailto:{{ $model->email }}">{{ $model->email }}</a></p>
            @endif
            @isset($model->website)
            <p class="place-website"><a href="{{ $model->website }}">{{ parse_url($model->website, PHP_URL_HOST) }}</a></p>
            @endif
        </div>
        @isset($model->info)
        <p class="place-info">{!! nl2br($model->info) !!}</p>
        @endisset
        @isset($model->summary)
        <p class="place-summary">{!! nl2br($model->summary) !!}</p>
        @endisset
        @isset($model->body)
        <div class="place-body">{!! $model->present()->body !!}</div>
        @endisset
        @include('files::public._documents')
        @include('files::public._images')
    </div>

@endsection
