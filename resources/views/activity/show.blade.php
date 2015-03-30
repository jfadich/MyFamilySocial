@extends('layouts.master')


@section('content')

    @include('partials.heading', ['title' => 'Recent Activity'])

    <div class="timeline row" data-toggle="isotope">
        @foreach($activity as $action)

            @include('activity.types.'.$action->name)

        @endforeach
    </div>

    <hr>

    <div class="text-center col-xs-12">
        {!! $activity->render() !!}
    </div>
@endsection