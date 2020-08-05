@push('js')
    <script src="{{ asset('components/ckeditor4/ckeditor.js') }}"></script>
    <script src="{{ asset('components/ckeditor4/config-full.js') }}"></script>
    <script src="{{ asset('js/admin.gmaps.js') }}"></script>
@endpush

@component('core::admin._buttons-form', ['model' => $model])
@endcomponent

{!! BootForm::hidden('id') !!}

<file-manager related-table="{{ $model->getTable() }}" :related-id="{{ $model->id ?? 0 }}"></file-manager>
<file-field type="image" field="image_id" data="{{ $model->image }}"></file-field>
<files-field :init-files="{{ $model->files }}"></files-field>

<ul class="nav nav-tabs">
    <li class="nav-item">
        <a class="nav-link active" href="#tab-main" data-target="#tab-main" data-toggle="tab">{{ __('Content') }}</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#tab-info" data-target="#tab-info" data-toggle="tab">{{ __('Info') }}</a>
    </li>
</ul>

<div class="tab-content">

    {{-- Main tab --}}
    <div class="tab-pane fade show active" id="tab-main">

        @include('core::form._title-and-slug')
        <div class="form-group">
            {!! TranslatableBootForm::hidden('status')->value(0) !!}
            {!! TranslatableBootForm::checkbox(__('Published'), 'status') !!}
        </div>
        {!! TranslatableBootForm::textarea(__('Summary'), 'summary')->rows(4) !!}
        {!! TranslatableBootForm::textarea(__('Body'), 'body')->addClass('ckeditor-full') !!}

    </div>

    {{-- Info tab --}}
    <div class="tab-pane fade" id="tab-info">

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
