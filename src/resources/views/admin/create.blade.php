@extends('core::admin.master')

@section('title', trans('places::global.New'))

@section('main')

    @include('core::admin._button-back', ['module' => 'places'])
    <h1>
        @lang('places::global.New')
    </h1>

    {!! BootForm::open()->action(route('admin::index-places'))->multipart()->role('form') !!}
        @include('places::admin._form')
    {!! BootForm::close() !!}

@endsection
