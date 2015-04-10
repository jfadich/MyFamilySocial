@extends('layouts.photos')

@section('content')

    <div class="col-md-6 col-sm-12">
        <div class="panel-body">
            <img src="{{ $photo->present()->url('image', 'card') }}" class="img-responsive center-block">
        </div>
    </div>

    <div class="col-md-6 col-sm-12">
        <div class="panel panel-primary">
            <div class="panel-heading panel-heading-primary">
                <strong>Edit</strong>
            </div>
            <div class="panel-body">

                @include('partials.errors')

                {!! Form::open(['class' => 'form-horizontal', 'method' => 'PATCH',
                'action' => ['PhotosController@update',$photo->id]]) !!}

                <div class="row">
                    <div class="col-xs-8 col-sm-12">
                        <div class="form-group form-control-default @if($errors->has('name')) has-error @endif">

                            {!! Form::label('name', 'Title') !!}
                            {!! Form::text('name', $photo->name, ['class' => 'form-control']) !!}

                        </div>
                    </div>

                </div>

                <div class="form-group form-control-default @if($errors->has('description')) has-error @endif">
                    {!! Form::label('description', 'Description') !!}
                    {!! Form::textarea('description', $photo->description, ['class' => 'form-control', 'rows' => 5]) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('tags', 'Tags', ['class' => 'col-sm-1 control-label']) !!}
                    <div class="col-sm-11">
                        {!! Form::hidden('tags', implode(',', $photo->tags()->lists('name')) , ['id' => 'tags', 'style'
                        =>
                        'width:100%;']) !!}

                    </div>

                </div>

                <div class="form-group margin-none">
                    <div class="col-sm-offset-1 col-sm-11">
                        <button type="submit" class="btn btn-primary">Save Photo</button>
                    </div>
                </div>

                {!! Form::close() !!}

            </div>
        </div>
    </div>
@stop

@section('pageFooter')

    <script type="text/javascript">

        $("[name='shared']").bootstrapSwitch();

        $('#tags').select2(
                {
                    placeholder: 'Choose a tag',
                    minimumInputLength: 1,
                    tags: true,
                    ajax: {
                        url: "{{ URL::to('tags/search/') }}",
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
                        cache: false
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