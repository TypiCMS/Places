@extends('core::admin.master')

@section('title', __('New place'))

@section('content')

    @include('core::admin._button-back', ['module' => 'places'])
    <h1>
        @lang('New place')
    </h1>

    {!! BootForm::open()->action(route('admin::index-places'))->multipart()->role('form') !!}
        @include('places::admin._form')
    {!! BootForm::close() !!}

@endsection
