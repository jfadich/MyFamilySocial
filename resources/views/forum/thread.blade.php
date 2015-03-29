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
                    @if(UAC::canCurrentUser('ModifyForumThread', $thread))
                        @include('partials.editIcons', ['editUrl' => $thread->present()->url('edit')])
                    @endif

                    {{ $thread->body }}

                </div>
            </div>

        </div>
        <div class="panel-footer panel-footer-primary">
            <div class="pull-right">
                <small class="text-muted">{{ $thread->present()->created_at }}</small>
            </div>
            Posted in {!! $thread->category->present()->link($thread->category->name) !!}
            by {!! link_to($thread->owner->present()->url, $thread->owner->first_name) !!}
            @unless($thread->tags->count() == 0)

            {!! $thread->present()->tags() !!}

            @endunless
        </div>
    </div>
        @unless(empty($thread->replies))

            <?php $replies = $thread->replies()->with('owner')->paginate(10); ?>


                    @include('forum._threadReplyForm')

                @include('partials.comments', ['comments' => $thread->replies])
            </div>

            <div class="text-center">
                {!! $replies->render() !!}
            </div>

        @endunless
@stop