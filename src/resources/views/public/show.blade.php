@extends('core::public.master')

@section('title', $model->title.' – '.__('Places').' – '.$websiteTitle)
@section('ogTitle', $model->title)
@section('description', $model->summary)
@section('image', $model->present()->thumbUrl())
@section('bodyClass', 'body-places body-place-'.$model->id.' body-page body-page-'.$page->id)

@section('js')
    <script src="{{ asset('//maps.googleapis.com/maps/api/js?key='.getenv('GMAPS_API_KEY').'&language='.config('app.locale')) }}"></script>
    <script src="{{ asset('js/public.gmaps.js') }}"></script>
@endsection

@section('content')

    <div class="place">
        <h1 class="place-title">{{ $model->title }}</h1>
        @if ($model->latitude && $model->longitude)
            <div class="place-map" id="map" style="height: 500px"></div>
        @endif
        {!! $model->present()->thumb(540, 400) !!}
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
    </div>

@endsection
