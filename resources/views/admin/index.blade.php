@extends('core::admin.master')

@section('title', __('Places'))

@section('content')
    <item-list url-base="/api/places" fields="id,image_id,address,status,title" table="places" title="places" include="image" :exportable="true" :searchable="['title']" :sorting="['-id']">
        <template #add-button v-if="$can('create places')">
            @include('core::admin._button-create', ['module' => 'places'])
        </template>

        <template #columns="{ sortArray }">
            <item-list-column-header name="checkbox" v-if="$can('update places')||$can('delete places')"></item-list-column-header>
            <item-list-column-header name="edit" v-if="$can('update places')"></item-list-column-header>
            <item-list-column-header name="status_translated" sortable :sort-array="sortArray" :label="$t('Status')"></item-list-column-header>
            <item-list-column-header name="image" :label="$t('Image')"></item-list-column-header>
            <item-list-column-header name="title_translated" sortable :sort-array="sortArray" :label="$t('Title')"></item-list-column-header>
        </template>

        <template #table-row="{ model, checkedModels, loading }">
            <td class="checkbox" v-if="$can('update places')||$can('delete places')">
                <item-list-checkbox :model="model" :checked-models-prop="checkedModels" :loading="loading"></item-list-checkbox>
            </td>
            <td v-if="$can('update places')">
                <item-list-edit-button :url="'/admin/places/' + model.id + '/edit'"></item-list-edit-button>
            </td>
            <td>
                <item-list-status-button :model="model"></item-list-status-button>
            </td>
            <td><img :src="model.thumb" alt="" height="27" /></td>
            <td v-html="model.title_translated"></td>
        </template>
    </item-list>
@endsection
