@extends('layouts.master')

@section('content')
    <h1>All Discussions</h1>

    @foreach($threads as $thread)
    <div class="media-body message">
        <div class="panel panel-default">
            <div class="panel-body">
                {{ $thread->title }}
            </div>
            <div class="panel-footer panel-footer-primary">
                <div class="pull-right">
                    <small class="text-muted">{{ $thread->created_at }}</small>
                </div>
                Posted in {{ $thread->category->name }} by {{ $thread->owner->first_name }}
            </div>
        </div>
    </div>
    @endforeach
@stop