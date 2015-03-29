@extends('layouts.photos')

@section('content')

    <div class="panel panel-default text-center">
        <div class="panel-heading">
            {{ $photo->name }}
        </div>
        <div class="panel-body">
            <img src="{{ $photo->present()->url('image', 'large') }}" class="img-responsive center-block" alt="cover">
        </div>
        <div class="panel-footer text-left">
            <a href="{{ $photo->present() ->url('image', 'full')}}" class="btn btn-primary" download> <i
                        class="fa fa-arrow-circle-down"></i> Download Photo</a>

            <div class="pull-right">{{ $photo->present()->created_at }}</div>
        </div>
    </div>

    {!! Form::open() !!}

    <section class="panel panel-default" id="add-comment">
        <div class="form-group @if($errors->has('comment')) has-error @endif">
            {!! Form::textarea('comment', null, ['class' => 'form-control', 'rows' => 3]) !!}
        </div>

        <div class="form-group">
            <div class="input-group-btn-vertical">
                {!! Form::submit('Add Reply', ['class' => 'form-control btn-primary btn-stroke']) !!}
            </div>
        </div>
    </section>

    {!! Form::close() !!}

    @include('partials.comments', ['comments' => $photo->comments])


@endsection