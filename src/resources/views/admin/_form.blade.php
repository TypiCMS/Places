@section('js')
    <script src="{{ asset('components/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('js/admin/form.js') }}"></script>
    <script src="{{ asset('//maps.googleapis.com/maps/api/js?language='.config('app.locale')) }}"></script>
    <script src="{{ asset('js/admin/gmaps.js') }}"></script>
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
                @include('core::form._title-and-slug')
                <input type="hidden" name="{{ $lang }}[status]" value="0">
                {!! BootForm::checkbox(trans('validation.attributes.online'), $lang.'[status]') !!}
                {!! BootForm::textarea(trans('validation.attributes.summary'), $lang.'[summary]')->rows(4) !!}
                {!! BootForm::textarea(trans('validation.attributes.body'), $lang.'[body]')->addClass('ckeditor') !!}
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
