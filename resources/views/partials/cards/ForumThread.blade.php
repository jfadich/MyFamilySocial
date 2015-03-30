@extends('partials.cards._blankCard')

@section('card')
    <div class="panel-heading">
        <div class="media">
            <div class="media-left">
                <a href="">
                    {!! $card->owner->present()->profile_picture('small', ['class' => 'img-block-small']) !!}
                </a>
            </div>
            <div class="media-body">
                <a href="{{ $card->present()->url() }}" class="pull-right text-muted"><i
                            class="icon-reply-all-fill fa fa-2x "></i></a>
                {!! $card->present()->link($card->title) !!} {!! $subTitle or $card->owner->first_name !!}
                <span class="text-muted">{{ $card->present()->updated_at }}</span>
            </div>
        </div>
    </div>
    <div class="panel-body">

        <p>{!! $card->present()->body(250) !!}</p>
    </div>

    @include('partials.cards._comments', ['commentCount'  => $card->replyCount,
                                          'comments'      => $card->replies()->latest()->take(3)->get(),
                                          'commentsUrl'   => $card->present()->url(),
                                          'formOptions'   => ['action' => ['ForumController@addReply', $card->slug]]])
@overwrite