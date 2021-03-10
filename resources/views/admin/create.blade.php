@extends('core::admin.master')

@section('title', __('New place'))

@section('content')

    <div class="header">
        @include('core::admin._button-back', ['module' => 'places'])
        <h1 class="header-title">@lang('New place')</h1>
    </div>

    {!! BootForm::open()->action(route('admin::index-places'))->multipart()->role('form') !!}
        @include('places::admin._form')
    {!! BootForm::close() !!}

@endsection
