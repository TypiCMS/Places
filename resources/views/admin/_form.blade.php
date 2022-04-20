@push('js')
    <script src="{{ asset('components/ckeditor4/ckeditor.js') }}"></script>
    <script src="{{ asset('components/ckeditor4/config-full.js') }}"></script>
    <script src="{{ asset('js/admin.gmaps.js') }}"></script>
@endpush

<div class="header">
    @include('core::admin._button-back', ['url' => $model->indexUrl(), 'title' => __('Places')])
    @include('core::admin._title', ['default' => __('New place')])
    @component('core::admin._buttons-form', ['model' => $model])
    @endcomponent
</div>

<div class="content">

    @include('core::admin._form-errors')

    {!! BootForm::hidden('id') !!}

    <file-manager related-table="{{ $model->getTable() }}" :related-id="{{ $model->id ?? 0 }}"></file-manager>
    <file-field type="image" field="image_id" :init-file="{{ $model->image ?? 'null' }}"></file-field>
    <files-field :init-files="{{ $model->files }}"></files-field>

    @include('core::form._title-and-slug')
    <div class="mb-3">
        {!! TranslatableBootForm::hidden('status')->value(0) !!}
        {!! TranslatableBootForm::checkbox(__('Published'), 'status') !!}
    </div>

    <div class="row gx-3">
        <div class="col-sm-6">
            {!! BootForm::email(__('Email'), 'email') !!}
        </div>
        <div class="col-sm-6">
            {!! BootForm::text(__('Website'), 'website')->placeholder('https://') !!}
        </div>
    </div>

    <div class="row gx-3">
        <div class="col-sm-6">
            {!! BootForm::text(__('Phone'), 'phone') !!}
        </div>
    </div>

    {!! BootForm::textarea(__('Address'), 'address')->rows(4) !!}

    <div class="row gx-3">
        <div class="col-sm-6">
            {!! BootForm::text(__('Latitude'), 'latitude') !!}
        </div>
        <div class="col-sm-6">
            {!! BootForm::text(__('Longitude'), 'longitude') !!}
        </div>
    </div>

    {!! TranslatableBootForm::textarea(__('Summary'), 'summary')->rows(4) !!}
    {!! TranslatableBootForm::textarea(__('Body'), 'body')->addClass('ckeditor-full') !!}

</div>
