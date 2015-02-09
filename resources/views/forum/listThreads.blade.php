@extends('layouts.forum')

@section('content')

    <div class="panel panel-primary">

        @if(isset($category))
            <div class="panel-heading">{{ $category->name }}</div>
            <div class="panel-body">
                <p>{{ $category->description }}</p>
            </div>
        @else
            <div class="panel-heading">All Discussions</div>
        @endif

        <div class="list-group">
                @foreach($threads as $thread)
                    <div class="list-group-item">
                        <div class="media">
                            <div class="media-left">
                                <a href="">
                                    <img src="http://lorempixel.com/50/50/people/" class="media-object">
                                </a>
                            </div>
                            <div class="media-body">
                                <h4 class="list-group-item-heading"><a href="{{ URL::to($thread->url) }}">{{ $thread->title }}</a> <span class="badge pull-right">{{ $thread->replyCount }}</span></h4>
                                <p class="list-group-item-text">Posted by <a href="{{ url('profile/'.$thread->owner->id) }}">{{ $thread->owner->first_name }} {{ $thread->owner->last_name }}</a> in <a href="{{ URL::to('/forum/'.$thread->category->slug) }}">{{ $thread->category->name }}</a> at {{ $thread->created_at }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
        </div>

    </div>
    <div class="text-center"> {!! $threads->render() !!} </div>
@stop