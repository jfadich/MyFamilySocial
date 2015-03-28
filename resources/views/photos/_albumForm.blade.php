<div class="row">
    <div class="col-xs-8 col-sm-10">
        <div class="form-group form-control-default @if($errors->has('name')) has-error @endif">

            {!! Form::label('name', 'Album Name') !!}
            {!! Form::text('name', $album->name, ['class' => 'form-control']) !!}

        </div>
    </div>

    <div class="col-xs-4 col-sm-2 text-center">

        {!! Form::label('shared', 'Shared') !!} <br>
        {!! Form::checkbox('shared',$album->shared,$album->shared, ['data-off-color' =>'warning', 'data-on-color' =>
        'success']) !!}

    </div>
</div>

<div class="form-group form-control-default @if($errors->has('description')) has-error @endif">
    {!! Form::label('description', 'Description') !!}
    {!! Form::textarea('description', $album->description, ['class' => 'form-control', 'rows' => 5]) !!}
</div>
<div class="form-group">
    {!! Form::label('tags', 'Tags', ['class' => 'col-sm-1 control-label']) !!}
    <div class="col-sm-11">
        {!! Form::hidden('tags', implode(',', $album->tags()->lists('name')) , ['id' => 'tags', 'style' =>
        'width:100%;']) !!}

    </div>

</div>

<div class="form-group margin-none">
    <div class="col-sm-offset-1 col-sm-11">
        <button type="submit" class="btn btn-primary">{{ $submitText }}</button>
    </div>
</div>


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