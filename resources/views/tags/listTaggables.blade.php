@extends('layouts.master')

@section('content')

    @include('partials.heading', ['title' => "Tag: $tag->name", 'lead' => $tag->description])

    <div class="timeline row" data-toggle="isotope">

        @foreach($taggables as $card)

                    @include('partials.cards.'.(new ReflectionClass($card))->getShortName() )

        @endforeach

    </div>
@endsection