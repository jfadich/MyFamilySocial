@extends('layouts.forum')

@section('content')



    <div class="panel panel-primary">
        <div class="panel-heading panel-heading-primary">
            Create a post
        </div>
        <div class="panel-body">

            @include('partials.errors')

            {!! Form::open(['class' => 'form-horizontal', 'action' => ['ForumController@store']]) !!}

                @include('forum._threadForm', ['submitText' => 'Add Topic', 'thread' => new \MyFamily\ForumThread()])

            {!! Form::close() !!}

        </div>
    </div>

@stop
