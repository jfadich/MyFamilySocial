    {!! Form::hidden('thread_id', $thread->id) !!}
<div class="form-group @if($errors->has('title')) has-error @endif">
    {!! Form::label('title', 'Title', ['class' => 'col-sm-1 control-label']) !!}
    <div class="col-sm-11">
        {!! Form::text('title', $thread->title, ['class' => 'form-control']) !!}
    </div>
</div>
<div class="form-group @if($errors->has('body')) has-error @endif">
    {!! Form::label('message', 'Message', ['class' => 'col-sm-1 control-label']) !!}
    <div class="col-sm-11">
        {!! Form::textarea('body', $thread->body, ['class' => 'form-control', 'rows' => 5]) !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('category', 'Category', ['class' => 'col-sm-1 control-label']) !!}
    <div class="col-sm-11">
        {!! Form::select('category',$categories->lists('name', 'id'),null,['class' => 'form-control']) !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('tags', 'Tags', ['class' => 'col-sm-1 control-label']) !!}
    <div class="col-sm-11">
         {!! Form::hidden('tags', implode(',', $thread->tags()->lists('name')) , ['id' => 'tags', 'style' => 'width:100%;']) !!}

    </div>

</div>
<div class="form-group margin-none">
    <div class="col-sm-offset-1 col-sm-11">
        <button type="submit" class="btn btn-primary">{{ $submitText }}</button>
    </div>
</div>


@section('pageFooter')

    <script type="text/javascript">
        $('#tags').select2(
                {
                    placeholder: 'Choose a tag',
                    minimumInputLength: 1,
                    tags:true,
                    ajax:
                    {
                        url: "{{ URL::to('tags/search/') }}",
                        dataType: 'json',
                        type: 'get',
                        quietMillis: 250,
                        data: function (term)
                        {
                            return {term: term} // search term
                        },
                        results: function (data)
                        { // parse the results into the format expected by Select2.
                            console.log(data);
                            return {results: data};
                        },
                        cache:false
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