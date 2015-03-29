@extends('layouts.master')

@section('content')
    <div class="panel panel-default">
        <div class="panel-body text-center">

            <h2>Tag: {{ $tag->name }}</h2>
            @unless(empty($tag->description))
                <p class="lead">
                    {{ $tag->description }}
                </p>
            @endunless
        </div>

    </div>
    <div class="timeline row" data-toggle="isotope">
        @foreach($taggables->shuffle()->chunk(3) as $cards)
            <div class="row">
                @foreach($cards as $card)

                    @include('partials.cards.'.(new ReflectionClass($card))->getShortName() )

                @endforeach
            </div>
        @endforeach
    </div>
@endsection