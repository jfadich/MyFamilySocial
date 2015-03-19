@extends('layouts.master')

@section('content')
    {!! Form::open(['files' => true, 'class' => 'form-horizontal', 'action' => ['PhotosController@store']]) !!}

    {!! Form::file('photo') !!}

    {!! Form::submit('Upload') !!}

    {!! Form::close() !!}
@endsection