@extends('layouts.forum')

@section('content')

        <h1>{{ $thread->title }}</h1>
        <div class="media-body message">
            <div class="panel panel-default">
                <div class="panel-body">
                    {{ $thread->body }}
                </div>
                <div class="panel-footer panel-footer-primary">
                    <div class="pull-right">
                        <small class="text-muted">{{ $thread->created_at }}</small>
                    </div>
                    Posted in <a href="{{ URL::to('forum/'. $thread->category->slug) }}">{{ $thread->category->name }}</a> by {{ $thread->owner->first_name }}
                </div>
            </div>
        </div>

@stop