@extends('partials.cards.Album',
 ['card' => $action->target, 'photos' => $action->target->photos()->where('created_at', '<=', $action->created_at)->where('owner_id', '=',$action->actor->id)->latest()->take(min($action->activity_count,4))->get()])

@section('cardTop')

    <div class="panel-body">
        <i class="md-filter"></i>

        {!! $action->actor->present()->link($action->actor->first_name) !!}

            uploaded {{ $action->activity_count > 1 ? $action->activity_count . ' photos' : ' a photo' }} to
            {!!
            $action->target->present()->link($action->target->present()->name)
            !!} {{ $action->updated_at->diffForHumans() }}

    </div>

@overwrite
