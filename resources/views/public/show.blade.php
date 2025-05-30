@extends('core::public.master')

@section('title', $model->title . ' – ' . __('Places') . ' – ' . $websiteTitle)
@section('ogTitle', $model->title)
@section('description', $model->summary)
@section('ogImage', $model->present()->ogImage())
@section('bodyClass', 'body-places body-place-' . $model->id . ' body-page body-page-' . $page->id)

@push('js')
    <script src="{{ asset('//maps.googleapis.com/maps/api/js?key=' . config('services.gmaps.key') . '&callback=initMap&language=' . app()->getLocale()) }}" defer></script>
@endpush

@section('content')
    <article class="place">
        <header class="place-header">
            <div class="place-header-container">
                <div class="place-header-navigator">
                    @include('core::public._items-navigator', ['module' => 'Places', 'model' => $model])
                </div>
                <h1 class="place-title">{{ $model->title }}</h1>
            </div>
        </header>
        <div class="place-body">
            @include('places::public._json-ld', ['place' => $model])
            @if (!empty($model->latitude) && !empty($model->longitude))
                <div class="map" id="map" data-url="{{ route($lang . '::place-json', $model->slug) }}" data-no-button="false"></div>
            @endif

            @if(!empty($model->image))
                <figure class="place-picture">
                    <img class="place-picture-image" src="{{ $model->present()->image(2000) }}" width="{{ $model->image->width }}" height="{{ $model->image->height }}" alt="" />
                    @if(!empty($model->image->description))
                        <figcaption class="place-picture-legend">{{ $model->image->description }}</figcaption>
                    @endif
                </figure>
            @endif

            <div class="place-contact">
                @if(!empty($model->address))
                    <address>{{ $model->address }}</address>
                @endif

                @if(!empty($model->phone))
                    <p class="place-phone">{{ $model->phone }}</p>
                @endif

                @if(!empty($model->email))
                    <p class="place-email"><a href="mailto:{{ $model->email }}">{{ $model->email }}</a></p>
                @endif

                @if(!empty($model->website))
                    <p class="place-website">
                        <a href="{{ $model->website }}">{{ parse_url($model->website, PHP_URL_HOST) }}</a>
                    </p>
                @endif
            </div>
            @if(!empty($model->info))
                <p class="place-info">{!! nl2br($model->info) !!}</p>
            @endif

            @if(!empty($model->summary))
                <p class="place-summary">{!! nl2br($model->summary) !!}</p>
            @endif

            @if(!empty($model->body))
                <div class="rich-content">{!! $model->present()->body !!}</div>
            @endif

            @include('files::public._document-list')
            @include('files::public._image-list')
        </div>
    </article>
@endsection
