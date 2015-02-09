@section('js')
    <script src="//tinymce.cachefly.net/4.1/tinymce.min.js"></script>
    <script src="{{ asset('js/admin/form.js') }}"></script>
    <script src="{{ asset('//maps.googleapis.com/maps/api/js?sensor=false&amp;language=fr') }}"></script>
    <script src="{{ asset('js/admin/gmaps.js') }}"></script>
@stop

@section('otherSideLink')
    @include('core::admin._navbar-public-link')
@stop


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

        @include('core::admin._tabs-lang-form', ['target' => 'content'])

        <div class="tab-content">

        @foreach ($locales as $lang)

            <div class="tab-pane fade @if($locale == $lang)in active @endif" id="content-{{ $lang }}">
                <div class="row">
                    <div class="col-md-6">
                        {!! BootForm::text(trans('validation.attributes.title'), $lang.'[title]') !!}
                    </div>
                    @include('core::form._slug')
                </div>
                {!! BootForm::checkbox(trans('validation.attributes.online'), $lang.'[status]') !!}
                {!! BootForm::textarea(trans('validation.attributes.body'), $lang.'[body]')->addClass('editor') !!}
            </div>

        @endforeach

        </div>

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
