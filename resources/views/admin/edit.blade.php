@extends('core::admin.master')

@section('title', $model->presentTitle())

@section('content')
    {!! BootForm::open()->put()->action(route('admin::update-place', $model->id))->addClass('main-content') !!}
    {!! BootForm::bind($model) !!}
    @include('places::admin._form')
    {!! BootForm::close() !!}
@endsection
