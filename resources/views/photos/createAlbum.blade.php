@extends('layouts.photos')

@section('content')



    <div class="panel panel-primary">
        <div class="panel-heading panel-heading-primary">
            Create an album
        </div>
        <div class="panel-body">

            @include('partials.errors')

            {!! Form::open(['class' => 'form-horizontal', 'action' => ['AlbumsController@store']]) !!}

            @include('photos._albumForm', ['submitText' => 'Create Album', 'album' => new \MyFamily\Album()])

            {!! Form::close() !!}

        </div>
    </div>

@stop
