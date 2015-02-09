@extends('layouts.forum')

@section('content')



    <div class="panel panel-primary">
        <div class="panel-heading panel-heading-primary">
            Create a post
        </div>
        <div class="panel-body">

            @include('partials.errors')

            {!! Form::open(['class' => 'form-horizontal']) !!}
                <div class="form-group @if($errors->has('title')) has-error @endif">
                     {!! Form::label('title', 'Title', ['class' => 'col-sm-1 control-label']) !!}
                    <div class="col-sm-11">
                        {!! Form::text('title', null, ['class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="form-group @if($errors->has('message')) has-error @endif">
                    {!! Form::label('message', 'Message', ['class' => 'col-sm-1 control-label']) !!}
                    <div class="col-sm-11">
                        {!! Form::textarea('message', null, ['class' => 'form-control', 'rows' => 5]) !!}
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::label('category', 'Category', ['class' => 'col-sm-1 control-label']) !!}
                    <div class="col-sm-11">
                        {!! Form::select('category',$categories->lists('name', 'id'),null,['class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="form-group margin-none">
                    <div class="col-sm-offset-1 col-sm-11">
                        <button type="submit" class="btn btn-primary">Create</button>
                    </div>
                </div>
            {!! Form::close() !!}
        </div>
    </div>

@stop