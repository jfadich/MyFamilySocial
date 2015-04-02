@extends('partials.cards.ForumThread', ['card' => $action->subject])

@section('cardTop')
    <div class="panel-body">
        <i class="md-subject"></i> {!! $action->actor->present()->link($action->actor->first_name) !!} started a
        discussion
    </div>
@overwrite
