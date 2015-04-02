@extends('partials.cards.Photo', ['card' => $action->subject])

@section('cardTop')
    <div class="panel-body">
        <i class="md-filter"></i> {!! $action->actor->present()->link($action->actor->first_name) !!}
        uploaded a photo to {!!
        $action->subject->imageable->present()->link($action->subject->imageable->present()->name) !!}
    </div>
@overwrite