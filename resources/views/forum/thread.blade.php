@extends('layouts.forum')

@section('content')

    <div class="panel panel-primary">
        <div class="panel-heading panel-heading-primary">
            {{ $thread->title }}
        </div>
        <div class="panel-body">
            <div class="media">
                <div class="media-left">
                    <a href="">
                        <img src="http://lorempixel.com/50/50/people/" class="media-object">
                    </a>
                </div>
                <div class="media-body">

                    {{-- Edit Icons --}}
                    @if($thread->owner_id == \Auth::id())
                        @include('partials.editIcons')
                    @endif

                    {{ $thread->body }}
                </div>
            </div>

        </div>
        <div class="panel-footer panel-footer-primary">
            <div class="pull-right">
                <small class="text-muted">{{ $thread->created_at }}</small>
            </div>
            Posted in <a href="{{ URL::to('forum/'. $thread->category->slug) }}">{{ $thread->category->name }}</a> by <a href="{{ url('profile/'.$thread->owner->id) }}">{{ $thread->owner->first_name }}</a>
            @unless($thread->tags->count() == 0) Tags | {{ implode(', ', $thread->tags()->lists('name')) }} @endunless
        </div>

        @unless(empty($thread->replies))

            <?php $replies = $thread->replies()->with('owner')->paginate(10); ?>
                <ul class="comments media-list">

                    @include('forum._threadReplyForm')

                    @foreach($replies as $reply)
                            <li class="media">
                                <div class="media-left">
                                    <a href="">
                                        <img src="http://lorempixel.com/50/50/people/" class="media-object">
                                    </a>
                                </div>
                                <div class="media-body">

                                    {{-- Edit Icons --}}
                                    @if($reply->owner_id == \Auth::id())
                                        @include('partials.editIcons')
                                    @endif

                                    <a class="comment-author pull-left" href="{{ url('profile/'.$reply->owner->id) }}">{{ $reply->owner->first_name }}</a>
                                    <span>{{ $reply->body }}</span>
                                    <div class="comment-date">{{ $reply->created_at }}</div>

                                </div>
                            </li>
                    @endforeach
                </ul>
            </div>

            <div class="text-center">
                {!! $replies->render() !!}
            </div>

        @endunless
@stop