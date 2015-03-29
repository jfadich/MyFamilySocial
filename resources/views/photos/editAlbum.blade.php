@extends('layouts.photos')

@section('content')

    <div class="panel panel-primary">
        <div class="panel-heading panel-heading-primary">
            <strong>Edit</strong>
        </div>
        <div class="panel-body">

            @include('partials.errors')

            {!! Form::open(['class' => 'form-horizontal', 'method' => 'PATCH',
            'action' => ['AlbumsController@update',$album->slug]]) !!}

            @include('photos._albumForm', ['submitText' => 'Edit Album'])

            {!! Form::close() !!}

        </div>
    </div>

@stop