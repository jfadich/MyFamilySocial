@extends('layouts.forum')

@section('content')
    <div class="container-fluid">

        <div class="panel panel-default">
            <div class="panel-body">
                @if(isset($heading))
                    <h2>{{ $heading->name }}</h2>
                    <p class="lead">
                        {{ $heading->description }}
                    </p>
                @else
                    <h2>All Discussions</h2>
                @endif
            </div>
        </div>

        @foreach($threads as $thread)

            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="media">
                        <div class="media-left">
                            <p>
                                <a href="">
                                    {!! $thread->owner->present()->profile_picture('small', ['class' => 'media-object'])
                                    !!}
                                </a>
                            </p>
                        </div>
                        <div class="media-body">
                            <div class="pull-right">
                                <small class="text-grey-400"><i
                                            class="fa fa-clock-o fa-fw"></i> {{ $thread->present()->updated_at }}
                                </small>
                                <a href="{{ $thread->present()->url }}" class="text-primary"><i
                                            class="fa fa-comments fa-fw"></i>
                                    <strong>{{ $thread->replyCount }}</strong></a>
                            </div>
                            <h4 class="media-heading margin-v-0-10">
                                {!! $thread->present()->link($thread->title) !!}
                            </h4>

                            <p class="margin-none">Posted by {!! $thread->owner->present()->link(
                                $thread->owner->present()->full_name) !!}
                                in
                                {!! $thread->category->present()->link($thread->category->name) !!}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

        @endforeach

        <div class="text-center"> {!! $threads->render() !!}</div>

    </div>
@stop