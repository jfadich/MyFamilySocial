@extends('layouts.forum')

@section('content')

    @if(isset($category))
        <h1>{{ $category->name }}</h1>
        <p>{{ $category->description }}</p>
    @else
        <h1>All Discussions</h1>
    @endif

    @foreach($threads as $thread)
    <div class="media-body message">
        <div class="panel panel-default">
            <div class="panel-body">
                <a href="{{ URL::to('forum/'.$thread->category->slug.'/'.$thread->slug) }}"> {{ $thread->title }}</a>
            </div>
            <div class="panel-footer panel-footer-primary">
                <div class="pull-right">
                    <small class="text-muted">{{ $thread->created_at }}</small>
                </div>
                Posted in <a href="{{ URL::to('forum/'. $thread->category->slug) }}">{{ $thread->category->name }}</a> by {{ $thread->owner->first_name }}
            </div>
        </div>
    </div>
    @endforeach

    {!! $threads->render() !!}
@stop