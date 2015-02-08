{!! Form::open() !!}

    <li class="comment-form">

        <div class="form-group @if($errors->has('comment')) has-error @endif">
            {!! Form::textarea('comment', null, ['class' => 'form-control', 'rows' => 3]) !!}
        </div>

        <div class="form-group">
            <div class="input-group-btn-vertical">
                {!! Form::submit('Add Reply', ['class' => 'form-control btn-primary']) !!}
            </div>
        </div>

    </li>

{!! Form::close() !!}