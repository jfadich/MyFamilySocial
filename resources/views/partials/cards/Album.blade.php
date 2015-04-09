@extends('partials.cards._blankCard')

@section('card')
    <div class="panel-heading">
        <div class="media">
            <div class="media-left">
                <a href="{{ $card->owner->present()->url }}">
                    {!! $card->owner->present()->profile_picture('small', ['class' => 'img-block-small']) !!}
                </a>
            </div>
            <div class="media-body">
                <div class="pull-right text-muted">
                    <a href="{{ $card->present()->url() }}" class="pull-right" title="See full album"><i
                                class="icon-reply-all-fill fa fa-2x "></i></a>
                    @if(!$card->shared)
                        <small class="pull-left" style="padding-right: 5px;" title="View only"><i
                                    class="fa fa-lock fa-2x"></i></small>
                    @endif
                </div>
                {!! $card->present()->link($card->name) !!} {!! $card->owner->first_name !!}
                <small class="text-muted"> {{ $card->present()->updated_at }} </small>
            </div>
        </div>
    </div>
    <div class="panel-body">

    <p>{{ $card->description }}</p>
        @unless(empty($photos))
            @foreach($photos as $photo)
            <div class="media md-col-3">
                <div class="cover overlay" style="background: white;">
                    <div class="img-thumbnail img-block-thumb">
                        {!! Html::image($photo->present()->url('image', 'thumb')) !!}
                    </div>
                    <div class="overlay overlay-full">
                        <div class="v-top">
                            <a href="{{ $photo->present()->url }}" class="btn btn-cover btn-xs"><i
                                        class="fa fa-comments"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        @endunless
    </div>
@overwrite

