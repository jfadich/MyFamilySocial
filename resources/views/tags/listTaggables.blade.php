@extends('layouts.master')

@section('content')
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