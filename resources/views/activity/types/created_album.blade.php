@extends('partials.cards.Album', ['card' => $action->subject])

@section('cardTop')
    <div class="panel-body">
        <i class="md-photo-album"></i> {!! $action->actor->present()->link($action->actor->first_name) !!} created an
        album {{ $action->updated_at->diffForHumans() }}
    </div>
@overwrite