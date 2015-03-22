{!! Form::open() !!}

<section class="panel panel-default" id="add-comment">
    <div class="panel-heading">
        Add your voice
    </div>
    <div class="panel-body">
        <div class="form-group @if($errors->has('comment')) has-error @endif">
            {!! Form::textarea('comment', null, ['class' => 'form-control', 'rows' => 3]) !!}
        </div>

        <div class="form-group">
            <div class="input-group-btn-vertical">
                {!! Form::submit('Add Reply', ['class' => 'form-control btn-primary btn-stroke']) !!}
            </div>
        </div>
            </div>
</section>

{!! Form::close() !!}