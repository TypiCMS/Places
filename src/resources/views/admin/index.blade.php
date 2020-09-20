@extends('core::admin.master')

@section('title', __('Places'))

@section('content')

<item-list
    url-base="/api/places"
    locale="{{ config('typicms.content_locale') }}"
    fields="id,image_id,address,status,title"
    table="places"
    title="places"
    include="image"
    appends="thumb"
    :searchable="['title']"
    :sorting="['-id']">

    <template slot="add-button" v-if="$can('create places')">
        @include('core::admin._button-create', ['module' => 'places'])
    </template>

    <template slot="columns" slot-scope="{ sortArray }">
        <item-list-column-header name="checkbox" v-if="$can('update places')||$can('delete places')"></item-list-column-header>
        <item-list-column-header name="edit" v-if="$can('update places')"></item-list-column-header>
        <item-list-column-header name="status_translated" sortable :sort-array="sortArray" :label="$t('Status')"></item-list-column-header>
        <item-list-column-header name="image" :label="$t('Image')"></item-list-column-header>
        <item-list-column-header name="title_translated" sortable :sort-array="sortArray" :label="$t('Title')"></item-list-column-header>
    </template>

    <template slot="table-row" slot-scope="{ model, checkedModels, loading }">
        <td class="checkbox" v-if="$can('update places')||$can('delete places')"><item-list-checkbox :model="model" :checked-models-prop="checkedModels" :loading="loading"></item-list-checkbox></td>
        <td v-if="$can('update places')">@include('core::admin._button-edit', ['module' => 'places'])</td>
        <td><item-list-status-button :model="model"></item-list-status-button></td>
        <td><img :src="model.thumb" alt="" height="27"></td>
        <td>@{{ model.title_translated }}</td>
    </template>

</item-list>

@endsection
