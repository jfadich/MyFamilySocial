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
                <div class="pull-right text-muted">
                    <a href="{{ $card->present()->url() }}" class="pull-right" title="See full album">
                        <i class="icon-reply-all-fill fa fa-2x "></i></a>
                </div>
                {!! $card->present()->link($card->name) !!} {!! $card->owner->first_name !!}
                <small class="text-muted"> {{ $card->present()->updated_at }} </small>
            </div>
        </div>
    </div>

    <div class="panel-body">
        <div class="cover overlay" style="background: white;">
            <div>
                {!! Html::image($card->present()->url('image', 'card'),$card->name, ['class' => 'img-responsive
                img-thumbnail']) !!}
            </div>
            <div class="overlay overlay-full">
                <div class="v-top">
                    <a href="{{ $card->present()->url }}" class="btn btn-cover btn-xs"><i
                                class="fa fa-comments"></i></a>
                </div>
            </div>
        </div>

    </div>

    @include('partials.cards._comments', [
                                      'commentCount'  => $card->comments()->count(),
                                      'comments'      => $card->comments()->latest()->take(3)->get(),
                                      'commentsUrl'   => $card->present()->url,
                                      'formOptions'   => ['action' => ['PhotosController@addReply', $card->id]]])

@overwrite