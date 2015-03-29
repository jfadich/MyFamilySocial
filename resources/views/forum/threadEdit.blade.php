@extends('layouts.forum')

@section('content')



    <div class="panel panel-primary">
        <div class="panel-heading panel-heading-primary">
            <strong>Edit</strong>
        </div>
        <div class="panel-body">

            @include('partials.errors')

            {!! Form::open(['class' => 'form-horizontal', 'method' => 'PATCH',
            'action' => ['ForumController@update',$thread->slug]]) !!}

            @include('forum._threadForm', ['submitText' => 'Save Topic'])

            {!! Form::close() !!}

        </div>
    </div>

@stop