@section('js')
    <script src="{{ asset('components/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('//maps.googleapis.com/maps/api/js?language='.config('app.locale')) }}"></script>
    <script src="{{ asset('js/admin/gmaps.js') }}"></script>
@endsection

@include('core::admin._buttons-form')

{!! BootForm::hidden('id') !!}

@include('core::admin._image-fieldset', ['field' => 'image'])

<ul class="nav nav-tabs">
    <li class="active">
        <a href="#tab-main" data-target="#tab-main" data-toggle="tab">@lang('global.Content')</a>
    </li>
    <li>
        <a href="#tab-info" data-target="#tab-info" data-toggle="tab">@lang('global.Info')</a>
    </li>
</ul>

<div class="tab-content">

    {{-- Main tab --}}
    <div class="tab-pane fade in active" id="tab-main">

        @include('core::form._title-and-slug')
        {!! TranslatableBootForm::hidden('status')->value(0) !!}
        {!! TranslatableBootForm::checkbox(trans('validation.attributes.online'), 'status') !!}
        {!! TranslatableBootForm::textarea(trans('validation.attributes.summary'), 'summary')->rows(4) !!}
        {!! TranslatableBootForm::textarea(trans('validation.attributes.body'), 'body')->addClass('ckeditor') !!}

    </div>

    {{-- Info tab --}}
    <div class="tab-pane fade in" id="tab-info">

        {!! BootForm::text(trans('validation.attributes.address'), 'address') !!}

        <div class="row">
            <div class="col-sm-6">
                {!! BootForm::email(trans('validation.attributes.email'), 'email') !!}
            </div>
            <div class="col-sm-6">
                {!! BootForm::text(trans('validation.attributes.website'), 'website') !!}
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6">
                {!! BootForm::text(trans('validation.attributes.phone'), 'phone') !!}
            </div>
            <div class="col-sm-6">
                {!! BootForm::text(trans('validation.attributes.fax'), 'fax') !!}
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6">
                {!! BootForm::text(trans('validation.attributes.latitude'), 'latitude') !!}
            </div>
            <div class="col-sm-6">
                {!! BootForm::text(trans('validation.attributes.longitude'), 'longitude') !!}
            </div>
        </div>

    </div>

</div>
