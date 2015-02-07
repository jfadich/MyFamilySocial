<h4>Add a Reply</h4>

{!! Form::open() !!}

    <div class="form-group @if($errors->has('comment')) has-error @endif">
        {!! Form::textarea('comment', null, ['class' => 'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::submit('Add Comment', ['class' => 'form-control btn-primary']) !!}
    </div>

{!! Form::close() !!}