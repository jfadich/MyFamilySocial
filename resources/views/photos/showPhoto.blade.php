@extends('layouts.photos')

@section('content')
    <div class="panel panel-default text-center">
        <div class="panel-heading">
            {{ $photo->name }}

            @include('partials.editIcons', ['editUrl' => $photo->present()->url('edit')])
        </div>
        <div class="panel-body">
            <img src="{{ $photo->present()->url('image', 'large') }}" class="img-responsive center-block" alt="cover">
        </div>
        <div class="panel-footer text-left">

            Posted in {!! $photo->imageable->present()->link( $photo->imageable->present()->title ) !!}
            by {!! $photo->owner->present()->link($photo->owner->first_name) !!}
            on {{ $photo->present()->created_at }}

            @include('partials.tags', ['tags' =>$photo->tags])

            <div class="pull-right">
                <a href="{{ $photo->present() ->url('image', 'full')}}" class="btn btn-primary btn-sm" download>
                    <i class="fa fa-arrow-circle-down"></i> Download Photo</a>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>

    <div class="row">
        {!! Form::open() !!}
        <div class="col-md-8">
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
        </div>
        {!! Form::close() !!}

        <div class="col-md-4">
            <section class="panel panel-default">
                <div class="panel-heading panel-default">
                    In this photo:
                </div>
                <div class="panel-body">

                    <div class="img-grid">
                        @unless(count($photo->tagged_users) == 0)
                            @foreach($photo->tagged_users as $user)
                                <a href="{{ $user->present()->url }}" title="{{ $user->present()->full_name }}">
                                    {!! $user->present()->profile_picture('small') !!}
                                </a>
                            @endforeach
                        @endunless
                    </div>

                    <hr>

                    {!! Form::open(['method' => 'PATCH',
                    'action' => ['PhotosController@tagUsers', $photo->id]]) !!}
                    <div class="form-group col-sm-12">

                        {!! Form::hidden('user_tag', null , ['id' => 'user_tag', 'style' =>
                        'width:100%;']) !!}

                    </div>

                    <div class="form-group col-sm-12">
                        <span class="input-group-btn-vertical">
                            <button class="form-control btn-primary btn-stroke" type="submit"><i class="fa fa-plus"></i>
                            </button>
                        </span>
                    </div>
                    {!! Form::close() !!}
            </section>
        </div>
    </div>

    @include('partials.comments', ['comments' => $photo->comments])


@endsection


@section('pageFooter')

    <script type="text/javascript">

        $('#user_tag').select2(
                {
                    placeholder: 'Tag a user',
                    minimumInputLength: 1,
                    tags: true,
                    ajax: {
                        url: "{{ URL::to('profile/search/') }}",
                        dataType: 'json',
                        type: 'get',
                        quietMillis: 250,
                        data: function (term) {
                            return {term: term} // search term
                        },
                        results: function (data) { // parse the results into the format expected by Select2.
                            console.log(data);
                            return {results: data};
                        },
                        cache: true
                    },
                    initSelection: function (element, callback) {
                        var data = [];
                        $(element.val().split(",")).each(function () {
                            data.push({id: this, text: this});
                        });
                        callback(data);
                    }
                });
    </script>

@endsection