@extends('layouts.forum')

@section('content')

    @if(isset($category))
        <h1>{{ $category->name }}</h1>
        <p>{{ $category->description }}</p>
    @else
        <h1>All Discussions</h1>
    @endif

    <div class="list-group">
        @foreach($threads as $thread)


            <div class="list-group-item">
                <h4 class="list-group-item-heading"><a href="{{ URL::to($thread->url) }}">{{ $thread->title }}</a> <span class="badge pull-right">{{ $thread->replies()->count() }}</span></h4>
                <p class="list-group-item-text">Posted by {{ $thread->owner->first_name }} {{ $thread->owner->last_name }} in <a href="{{ URL::to('/forum'.$thread->category->slug) }}">{{ $thread->category->name }}</a> at {{ $thread->created_at }}</p>
            </div>

        @endforeach
    </div>
    {!! $threads->render() !!}
@stop