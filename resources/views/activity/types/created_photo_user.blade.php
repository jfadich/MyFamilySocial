@extends('partials.cards.Photo',
['card' => $action->subject])

@section('cardTop')

    <div class="panel-body">
        <i class="md-filter"></i>

        {!! $action->actor->present()->link($action->actor->first_name) !!}

        uploaded their profile picture {{ $action->updated_at->diffForHumans() }}

    </div>

@overwrite
