@extends('partials.cards.Photo', ['card' => $action->subject])

@section('cardTop')

    <div class="panel-body">
        <i class="md-filter"></i>

        {!! $action->actor->present()->link($action->actor->first_name) !!}

        @if($action->target_type == 'MyFamily\User')

            updated their profile picture

        @else

            uploaded {{ $action->activity_count > 1 ? $action->activity_count . ' photos' : ' a photo' }} to
            {!!
            $action->target->present()->link($action->target->present()->name) !!}

        @endif
    </div>

@overwrite
