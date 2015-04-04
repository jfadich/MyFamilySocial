@extends(($action->target_type == 'MyFamily\User') ? 'partials.cards.Photo' : 'partials.cards.Album',
 ['card' => ($action->target_type == 'MyFamily\User') ? $action->subject : $action->target])

@section('cardTop')

    <div class="panel-body">
        <i class="md-filter"></i>

        {!! $action->actor->present()->link($action->actor->first_name) !!}

        @if($action->target_type == 'MyFamily\User')

            updated their profile picture  {{ $action->updated_at->diffForHumans() }}

        @else

            uploaded {{ $action->activity_count > 1 ? $action->activity_count . ' photos' : ' a photo' }} to
            {!!
            $action->target->present()->link($action->target->present()->name)
            !!} {{ $action->updated_at->diffForHumans() }}

        @endif
    </div>

@overwrite
