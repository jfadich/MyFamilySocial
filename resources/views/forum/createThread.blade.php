@extends('layouts.forum')

@section('content')

    <h1>Create a Post</h1>

    <div class="panel panel-default">
        <div class="panel-body">

            @if($errors->any())
                {{ print_r($errors) }}
                <ul class="alert alert-danger">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif

            <form class="form-horizontal" role="form" method="POST">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="form-group @if($errors->has('title')) has-error @endif">
                    <label for="title" class="col-sm-1 control-label">Title</label>
                    <div class="col-sm-11">
                        <input type="text" class="form-control" name="title" id="title" placeholder="Title here..">
                    </div>
                </div>
                <div class="form-group @if($errors->has('message')) has-error @endif">
                    <label for="title" class="col-sm-1 control-label">Message</label>
                    <div class="col-sm-11">
                        <textarea class="form-control" rows="5" name="message" placeholder="Post Content"></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label for="category" class="col-sm-1 control-label">Category</label>
                    <div class="col-sm-11">
                        <select class="form-control" name="category">
                            <option name="df" value="1">One</option>
                            <option name="df" value="2">Two</option>
                            <option name="df" value="3">Three</option>
                        </select>
                    </div>
                </div>
                <div class="form-group margin-none">
                    <div class="col-sm-offset-1 col-sm-11">
                        <button type="submit" class="btn btn-primary">Create</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@stop