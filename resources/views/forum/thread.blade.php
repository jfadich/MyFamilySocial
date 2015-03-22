@extends('layouts.forum')

@section('content')
    <div class="container-fluid" id="comments">
    <div class="panel panel-primary">
        <div class="panel-heading panel-heading-primary">
            {{ $thread->title }}
        </div>
        <div class="panel-body">
            <div class="media">
                <div class="media-left">

                    {!! $thread->owner->present()->profile_picture('small', ['class' => 'media-object']) !!}

                </div>
                <div class="media-body">

                    {{-- Edit Icons --}}
                    @if($thread->owner->id == \Auth::id())
                        @include('partials.editIcons', ['editUrl' => $thread->url.'/edit'])
                    @endif

                    {{ $thread->body }}

                </div>
            </div>

        </div>
        <div class="panel-footer panel-footer-primary">
            <div class="pull-right">
                <small class="text-muted">{{ $thread->created_at->format('m/d/Y') }}</small>
            </div>
            Posted in <a href="{{ URL::to('forum/category/'. $thread->category->slug) }}">{{ $thread->category->name }}</a> by <a href="{{ url('profile/'.$thread->owner->id) }}">{{ $thread->owner->first_name }}</a>
            @unless($thread->tags->count() == 0)
                @foreach($thread->tags as $tag)
                    <a href="{{ URL::to('forum/tags/'.$tag->slug) }}" class="label label-grey-100">
                        <i class="fa fa-tag"></i>&nbsp;{{ $tag->name }}
                        </a>
                @endforeach
            @endunless
        </div>
    </div>
        @unless(empty($thread->replies))

            <?php $replies = $thread->replies()->with('owner')->paginate(10); ?>


                    @include('forum._threadReplyForm')

                    @foreach($replies as $reply)

                    <section class="panel panel-default" id="comment-{{ $reply->id }}">
                        <div class="panel-body">
                            <div class="media">
                                <a class="media-left" href="">
                                    {!! $reply->owner->present()->profile_picture('small', ['class' => 'media-object'])
                                    !!}
                                    </a>

                                <div class="media-body">
                                    <small class="text-grey-400 pull-right">
                                        {{ $reply->created_at->format('m/d/Y') }}
                                    </small>
                                    <h5 class="media-heading margin-v-5"><a
                                                href="{{ url('profile/'.$reply->owner->id) }}">{{ $reply->owner->first_name }}</a>
                                    </h5>

                                    <p class="margin-none">{{ $reply->body }}</p>
                                </div>
                                </div>
                        </div>
                    </section>
                    @endforeach
    </div>
            </div>

            <div class="text-center">
                {!! $replies->render() !!}
            </div>

        @endunless
@stop