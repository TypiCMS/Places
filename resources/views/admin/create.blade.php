@extends('core::admin.master')

@section('title', __('New place'))

@section('content')
    {!! BootForm::open()->action(route('admin::index-places'))->addClass('main-content') !!}
    @include('places::admin._form')
    {!! BootForm::close() !!}
@endsection
