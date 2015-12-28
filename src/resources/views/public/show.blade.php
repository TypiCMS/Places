@extends('core::public.master')

@section('title', $model->title . ' – ' . trans('news::global.name') . ' – ' . $websiteTitle)
@section('ogTitle', $model->title)
@section('description', $model->summary)
@section('image', $model->present()->thumbUrl())
@section('bodyClass', 'body-places body-place-' . $model->id . ' body-page body-page-' . $page->id)

@section('js')
    <script src="{{ asset('//maps.googleapis.com/maps/api/js?language='.config('app.locale')) }}"></script>
    <script src="{{ asset('js/public/gmaps.js') }}"></script>
@stop

@section('main')

    <div class="row">
        <div class="col-sm-4">
            <h3>{{ $model->title }}</h3>

            {!! $model->present()->thumb(540, 400) !!}

            <p id="place" data-id="{{ $model->id }}">
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
            <p>
                @if ($model->info)
                    {{ nl2br($model->info) }}
                @endif
            </p>
            <p class="summary">{{ nl2br($model->summary) }}</p>
            <div class="body">{!! $model->present()->body !!}</div>
        </div>
        <div class="col-sm-8">
            @if($model->latitude && $model->longitude)
                <div id="map" class="map map-fancybox"></div>
            @endif
        </div>
    </div>

@stop
