@push('js')
    <script src="{{ asset('components/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('//maps.googleapis.com/maps/api/js?key='.getenv('GMAPS_API_KEY').'&language='.config('app.locale')) }}"></script>
    <script src="{{ asset('js/admin.gmaps.js') }}"></script>
@endpush

@component('core::admin._buttons-form', ['model' => $model])
@endcomponent

{!! BootForm::hidden('id') !!}

@include('files::admin._files-selector')

<ul class="nav nav-tabs">
    <li class="active">
        <a href="#tab-main" data-target="#tab-main" data-toggle="tab">{{ __('Content') }}</a>
    </li>
    <li>
        <a href="#tab-info" data-target="#tab-info" data-toggle="tab">{{ __('Info') }}</a>
    </li>
</ul>

<div class="tab-content">

    {{-- Main tab --}}
    <div class="tab-pane fade in active" id="tab-main">

        @include('core::form._title-and-slug')
        {!! TranslatableBootForm::hidden('status')->value(0) !!}
        {!! TranslatableBootForm::checkbox(__('Published'), 'status') !!}
        {!! TranslatableBootForm::textarea(__('Summary'), 'summary')->rows(4) !!}
        {!! TranslatableBootForm::textarea(__('Body'), 'body')->addClass('ckeditor') !!}

    </div>

    {{-- Info tab --}}
    <div class="tab-pane fade in" id="tab-info">

        {!! BootForm::textarea(__('Address'), 'address')->rows(4) !!}

        <div class="row">
            <div class="col-sm-6">
                {!! BootForm::email(__('Email'), 'email') !!}
            </div>
            <div class="col-sm-6">
                {!! BootForm::text(__('Website'), 'website') !!}
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6">
                {!! BootForm::text(__('Phone'), 'phone') !!}
            </div>
            <div class="col-sm-6">
                {!! BootForm::text(__('Fax'), 'fax') !!}
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6">
                {!! BootForm::text(__('Latitude'), 'latitude') !!}
            </div>
            <div class="col-sm-6">
                {!! BootForm::text(__('Longitude'), 'longitude') !!}
            </div>
        </div>

    </div>

</div>
