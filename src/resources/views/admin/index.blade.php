@extends('core::admin.master')

@section('title', __('places::global.name'))

@section('content')

<div ng-app="typicms" ng-cloak ng-controller="ListController">

    @include('core::admin._button-create', ['module' => 'places'])

    <h1>@lang('places::global.name')</h1>

    <div class="btn-toolbar">
        @include('core::admin._lang-switcher')
    </div>

    <div class="table-responsive">

        <table st-persist="placesTable" st-table="displayedModels" st-safe-src="models" st-order st-filter class="table table-condensed table-main">
            <thead>
                <tr>
                    <th class="delete"></th>
                    <th class="edit"></th>
                    <th st-sort="status" class="status st-sort">{{ __('Status') }}</th>
                    <th st-sort="image" class="image st-sort">{{ __('Image') }}</th>
                    <th st-sort="title" st-sort-default="true" class="title st-sort">{{ __('Title') }}</th>
                    <th st-sort="address" class="address st-sort">{{ __('Address') }}</th>
                    <th st-sort="website" class="website st-sort">{{ __('Website') }}</th>
                </tr>
                <tr>
                    <td colspan="4"></td>
                    <td>
                        <input st-search="title" class="form-control input-sm" placeholder="@lang('Search')…" type="text">
                    </td>
                    <td>
                        <input st-search="address" class="form-control input-sm" placeholder="@lang('Search')…" type="text">
                    </td>
                    <td>
                        <input st-search="website" class="form-control input-sm" placeholder="@lang('Search')…" type="text">
                    </td>
                </tr>
            </thead>

            <tbody>
                <tr ng-repeat="model in displayedModels">
                    <td typi-btn-delete action="delete(model)"></td>
                    <td>
                        @include('core::admin._button-edit', ['module' => 'places'])
                    </td>
                    <td typi-btn-status action="toggleStatus(model)" model="model"></td>
                    <td>
                        <img ng-src="@{{ model.thumb }}" alt="">
                    </td>
                    <td>@{{ model.title }}</td>
                    <td>@{{ model.address }}</td>
                    <td>@{{ model.website }}</td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="8" typi-pagination></td>
                </tr>
            </tfoot>
        </table>

    </div>

</div>

@endsection
