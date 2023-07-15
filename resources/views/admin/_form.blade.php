@push('js')
    <script type="module" src="{{ asset('components/ckeditor4/ckeditor.js') }}"></script>
    <script type="module" src="{{ asset('components/ckeditor4/config-full.js') }}"></script>
    <script>
        window.addEventListener('DOMContentLoaded', (event) => {
            document.getElementById('geocode-button').addEventListener('click', () => {
                const addressInput = document.getElementById('address');
                const address = addressInput.value;
                if (address !== '') {
                    getLonLatFromAddress(address);
                } else {
                    document.getElementById('latitude').value = '';
                    document.getElementById('longitude').value = '';
                }

                async function getLonLatFromAddress(address) {
                    const url = `https://nominatim.openstreetmap.org/?format=json&addressdetails=1&q=${address}&limit=1`;
                    try {
                        const response = await fetch(url);
                        if (response.ok) {
                            const data = await response.json();
                            if (data.length > 0) {
                                const info = data[0];
                                document.getElementById('latitude').value = info.lat;
                                document.getElementById('longitude').value = info.lon;
                            }
                        } else {
                            throw new Error('Network response was not ok.');
                        }
                    } catch (error) {
                        console.error('Error:', error);
                    }
                }
            });
        });
    </script>
@endpush

<div class="header">
    @include('core::admin._button-back', ['url' => $model->indexUrl(), 'title' => __('Places')])
    @include('core::admin._title', ['default' => __('New place')])
    @component('core::admin._buttons-form', ['model' => $model])
    @endcomponent
</div>

<div class="content">
    @include('core::admin._form-errors')

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
            {!! BootForm::email(__('Email'), 'email')->autocomplete('off') !!}
        </div>
        <div class="col-sm-6">
            {!! BootForm::text(__('Website'), 'website')->placeholder('https://') !!}
        </div>
    </div>

    <div class="row gx-3">
        <div class="col-sm-6">
            {!! BootForm::text(__('Phone'), 'phone')->autocomplete('off') !!}
        </div>
    </div>

    {!! BootForm::textarea(__('Address'), 'address')->rows(4)->autocomplete('off') !!}

    <div class="row gx-3">
        <div class="col-md-5">
            {!! BootForm::text(__('Latitude'), 'latitude') !!}
        </div>
        <div class="col-md-5">
            {!! BootForm::text(__('Longitude'), 'longitude') !!}
        </div>
        <div class="col-md-2">
            <div class="mb-3">
                <label class="form-label" for="geocode-button">&nbsp;</label>
                <p class="mb-0">
                    <button class="btn btn-secondary w-100" id="geocode-button" type="button">Chercher</button>
                </p>
            </div>
        </div>
    </div>

    {!! TranslatableBootForm::textarea(__('Summary'), 'summary')->rows(4) !!}
    {!! TranslatableBootForm::textarea(__('Body'), 'body')->addClass('ckeditor-full') !!}
</div>
