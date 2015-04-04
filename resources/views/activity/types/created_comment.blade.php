@extends('partials.cards.'.(new ReflectionClass($action->target))->getShortName(), ['card' => $action->target])

@section('cardTop')
    <div class="panel-body">
        <i class="md-insert-comment"></i> {!! $action->actor->present()->link($action->actor->first_name) !!} commented
        on this
    </div>
@overwrite

