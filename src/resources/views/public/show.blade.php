@extends('core::public.master')

@section('title', $model->title.' – '.__('Places').' – '.$websiteTitle)
@section('ogTitle', $model->title)
@section('description', $model->summary)
@section('image', $model->present()->image())
@section('bodyClass', 'body-places body-place-'.$model->id.' body-page body-page-'.$page->id)

@push('js')
    <script src="{{ asset('//maps.googleapis.com/maps/api/js?key='.getenv('GMAPS_API_KEY').'&language='.config('app.locale')) }}"></script>
    <script src="{{ asset('js/public.gmaps.js') }}"></script>
@endpush

@section('content')

    @include('places::public._json-ld', ['place' => $model])

    <div class="place">
        <h1 class="place-title">{{ $model->title }}</h1>
        @if ($model->latitude && $model->longitude)
        <div class="place-map" id="map" data-url="/{{ $lang }}/places-json/{{ $model->id }}" style="height: 500px"></div>
        @endif
        <img class="place-image" src="{!! $model->present()->image(540, 400) !!}" alt="">
        <p class="place-contact" id="place" data-id="{{ $model->id }}">
            @if ($model->address)
                {{ $model->address }}<br>
            @endif
            @if ($model->phone)
                {{ $model->phone }}<br>
            @endif
            @if ($model->email)
                <a href="mailto:{{ $model->email }}">{{ $model->email }}</a><br>
            @endif
            @if ($model->website)
                <a href="{{ $model->website }}">{{ $model->website }}</a><br>
            @endif
        </p>
        <p class="place-info">
            @if ($model->info)
                {{ nl2br($model->info) }}
            @endif
        </p>
        <p class="place-summary">{{ nl2br($model->summary) }}</p>
        <div class="place-body">{!! $model->present()->body !!}</div>
        @include('files::public._documents')
        @include('files::public._images')
    </div>

@endsection
