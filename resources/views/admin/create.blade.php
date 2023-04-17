@extends('core::admin.master')

@section('title', __('New place'))

@section('content')

    {!! BootForm::open()->action(route('admin::index-places'))->multipart()->role('form') !!}
    @include('places::admin._form')
    {!! BootForm::close() !!}

@endsection
